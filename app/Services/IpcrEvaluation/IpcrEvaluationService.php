<?php

namespace App\Services\IpcrEvaluation;

use Illuminate\Support\Facades\Log;
use App\Repositories\IpcrEvaluation\IpcrEvaluationRepositoryInterface;
use Illuminate\Support\Carbon;
use Illuminate\Validation\ValidationException;

class IpcrEvaluationService implements IpcrEvaluationServiceInterface
{
    private IpcrEvaluationRepositoryInterface $modelRepository;

    public function __construct(
        IpcrEvaluationRepositoryInterface $modelRepository,
    ) {
        $this->modelRepository = $modelRepository;
    }

    public function create(array $attributes)
    {
        try {
            // Create the main IPCR evaluation record
            $evaluation = IpcrEvaluation::create([
                'employee_id' => $attributes['employee_id'],
                'ipcr_period_id' => $attributes['ipcr_period_id'],
                'reviewed_by' => $attributes['reviewed_by'],
                'recommending_approval' => $attributes['recommending_approval'],
                // Add other attributes as needed
            ]);

            // Create IPCR evaluation items
            foreach ($attributes['evaluations'] as $evaluationData) {
                $evaluation->evaluations()->create([
                    'category_id' => $evaluationData['category_id'],
                    'subcategory_id' => $evaluationData['subcategory_id'],
                    'name' => $evaluationData['name'],
                    'order' => $evaluationData['order'],
                    'major_final_output' => $evaluationData['major_final_output'],
                    'performance_indicators' => $evaluationData['performance_indicators'],
                    'target_of_accomplishment' => $evaluationData['target_of_accomplishment'],
                    'actual_accomplishments' => $evaluationData['actual_accomplishments'],
                    'rating_q' => $evaluationData['rating_q'],
                    'rating_e' => $evaluationData['rating_e'],
                    'rating_t' => $evaluationData['rating_t'],
                    'remarks' => $evaluationData['remarks'],
                ]);
            }

            return $evaluation; // Return the created evaluation

        } catch (\Exception $exception) {
            throw ValidationException::withMessages([$exception->getMessage()]);
        }
    }
}
