<?php

namespace App\Http\Requests;

use Illuminate\Http\Request;
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
    public function rules(  ) {
        return [
            'name' => 'required|min:3|max:255|regex:/^[a-z\s]+$/i',
            'email'     => 'required|regex:/^[\w\-\.]+@[\w\-\.]{2,}\.[\w\-\.]+$/|unique:users,email',
            'password'   => 'required|min:3|max:10|confirmed',
        ];
    }

    public function messages() {
        return [
            'name.regex' => 'Illgal name, please enter your full name',
            'email.regex' => 'Illagl email, please enter your email',
//            'sale.numeric' => 'The discount must be a number.',
//            'url.regex' => 'Illgal url, its must be only with Letters and Numbers and minus sign (-).',
        ];
    }

}
