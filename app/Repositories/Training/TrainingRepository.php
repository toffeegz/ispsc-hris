<?php

namespace App\Repositories\Training;

use App\Models\Training;
use Illuminate\Support\Carbon;
use App\Repositories\Base\BaseRepository;
use Illuminate\Support\Facades\Log;

class TrainingRepository extends BaseRepository implements TrainingRepositoryInterface
{

    /**
     * TrainingRepository constructor.
     *
     * @param Training $model
     */

    public function __construct(Training $model)
    {
        parent::__construct($model);
    }
}
