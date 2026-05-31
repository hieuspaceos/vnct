<?php

namespace App\Http\Requests\admin;

use Illuminate\Foundation\Http\FormRequest;

class product extends FormRequest
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
            "Post_Title"=> "required",
           
            'terms_id' => "required|array|min:1", 
            'terms_id.*' => 'required|integer|exists:terms,id'          
        ];
    }
    public function messages()
    {
        return [
           "Post_Title.required" => "Tên sản phẩm không được để trống",
           
           "terms_id.required" =>  "Chọn ít nhất 1 danh mục",
           "terms_id.array" =>  "Chọn ít nhất 1 danh mục",
           "terms_id.min" =>  "Chọn ít nhất 1 danh mục" 
        ];
    }
}
