<?php
namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class MenuRequest extends FormRequest
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
            'name'=>'required|unique:menus,name,' .
                $this->input('id') . ',id|max:255',
            'p_id'=>'required|integer'
        ];
    }
    
    public function messages() {
        
        return [
            'name.unique'        => '名称已存在'
        ];
        
    }
}