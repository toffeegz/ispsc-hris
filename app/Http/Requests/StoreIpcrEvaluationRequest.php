<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreIpcrEvaluationRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'employee_id' => 'required|uuid',
            'ipcr_period_id' => 'required|uuid',
            'reviewed_by' => 'nullable|uuid',
            'recommending_approval' => 'nullable|uuid',
            'evaluations' => 'required|array|min:1', // Ensure evaluations is an array with at least one item
            'evaluations.*.category_id' => 'required|uuid',
            'evaluations.*.subcategory_id' => 'sometimes|uuid',
            'evaluations.*.name' => 'required|string',
            'evaluations.*.order' => 'nullable|integer',
            'evaluations.*.major_final_output' => 'nullable|string',
            'evaluations.*.performance_indicators' => 'nullable|string',
            'evaluations.*.target_of_accomplishment' => 'nullable|string',
            'evaluations.*.actual_accomplishments' => 'nullable|string',
            'evaluations.*.rating_q' => 'required|integer|between:1,5',
            'evaluations.*.rating_e' => 'required|integer|between:1,5',
            'evaluations.*.rating_t' => 'required|integer|between:1,5',
            'evaluations.*.remarks' => 'nullable|string',
        ];
    }
}
