<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class sendmail extends FormRequest
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
            "name"=> "required",           
            'email' => "required|email:rfc", 
            'subject' => 'required',
            'Content' => 'required'
        ];
    }
    public function messages()
    {
        return [
           "name.required" => "Please Name Required",
           
           "email.required" =>  "Please Emai Required",
           "email.email" => "Please Provide Valid Email Address",
           "subject.required" =>  "Please Subject Required",
           "Content.required" =>  "Please Content Required" 
        ];
    }
}
