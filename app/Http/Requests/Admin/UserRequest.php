<?php
namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest {
    
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize() {
        return true;
    }
    
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules() {
        
        return [
            'number'   => 'required|string|unique:users,number,' .
                $this->input('id') . ',id',
            'name'     => 'required|string',
            'nation'   => 'required|string',
            'gender'   => 'required|integer',
            'politics' => 'required|integer',
            'phone'    => ['required', 'string', 'regex:/^0?(13|14|15|17|18)[0-9]{9}$/'],
            'card_id'  => ['required', 'string', 'regex:/^\d{17}[\d|x]|\d{15}$/', 'unique:users,card_id,' . $this->input('id') . ',id',],
            'email'    => ['required', 'regex:/^\w[-\w.+]*@([A-Za-z0-9][-A-Za-z0-9]+\.)+[A-Za-z]{2,14}$/',],
        ];
    }
    
    public function messages() {
        
        return [
            'number.required'        => '学号不能为空',
            'name.required'          => '姓名不能为空',
            'nation.required'        => '民族不能为空',
            'gender.required'        => '性别为空',
            'politics.required'      => '政治面貌不能为空',
            'phone.required'         => '电话号不能为空',
            'card_id.required'       => '身份证号不能为空',
            'email.required'         => '邮箱不能为空',
            'department_id.required' => '班级输入有误',
            'phone.regex'            => '手机输入格式有误',
            'card_id.regex'          => '身份证号输入格式有误',
            'email.regex'            => '邮箱输入格式有误',
            'number.unique'          => '已有该学号',
            'card_id.unique'         => '已有该身份证号',
        ];
        
    }
    
    public function wantsJson() { return true; }
    
    protected function prepareForValidation() {
        $input = $this->all();
        if (!isset($input['image'])) {
            $input['image'] = "default/default.jag";
        }
        if (!isset($input['password'])) {
            $input['password'] = "XXXX";
        }
        $this->replace($input);
    }
    
}
