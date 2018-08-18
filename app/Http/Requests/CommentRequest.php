<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
if (version_compare(PHP_VERSION, '7.2.0', '>=')) {
    // Ignores notices and reports all other kinds... and warnings
    error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING);
    // error_reporting(E_ALL ^ E_WARNING); // Maybe this is enough
}
class CommentRequest extends FormRequest
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
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $this['user_id']=Auth::id();
        $rules = [
            //'username' => 'required|min:2',
            //'email' => 'required|email',
            'user_id' => 'required|exists:users,id',
            'content' => 'required|min:10',
            'post_id' => 'required|exists:posts,id'
        ];
        $rules['user_id']=Auth::id();
        return $rules;
    }
}
