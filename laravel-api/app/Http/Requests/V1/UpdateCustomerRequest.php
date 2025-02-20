<?php

namespace App\Http\Requests\V1;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

//put request validation rules here
class UpdateCustomerRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $method = $this->method();

        if ($method == "PUT") {
            return [
                'name' => ['required'],
                'type' => ['required', Rule::in(['individual', 'business'])],
                'email' => ['required', 'email'],
                'address' => ['required'],
                'city' => ['required'],
                'state' => ['required'],
                'postalCode' => ['required'], // notice the change from postal_code to postalCode to follow JSON naming convention
            ];
        } else { // PATCH
            // add 'sometimes' because we are only updating the fields that are passed in the request
            return [
                'name' => ['sometimes', 'required'],
                'type' => ['sometimes', 'required', Rule::in(['individual', 'business'])],
                'email' => ['sometimes', 'required', 'email'],
                'address' => ['sometimes', 'required'],
                'city' => ['sometimes', 'required'],
                'state' => ['sometimes', 'required'],
                'postalCode' => ['sometimes', 'required'], // notice the change from postal_code to postalCode to follow JSON naming convention
            ];
        }
    }

     // This method is used to prepare the data for validation
    protected function prepareForValidation() {
        $this->merge([
            'postal_code' => $this->postalCode
         ]);
    }
}
