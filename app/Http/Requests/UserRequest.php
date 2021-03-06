<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

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

        switch($this->method())
        {
            case 'POST':
            {
                return [
                    'username'=>'required|max:30',
                    'nombre'=>'required|max:30', 
                    'apellido'=>'required|max:30',
                    'telefono'=>'required|max:8|min:8|unique:users',
                    'direccion'=>'required|max:250',   
                    'email'=>'required|email|unique:users', 
                    'password'=>'required|min:6',
                    'password_confirmation'=>'required|same:password',
                ];
            }
            case 'PUT':
            case 'PATCH':
            {
                return [
                    'username'=>'required|max:30',
                    'nombre'=>'required|max:30', 
                    'apellido'=>'required|max:30',
                    'telefono'=>'required|max:8|min:8|unique:users,telefono,'.$this->get('id'),
                    'direccion'=>'required|max:250',   
                    'email'=>'required|email|unique:users,email,'.$this->get('id'),
                    'password'=>'required|min:6',
                    'password_confirmation'=>'required|same:password',
                 ];
            }
            default:break;
        }
    }

    public function messages()
    {
        return [

            'username.required' =>'El campo Username es requerido.',
            'username.max' =>'El Username es muy largo.',
            'nombre.required' =>'El nombre es requerido.',
            'nombre.max' =>'El nombre es muy largo.',
            'apellido.required' =>'El apellido es requerido.',
            'apellido.max' =>'El apellido es muy largo.',
            'direccion.required' =>'La direccion es requerida.',
            'email.required'=>'Correo electronico es requerido.',
            'email.email'=>'Correo electronico no es valido.',
            'email.unique'=>'Correo electronico ya existe',
            'telefono.required'=>'El n??mero de telefono es requerido.',
            'telefono.min'=>'El n??mero de telefono debe tener 8 digitos.',
            'telefono.max'=>'El n??mero de telefono debe tener 8 digitos.',
            'telefono.unique'=>'El n??mero de telefono ya existe',
            'password.required'=>'Contrase??a es requerido.',
            'password_confirmation.required'=>'Confirmar contrase??a es requerido.',
            'password.min'=>'Contrase??a debe contener minimo 6 caracteres.',
            'password_confirmation.same'=>'Las contrase??as no coinciden.',
        ];
    }
}
