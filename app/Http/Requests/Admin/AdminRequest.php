<?php
/**
 * Created by PhpStorm.
 * User: guan
 * Date: 17/4/18
 * Time: 上午12:44
 */

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class AdminRequest extends FormRequest
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
     * @return array
     */
    public function rules()
    {
        $passwordRequired = $this->has('id') ? '' :'required|confirmed|isPassword|';
        return [
            'username'=>'required|unique:admins,username,'.$this->input('id').',id|max:255|isUserName',
            'realname'=>'required|max:255',
            'roles'=>'required',
            'department_id'=>'required',
            'password'=>$passwordRequired.'min:6|max:50'
        ];
    }
    
    public function messages() {
        
        return [
            'username.unique'        => '账号已存在',
            'password.is_password'        => '密码格式不正确',
            'username.is_user_name'        => '账号格式不正确',
        ];
        
    }
}