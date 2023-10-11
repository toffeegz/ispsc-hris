<?php

namespace App\Repositories\Position;

use App\Models\Position;
use Illuminate\Support\Carbon;
use App\Repositories\Base\BaseRepository;
use Illuminate\Support\Facades\Log;

class PositionRepository extends BaseRepository implements PositionRepositoryInterface
{

    /**
     * PositionRepository constructor.
     *
     * @param Position $model
     */

    public function __construct(Position $model)
    {
        parent::__construct($model);
    }
}
