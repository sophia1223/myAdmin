<?php
namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class NewsRequest extends FormRequest
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
            'title'=>'required|unique:news,title,' .
                $this->input('id') . ',id',
            'image'=>'required_without:id',
            'content'=>'required',
            'news_type_id'=>'required|integer'
        ];
    }
    
    public function messages() {
        
        return [
            'name.unique'        => '标题已存在'
        ];
        
    }
}