<?php

namespace App\Http\Requests\admin;

use Illuminate\Foundation\Http\FormRequest;

class danhmuc_add extends FormRequest
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
            'TenLoai'=>'required'
        ];
    }
     public function messages()
    {
        return [
        'TenLoai.required' => 'Tên danh mục không được để trống'
       
        ];
    }
}
