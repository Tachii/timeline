<?php

namespace B4u\TimelineModule\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Class TaskStoreRequest
 *
 * Used for request validation.
 *
 * @package B4u\TimelineModule\Http\Requests
 */
class TimelineStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules() : array
    {
        return [
            'description' => 'required|string|max:500',
            'creator_id' => 'nullable|integer',
            'creator_type' => 'nullable|string|max:500',
            'target_id' => 'required|integer',
            'target_type' => 'required|string|max:500',
        ];
    }
}
