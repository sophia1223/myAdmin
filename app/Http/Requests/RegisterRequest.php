<?php
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest {
    
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
            // 'number'   => 'required|string',
            // 'name'     => 'required|string',
            // 'card_id'  => 'required|string',
            // 'phone'    => 'required|string',
            // 'email'    => 'required|string',
            // 'password' => 'required|string',
        ];
    }
    
    protected function prepareForValidation() {
        
        //$input = $this->all();
        // $input['number'] =  '2017211124';
        // $input['name'] = 'YANG';
        // $input['card_id'] = '12154578787871';
        // $input['phone'] = '15444456223';
        // $input['email'] = '454645646@qq.com';
        // $input['password'] = '12345678';
        // $this->replace($input);
    }
}
