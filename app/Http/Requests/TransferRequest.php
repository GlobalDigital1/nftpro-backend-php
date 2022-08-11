<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TransferRequest extends FormRequest
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
            'to' => ['required', 'string', 'max:255'],
            'token_id' => ['required', 'string', 'max:255', 'exists:nfts,token_id'],
            'transaction_hash' => ['required', 'string', 'max:255'],
        ];
    }
}
