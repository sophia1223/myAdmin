<?php
namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class ActivityRequest extends FormRequest {
    
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
            'name'             => 'required|string',
            'local'            => 'required|string',
            'content'          => 'required|string',
            'activity_type_id' => 'required|integer',
            'course_id'        => 'required|integer',
            // 'image'            => 'required|string',
            // 'annex'            => 'required|string',
            'duration'         => 'required|integer',
            'number'           => 'required|string',
            'reply'            => 'required|string',
            'bonus'            => 'required|integer',
        ];
    }
    
    public function messages() {
        
        return [
            'name.required'     => '名称不能为空',
            'local.required'    => '活动地点不能为空',
            'content.required'  => '活动内容不能为空',
            'duration.required' => '学时不能为空',
            'number.required'   => '人数不能为空',
            'bonus.required'    => '心得奖励学时不能为空',
        ];
        
    }
    
    public function wantsJson() { return true; }
    
    protected function prepareForValidation() {
        
        $input = $this->all();
        if (!isset($input['content'])) {
            $input['content'] = "无";
        }
        $admin = \Auth::user();
        $input['admin_id'] = $admin->id;
        $input['department_id'] = $admin->department_id;
        $input['status'] = 0;
        $input['start_qr_code'] = 0;
        $input['end_qr_code'] = 0;
        $input['reply'] = '0';
        $this->replace($input);
    }
}
