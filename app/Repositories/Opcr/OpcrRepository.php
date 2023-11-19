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
}
