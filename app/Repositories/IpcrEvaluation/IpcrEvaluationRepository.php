<?php

namespace App\Repositories\IpcrEvaluation;

use App\Models\IpcrEvaluation;
use Illuminate\Support\Carbon;
use App\Repositories\Base\BaseRepository;
use Illuminate\Support\Facades\Log;

class IpcrEvaluationRepository extends BaseRepository implements IpcrEvaluationRepositoryInterface
{

    /**
     * IpcrEvaluationRepository constructor.
     *
     * @param IpcrEvaluation $model
     */

    public function __construct(IpcrEvaluation $model)
    {
        parent::__construct($model);
    }
}
