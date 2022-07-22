<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProfileRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'avatar'              => ['sometimes', 'image', 'max:10240'],
            'name'                => ['sometimes', 'string', 'max:255'],
            'email'               => ['sometimes', 'string', 'max:255'],
            'email_notifications' => ['sometimes', 'boolean'],
            'push_notifications'  => ['sometimes', 'boolean'],
        ];
    }
}
