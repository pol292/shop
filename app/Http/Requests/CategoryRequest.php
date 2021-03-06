<?php

namespace App\Http\Requests;

use Illuminate\Http\Request;
use Illuminate\Foundation\Http\FormRequest;

class CategoryRequest extends FormRequest {

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
    public function rules( Request $request ) {
        $ignore = !empty( $request[ 'id' ] ) ? ',' . $request[ 'id' ] : '';
        return [
            'title' => 'required',
            'url'   => 'required|regex:/^[a-z\d\-]+$/|unique:categories,url' . $ignore,
        ];
    }

    public function messages() {
        return [
            'url.regex' => 'Illgal url, its must be only with Letters and Numbers and minus sign (-).',
        ];
    }

}
