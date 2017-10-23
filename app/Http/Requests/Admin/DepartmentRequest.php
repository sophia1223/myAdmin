<?php
namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class DepartmentRequest extends FormRequest {
    
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
            'name' => 'required|string|between:2,40|unique:departments,name,' .
                $this->input('id') . ',id',
            'p_id' => 'required|integer',
            'type' => 'required|integer',
        ];
        
    }
    
    public function messages() {
        
        return [
            'name.required' => '部门必须输入',
            'name.unique'   => '已有此部门',
            'p_id.required' => '请选择正确的父部门',
            'p_id.integer'  => '请选择正确的父部门',
        ];
        
    }
    
    public function wantsJson() { return true; }
}
