<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PostRequest extends FormRequest
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
        return [
            'titulo'      => 'required|min:10|max:100',
            'tipo_post_id'=> 'required',
            'autor'       => 'required|min:5|max:100',
            'post'        => 'required|min:20|max:400'
        ];
    }

    public function attributes()
    {
        return [
            'titulo'        => 'Título',
            'tipo_post_id'  => 'Tipo Post',
            'autor'         => 'Autor',
            'post'          => 'Post'
        ];
    }
}
