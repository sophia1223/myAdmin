<?php
namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class HonorRequest extends FormRequest
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
            'user_id'=>'required|integer',
            'course_id'=>'required|integer',
            'score'=>'required|integer',
            'remark'=>'required|string'
        ];
    }
}