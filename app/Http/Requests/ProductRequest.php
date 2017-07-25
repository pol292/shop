<?php

namespace App\Http\Requests;

use Illuminate\Http\Request;
use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest {

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
            'title'   => 'required',
            'article' => 'max:255',
            'url'     => 'required|regex:/^[a-z\d\-]+$/|unique:products,url' . $ignore,
            'price'   => 'numeric|min:1|max:100000',
            'sale'    => 'numeric|min:0|max:99',
            'stock'   => 'numeric|min:0|max:1000',
        ];
    }

    public function messages() {
        return [
            'sale.min' => 'The discount must be at least :min.',
            'sale.max' => 'The discount may not be greater than :max.',
            'sale.numeric' => 'The discount must be a number.',
            'url.regex' => 'Illgal url, its must be only with Letters and Numbers and minus sign (-).',
        ];
    }

}
