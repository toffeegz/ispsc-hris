<?php

namespace App\Repositories\Opcr;

use App\Models\Opcr;
use Illuminate\Support\Carbon;
use App\Repositories\Base\BaseRepository;
use Illuminate\Support\Facades\Log;

class OpcrRepository extends BaseRepository implements OpcrRepositoryInterface
{

    /**
     * OpcrRepository constructor.
     *
     * @param Opcr $model
     */

    public function __construct(Opcr $model)
    {
        parent::__construct($model);
    }

    public function index(array $search = [], $ipcr_period_id = null, array $relations = [], string $sortByColumn = 'created_at', string $sortBy = 'DESC')
    {
        if($ipcr_period_id) {
            $this->model = $this->model->where('ipcr_period_id', $ipcr_period_id);
        }

        if($relations) {
            $this->model = $this->model->with($relations);
        }

        return $this->model->filter($search)->orderBy($sortByColumn, $sortBy)->paginate(request('limit') ?? 10);
    }
}
