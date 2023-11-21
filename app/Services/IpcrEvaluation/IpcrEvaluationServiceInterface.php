<?php

namespace App\Services\IpcrEvaluation;
use App\Repositories\IpcrEvaluation\IpcrEvaluationRepositoryInterface;

interface IpcrEvaluationServiceInterface
{
    public function create(array $attributes);
    public function processEvaluations($category, $evaluations, $evaluation_id);
}
