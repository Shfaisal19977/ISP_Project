<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Rules\ThirtyDays;

class SubscriptionRequest extends FormRequest
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
            'id' => 'required',
            'bundle_size' => 'required|in:100GB,5GB,10GB,30GB,50GB,75GB',
            'start_date' => 'required|date',
            'end_date' => ['required', 'date', new ThirtyDays],
        ];
    }
}
