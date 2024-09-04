<?php

namespace App\Http\Requests;

use App\Models\Joob;
use Illuminate\Foundation\Http\FormRequest;

class JobRequest extends FormRequest
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
            'title' => 'required|string',
            'location' => 'required|string',
            'salary' => 'required|numeric|min:1|max:1000000',
            'description' => 'required|min:50',
            'experience' => 'required|in:' . implode(',', Joob::$experience),
            'category' => 'required|in:' . implode(',', Joob::$category),
        ];
    }
    public function messages(): array
    {
        return [
            'title.required' => 'The title field is required.',
            'location.required' => 'The location field is required.',
            'salary.required' => 'The salary field is required.',
            'description.required' => 'The description field is required.',
            'experience.required' => 'The experience field is required.',
            'experience.in' => 'The selected experience level is invalid. Please choose a valid option.',
            'category.required' => 'The category field is required.',
            'category.in' => 'The selected category is invalid. Please choose a valid option.',
            'salary.min' => 'The salary must be at least 1.',
            'salary.max' => 'The salary may not be greater than 1,000,000.',
            'description.min' => 'The description must be at least 50 characters long.'
        ];
    }
}
