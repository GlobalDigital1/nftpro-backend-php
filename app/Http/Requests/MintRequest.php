<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MintRequest extends FormRequest
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
            'image' => ['required', 'image'],
            'name' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string', 'max:10000'],
            'email' => ['sometimes', 'email', 'max:255'],
            'wallet_address' => ['sometimes', 'string', 'max:255'],
        ];
    }

    protected function prepareForValidation()
    {
        if(!$this->wallet_address){
            $this->merge([
                'wallet_address' => $this->user()->wallet_address
            ]);
        }
    }
}
