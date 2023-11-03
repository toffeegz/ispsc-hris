<?php

namespace App\Repositories\IpcrEvaluationItem;

use App\Models\IpcrEvaluationItem;
use Illuminate\Support\Carbon;
use App\Repositories\Base\BaseRepository;
use Illuminate\Support\Facades\Log;

class IpcrEvaluationItemRepository extends BaseRepository implements IpcrEvaluationItemRepositoryInterface
{

    /**
     * IpcrEvaluationItemRepository constructor.
     *
     * @param IpcrEvaluationItem $model
     */

    public function __construct(IpcrEvaluationItem $model)
    {
        parent::__construct($model);
    }
}
