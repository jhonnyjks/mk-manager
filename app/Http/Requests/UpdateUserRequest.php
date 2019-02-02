<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\User;

class UpdateUserRequest extends FormRequest
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
        $this->password = '123456';
        $rules = User::$rules;
        $rules['username'] = $rules['username'].','.$this->route('user').',id';
        // if(empty($this->password)) unset($rules['password']);

        return $rules;
    }
}
