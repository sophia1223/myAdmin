<?php
namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class PollRequest extends FormRequest
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
            'poll.name'=>'required|unique:polls,name,'.$this->input('id').',id|max:255'
        ];
    }
    
    
    public function wantsJson() { return true; }
    
    protected function prepareForValidation() {
        
        $input = $this->all();
        if (isset($input['poll']['status']) && $input['poll']['status'] === 'on') {
            $input['poll']['status'] = 1;
        }
        if (!isset($input['poll']['status'])) {
            $input['poll']['status'] = 0;
        }
        $this->replace($input);
        
    }
}