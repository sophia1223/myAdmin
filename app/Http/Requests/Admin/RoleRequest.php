<?php
namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class RoleRequest extends FormRequest
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
        return [
            'name'=>'required|unique:roles,name,'.$this->input('id').',id|max:255',
            'label'=>'max:255'
        ];
    }
    
    public function messages() {
        
        return [
            'name.unique'        => '名称已存在'
        ];
        
    }
}