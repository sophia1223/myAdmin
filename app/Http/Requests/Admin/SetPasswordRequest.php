<?php
/**
 * Created by PhpStorm.
 * User: EricJin
 * Date: 2017/3/17
 * Time: 上午10:28
 */

namespace App\Http\Requests;


use Illuminate\Foundation\Http\FormRequest;

class SetPasswordRequest extends FormRequest
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
     * Get custom messages for validator errors.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'newPassword.is_password' => '密码格式不正确!',
            'rePassword.is_password' => '密码格式不正确!',
        ];
    }
	public function rules()
	{
		return [
			'password' => 'required|isPassword',
			'newPassword' => 'required|isPassword',
			'rePassword' => 'required|isPassword'
		];
	}

}