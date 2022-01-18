<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SubmitContactRequest extends FormRequest
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
            'name' => ['required', 'string', 'max:191'],
            'email' => ['required', 'string', 'email', 'max:191'],
            'phone' => ['required', 'string'],
            'address' => ['required'],
            'address.number' => ['required', 'string', 'max:20'],
            'address.street' => ['required', 'string', 'max:191'],
            'address.city' => ['required', 'string', 'max:191'],
            'address.state' => ['required', 'string', 'max:191'],
            'address.country' => ['required', 'string', 'size:3']
        ];
    }
}
