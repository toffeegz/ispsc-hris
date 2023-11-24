<?php

namespace App\Services\IpcrEvaluation;

use Illuminate\Support\Facades\Log;
use App\Repositories\IpcrEvaluation\IpcrEvaluationRepositoryInterface;
use Illuminate\Support\Carbon;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\DB;
use App\Models\IpcrEvaluation;
use App\Models\IpcrCategory;
use App\Models\IpcrSubcategory;
use App\Models\IpcrEvaluationItem;
use App\Models\IpcrSubcategoryRating;
use App\Models\Department;

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
            DB::beginTransaction();

            $evaluation = IpcrEvaluation::create([
                'employee_id' => $attributes['employee_id'],
                'ipcr_period_id' => $attributes['ipcr_period_id'],
                'reviewed_by' => $attributes['reviewed_by'],
                'recommending_approval' => $attributes['recommending_approval'],
                'data' => json_encode($attributes),
            ]);

            $ctgr_strategic = IpcrCategory::where('order', 1)->first();
            $ctgr_core = IpcrCategory::where('order', 2)->first();
            $ctgr_support = IpcrCategory::where('order', 3)->first();
            
            $eval_strategic = $this->processEvaluations($ctgr_strategic->id, $attributes['strategic_evaluations'], $evaluation->id, null);
            $eval_core = $this->processEvaluations($ctgr_core->id, $attributes['core_evaluations'], $evaluation->id, null);
            $eval_support = $this->processEvaluations($ctgr_support->id, $attributes['support_evaluations'], $evaluation->id, null);
            
            $score_strategic = $this->computeCategoryOverallRating($ctgr_strategic, $evaluation->id);
            $score_core = $this->computeCategoryOverallRating($ctgr_core, $evaluation->id);
            $score_support = $this->computeCategoryOverallRating($ctgr_support, $evaluation->id);

           
            // Instead of recalculating, use the computed weighted scores directly
            $final_average_rating = $score_strategic + $score_core + $score_support;

            // Update the final_average_rating field in the existing evaluation instance
            $evaluation->final_average_rating = $final_average_rating;
            $evaluation->save();

            $evaluationWithEmployee = IpcrEvaluation::with('employee', 'ipcrPeriod')->find($evaluation->id);

            DB::commit();

            return $evaluationWithEmployee;
        } catch (\Exception $exception) {
            DB::rollBack();
            throw ValidationException::withMessages([$exception->getMessage()]);
        }
    }
    
    public function processEvaluations($category_id, $evaluations, $evaluation_id, $subcategory_id = null) 
    {
        foreach ($evaluations as $evaluation) {
            if (isset($evaluation['subcategory_id']) && isset($evaluation['evaluations'])) {
                // If the evaluation has a subcategory_id and evaluations, process the evaluations recursively
                $this->processEvaluations($category_id, $evaluation['evaluations'], $evaluation_id, $evaluation['subcategory_id']);
                $this->computeSubcategoryOverallRating($evaluation['subcategory_id'], $evaluation_id);
            } else {
                $rating_a = ($evaluation['rating_q'] + $evaluation['rating_e'] + $evaluation['rating_t']) / 3;
                $evaluationItemData = [
                    'category_id' => $category_id,
                    'subcategory_id' => $subcategory_id,
                    'evaluation_id' => $evaluation_id,
                    'name' => $evaluation['name'],
                    'order' => $evaluation['order'],
                    'major_final_output' => $evaluation['major_final_output'],
                    'performance_indicators' => $evaluation['performance_indicators'],
                    'target_of_accomplishment' => $evaluation['target_of_accomplishment'],
                    'actual_accomplishments' => $evaluation['actual_accomplishments'],
                    'rating_q' => $evaluation['rating_q'],
                    'rating_e' => $evaluation['rating_e'],
                    'rating_t' => $evaluation['rating_t'],
                    'rating_a' => $rating_a,
                    'remarks' => $evaluation['remarks'],
                ];
                $data = IpcrEvaluationItem::create($evaluationItemData);
            }
        }
    }

    public function computeSubcategoryOverallRating($subcategory_id, $evaluation_id) 
    {
        // Retrieve all evaluations for the given subcategory and evaluation
        $evaluations = IpcrEvaluationItem::where('subcategory_id', $subcategory_id)
            ->where('evaluation_id', $evaluation_id)
            ->get();

        $totalRatings = 0;
        $numberOfEvaluations = $evaluations->count();

        // Calculate the total ratings for the subcategory
        foreach ($evaluations as $evaluation) {
            $totalRatings += $evaluation->rating_a; // Assuming 'rating_a' is the aggregated rating
        }

        // Calculate the overall rating for the subcategory
        $overallRating = ($numberOfEvaluations > 0) ? ($totalRatings / $numberOfEvaluations) : 0;

        // Retrieve the subcategory weight
        $subcategory = IpcrSubcategory::find($subcategory_id);
        $weight = $subcategory->weight;

        // Calculate the weighted score for the subcategory
        $weightedScore = $overallRating * $weight;

        // Save the overall rating and weighted score for the subcategory in the IpcrSubcategoryRating table
        $data = IpcrSubcategoryRating::create([
            'ipcr_evaluation_id' => $evaluation_id,
            'overall_rating' => $overallRating,
            'weighted_score' => $weightedScore,
        ]);
    }

    public function computeCategoryOverallRating($category, $evaluation_id)
    {
        $evaluations = IpcrEvaluationItem::where('evaluation_id', $evaluation_id)
        ->where('category_id', $category->id)
        ->get();

        $totalRatings = 0;
        $numberOfEvaluations = $evaluations->count();

        // Calculate the total ratings for the subcategory
        foreach ($evaluations as $evaluation) {
            $totalRatings += $evaluation->rating_a; // Assuming 'rating_a' is the aggregated rating
        }

        // Get Weight
        $weight = $category->weight;

        $data = [];

        // mean score
        $mean_score = $totalRatings / $numberOfEvaluations;

        // weighted score
        $weighted_score = $weight * $mean_score;

        // Update the existing evaluation instance with the computed values based on category
        $evaluation = IpcrEvaluation::find($evaluation_id);

        if ($category->order === 1) {
            $evaluation->mean_score_strategic = $mean_score;
            $evaluation->weighted_average_strategic = $weighted_score;
        } elseif ($category->order === 2) {
            $evaluation->mean_score_core = $mean_score;
            $evaluation->weighted_average_core = $weighted_score;
        } elseif ($category->order === 3) {
            $evaluation->mean_score_support = $mean_score;
            $evaluation->weighted_average_support = $weighted_score;
        }

        // Save the updated evaluation instance
        $evaluation->save();
        return $weighted_score;
    }

    private function getAdjectivalRating($numericRating)
    {
        $adjectivalRatings = [
            5 => 'Outstanding',
            4 => 'Very Satisfactory',
            3 => 'Satisfactory',
            2 => 'Unsatisfactory',
            1 => 'Poor',
        ];

        // Get the closest numeric rating from the provided ratings
        $closestRating = round($numericRating * 2) / 2;

        // If the rounded rating exists in the mapping, return the adjectival rating
        if (isset($adjectivalRatings[$closestRating])) {
            return $adjectivalRatings[$closestRating];
        }

        // Handle cases where the exact rating isn't in the mapping
        // You can adjust this logic based on how you want to handle such cases
        return 'N/A';
    }

    public function show($id)
    {
        $data = IpcrEvaluation::find($id);
        return json_decode($data->data);
    }

    public function update($attributes, $id)
    {
        // Delete existing records related to $id
        IpcrEvaluation::find($id)->delete();
        IpcrEvaluationItem::where('evaluation_id', $id)->delete();
        IpcrSubcategoryRating::where('ipcr_evaluation_id', $id)->delete();
    
        // Create a new record
        $new_data = $this->create($attributes);
    
        // Return whatever response or data is appropriate for your application
        return $new_data;
    }

}
