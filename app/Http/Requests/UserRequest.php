<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

class UserRequest extends FormRequest
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
            'name' => 'required|string|min:5|max:50',
            'email' => 'required|string|email|min:10|max:50',
            'password' => ($this->request->get('user_id')  ? '' : 'required|string|min:8|confirmed'),
            'password_confirmation' => ($this->request->get('user_id') && !$this->request->get('password') ? '' : 'required|min:8'),
            'roles' => 'required'
        ];

    }

    public function attributes()
    {
        return [
            'name' => 'Nome',
            'email' => 'E-mail',
            'password' => 'Senha',
            'password_confirmation' => 'Confirmar senha',
            'roles' => 'Nível'
        ];
    }
}
