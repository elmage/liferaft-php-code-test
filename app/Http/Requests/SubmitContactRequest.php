<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\ValidationException;
use LVR\Phone\Phone;
use Symfony\Component\HttpFoundation\Response;

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
            'phone' => ['required', 'string', new Phone],
            'address' => ['required'],
            'address.number' => ['required', 'integer'],
            'address.street' => ['required', 'string', 'max:191'],
            'address.city' => ['required', 'string', 'max:191'],
            'address.state' => ['required', 'string', 'max:191'],
            'address.country' => ['required', 'string', 'size:3']
        ];
    }

    public function failedValidation(Validator $validator) {
        $response = new Response(
            json_encode([
                'success' => false,
                'error' => 'The given data was invalid.',
                'errors' => $validator->errors()
            ]),
            Response::HTTP_UNPROCESSABLE_ENTITY
        );

        throw (new ValidationException($validator, $response))
            ->errorBag($this->errorBag)
            ->redirectTo($this->getRedirectUrl());
    }
}
