<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Class MemberCartRequest
 * @package App\Http\Requests
 * 用户购物车请求
 */
class MemberCartRequest extends FormRequest
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
            'product_sku_id' => 'required|integer',
            'number' => 'required|gt:0'
        ];
    }

    public function messages()
    {
        return [
            'product_sku_id.required' => '请选择商品属性',
            'product_sku_id.integer' => '商品属性格式错误',
            'number.required' => '请添加商品数量',
            'number.gt' => '商品数量至少为1个'
        ];
    }
}
