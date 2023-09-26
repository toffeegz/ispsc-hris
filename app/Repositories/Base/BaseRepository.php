<?php

namespace App\Repositories\Base;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use App\Repositories\Base\BaseRepositoryInterface;

class BaseRepository implements BaseRepositoryInterface
{

    /**
     * @var Model
     */
    protected $model;
    protected $moduleName;

    /**
     * BaseRepository constructor.
     *
     * @param Model $model
     */
 
    public function __construct(
        Model $model
    ) {
        $this->model = $model;
        $this->moduleName = str_replace("App\Models\\", '', get_class($this->model));
    }

    // LISTING
    public function lists(array $search = [], array $relations = [], string $sortByColumn = 'created_at', string $sortBy = 'DESC')
    {
        if($relations) {
            $this->model = $this->model->with($relations);
        }

        return $this->model->filter($search)->orderBy($sortByColumn, $sortBy)->paginate(request('limit') ?? 10);
    }

    // ARCHIVES
    public function archives(array $search = [], array $relations = [], string $sortByColumn = 'created_at', string $sortBy = 'DESC')
    {
        $this->model = $this->model->onlyTrashed();
        if($relations) {
            $this->model = $this->model->with($relations);
        }

        return $this->model->filter($search)->orderBy($sortByColumn, $sortBy)->paginate(request('limit') ?? 10);
    }

    protected function search($query, $params)
    {
        if ($params && isset($params['search'])) {
            // SEARCH
            $model = strtolower(str_replace('App\Models\\', '', get_class($this->model)));
            $searchConfig = config('search.' . $model);
            if ($searchConfig) {
                $query = $query->where(function ($query) use ($searchConfig, $params) {
                    $ctr = 0;
                    foreach ($searchConfig as $key => $column) {
                        // SINGLE WHERE HAS
                        if ($column === 'relation') {
                            $elements = explode('.', $key);
                            $sliced = array_slice($elements, 0, -1);
                            $imploded = implode('.', $sliced);

                            if ($ctr === 0) {
                                $query = $query->whereHas($imploded, function ($q) use ($elements, $params) {
                                    $q->where($elements[count($elements) - 1], 'LIKE', '%' . $params['search'] . '%');
                                });
                            } else {
                                $query = $query->orWhereHas($imploded, function ($q) use ($elements, $params) {
                                    $q->where($elements[count($elements) - 1], 'LIKE', '%' . $params['search'] . '%');
                                });
                            }
                        } // REGULAR STRING LIKE SEARCH
                        else {
                            if ($ctr === 0) {
                                $query = $query->where($key, 'LIKE', '%' . $params['search'] . '%');
                            } else {
                                $query = $query->orWhere($key, 'LIKE', '%' . $params['search'] . '%');
                            }
                        }

                        $ctr++;
                    }
                });
            }
        }

        return $query;
    }

    protected function paginate($query, $params)
    {
        if ($params && isset($params['page'])) {
            $limit = 15;
            // IF LIMIT PRESENT
            if (isset($params['limit'])) {
                $limit = $params['limit'];
            }

            return $query->paginate($limit);
        }

        // RETURN NO PAGINATION
        return $query->get();
    }

    // SHOW
    public function show(string $id, $with = [])
    {
        // INIT AUDIT LOG
        // $this->addAuditLogEntry(['id' => $id], 'Show');

        return $this->model->with($with)->withTrashed()->findOrFail($id);
    }

    // UPDATE
    public function update(array $params, string $id)
    {
        DB::beginTransaction();
        try {
            $result = $this->model->findOrFail($id);
            $result->update($params);
            DB::commit();

            return $this->model->findOrFail($id);
        } catch (\Exception $e) {
            DB::rollBack();

            return $e->getMessage();
        }
    }

    // STORE
    public function create(array $params)
    {
        DB::beginTransaction();
        try {
            $data = $this->model->create($params);
            DB::commit();

            return $data;
        } catch (\Exception $e) {
            DB::rollBack();

            return $e->getMessage();
        }
    }

    // public function updateOrCreate(array $refAttributes, array $attributes): Model
    // {
    //     DB::beginTransaction();
    //     try {
    //         $result = $this->model->updateOrCreate($refAttributes, $attributes);
    //         DB::commit();
    
    //         return $result;
    //     } catch (\Exception $e) {
    //         DB::rollBack();

    //         return $e->getMessage();
    //     }
    // }

    // // First OR CREATE
    // public function firstOrCreate(array $referenceParams, array $additionalParams = [])
    // {
    //     DB::beginTransaction();
    //     try {
    //         $result = $this->model->firstOrCreate($referenceParams, $additionalParams);
    //         DB::commit();
    
    //         return $result;
    //     } catch (\Exception $e) {
    //         DB::rollBack();

    //         return $e->getMessage();
    //     }
    // }

    public function delete(string $id)
    {
        DB::beginTransaction();
        try {
            $result = $this->model->findOrFail($id);

            $hasRelation = false;
            if(isset($relations)) {
                $hasRelation = $result->secureDelete($relations);
            }
            if($hasRelation === false) {
                $result->delete();
            }
            DB::commit();

            return $hasRelation == true ? false : $result;
        } catch (\Exception $e) {
            DB::rollBack();

            return $e->getMessage();
        }
    }

    public function restore(string $id)
    {
        DB::beginTransaction();
        try {
            $result = $this->model->onlyTrashed()->findOrFail($id);
            $result->restore();
            DB::commit();

            return $result;
        } catch (\Exception $e) {
            DB::rollBack();

            return $e->getMessage();
        }
    }
}
