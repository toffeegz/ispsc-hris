<?php

namespace App\Services\IpcrEvaluation;

use Illuminate\Support\Facades\Log;
use App\Repositories\IpcrEvaluation\IpcrEvaluationRepositoryInterface;
use Illuminate\Support\Carbon;
use Illuminate\Validation\ValidationException;
use App\Models\IpcrEvaluation;

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

            $totalRatingA = 0; // Initialize a variable to store the sum of rating_a values

            // Create IPCR evaluation items
            foreach ($attributes['evaluations'] as $evaluationData) {
                $rating_q = $evaluationData['rating_q'];
                $rating_e = $evaluationData['rating_e'];
                $rating_t = $evaluationData['rating_t'];

                // Calculate the average rating_a
                $rating_a = number_format(($rating_q + $rating_e + $rating_t) / 3, 2);

                $totalRatingA += $rating_a; // Add rating_a to the total

                $evaluation->evaluations()->create([
                    'category_id' => $evaluationData['category_id'],
                    'subcategory_id' => $evaluationData['subcategory_id'] ?? null, // Use null if subcategory_id is not present or is null
                    'name' => $evaluationData['name'],
                    'order' => $evaluationData['order'],
                    'major_final_output' => $evaluationData['major_final_output'],
                    'performance_indicators' => $evaluationData['performance_indicators'],
                    'target_of_accomplishment' => $evaluationData['target_of_accomplishment'],
                    'actual_accomplishments' => $evaluationData['actual_accomplishments'],
                    'rating_q' => $rating_q,
                    'rating_e' => $rating_e,
                    'rating_t' => $rating_t,
                    'rating_a' => $rating_a, // Set the calculated rating_a
                    'remarks' => $evaluationData['remarks'],
                ]);
            }

            // Calculate the overall rating as the average of all rating_a values
            $overallRating = number_format($totalRatingA / count($attributes['evaluations']), 2);

            // Update the overall_rating column in the main evaluation record
            $evaluation->update(['overall_rating' => $overallRating]);

            return $evaluation; // Return the created evaluation with overall rating

        } catch (\Exception $exception) {
            throw ValidationException::withMessages([$exception->getMessage()]);
        }
    }
}
