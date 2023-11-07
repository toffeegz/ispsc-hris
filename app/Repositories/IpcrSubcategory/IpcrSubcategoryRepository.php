<?php

namespace App\Repositories\IpcrSubcategory;

use App\Models\IpcrSubcategory;
use Illuminate\Support\Carbon;
use App\Repositories\Base\BaseRepository;
use Illuminate\Support\Facades\Log;

class IpcrSubcategoryRepository extends BaseRepository implements IpcrSubcategoryRepositoryInterface
{

    /**
     * IpcrSubcategoryRepository constructor.
     *
     * @param IpcrSubcategory $model
     */

    public function __construct(IpcrSubcategory $model)
    {
        parent::__construct($model);
    }

    public function index(array $search = [], $parent_id = null, array $relations = [], string $sortByColumn = 'created_at', string $sortBy = 'DESC')
    {
        if($parent_id != null) {
            $this->model = $this->model->where('parent_id', $parent_id);
        }
        if($relations) {
            $this->model = $this->model->with($relations);
        }

        return $this->model->filter($search)->orderBy($sortByColumn, $sortBy)->paginate(request('limit') ?? 10);
    }
}
