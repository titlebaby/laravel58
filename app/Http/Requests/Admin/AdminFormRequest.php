<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest as BaseFormRequest;

class AdminFormRequest extends BaseFormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        //false代表权限验证不通过，返回403错误
        //true代表权限认证通过
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
            //
        ];
    }
}
