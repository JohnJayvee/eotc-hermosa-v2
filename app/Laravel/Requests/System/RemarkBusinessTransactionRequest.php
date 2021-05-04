<?php

namespace App\Laravel\Requests\System;

use App\Laravel\Requests\RequestManager;
use Illuminate\Support\Facades\Auth;

class RemarkBusinessTransactionRequest extends RequestManager
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Auth::check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'status' => ['required', 'in:Approved,Declined'],
            'value' => ['required_if:status,Declined', 'string'],
        ];
    }

    public function messages()
    {
        return [
            'status' => 'Status',
            'value' => 'Remarks',
        ];
    }
}
