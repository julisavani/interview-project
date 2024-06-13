<?php

namespace App\Http\Requests\Api\V1;

use Illuminate\Foundation\Http\FormRequest;

class StoreTaskRequest extends FormRequest
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
            'subject' => 'required',
            'description' => 'required',
            'notes' => 'required|array',
            'notes.*.subject' => 'required|string',
            'notes.*.note' => 'required|string',
            'notes.*.attachments' => 'required|array',
            'startDate' => 'required|date_format:Y-m-d',
            'dueDate' => 'required|date_format:Y-m-d',
            'priority' => 'required|in:High,Medium,Low',
            'status' => 'required|in:New,Incomplete,Complete'
        ];
    }
}
