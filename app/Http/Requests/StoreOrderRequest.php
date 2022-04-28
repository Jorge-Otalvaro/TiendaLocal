<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreOrderRequest extends FormRequest
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
            'name' => ['required', 'string', 'max:80'],
    		'mobile' => ['required', 'numeric', 'min:10'],
	        'email' => ['required', 'string', 'email', 'max:120'],
            'product' => ['required', 'exists:App\Models\Product,id']
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'name.required' => 'El campo nombre es requerido',
            'name.string' => 'El campo nombre tiene caracteres no permitidos',
            'name.max' => 'El campo nombre supera el maximo permitido :max',

            'mobile.required' => 'El campo Telefono es requerido',
            'mobile.numeric' => 'El Telefono debe ser numerico',
            'mobile.min' => 'El Telefono no cumple con el minino :min',

            'email.required' => 'El campo Correo electronico es requerido',
            'email.string' => 'El Correo electronico tiene caracteres no permitidos',
            'email.email' => 'El Correo electronico no tiene un formato valido',
            'email.max' => 'El Correo electronico supera el maximo permitido :max',

            'product.required' => 'El producto es requerido',
            'product.exists' => 'El producto no existe',
        ];
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array
     */
    public function attributes()
    {
        return [
            'name' => 'Nombre completo',
            'email' => 'Correo electronico',
            'mobile' => 'Celular'
        ];
    }
}
