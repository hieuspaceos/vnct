<?php

namespace App\Http\Requests\admin;

use Illuminate\Foundation\Http\FormRequest;

class login extends FormRequest
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
     * @return array
     */
    public function rules()
    {
        return [
           'email'=> 'required|email:filter',
           'password'=>'required'
        ];
    }
    public function messages()
    {
        return [
        'email.required' => 'Email Không được để trống',
        'email.filter' => 'Email không đúng định dạng',
        'password.required' => "pass không được để trống"
        ];
    }
}
