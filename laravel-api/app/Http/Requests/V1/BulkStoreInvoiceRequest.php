<?php

namespace App\Http\Requests\V1;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class BulkStoreInvoiceRequest extends FormRequest
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

        // return the validation rules for the request
        // bulk store invoices means that you can store multiple invoices at once in an array: use *. to target the array
        return [
            '*.customer_id' => ['required', 'integer'],
            '*.amount' => ['required', 'numeric'],
            '*.status' => ['required', Rule::in(['billed', 'paid', 'void'])],
            '*.billedDate' => ['required', 'date_format:Y-m-d H:i:s'], // date format: year month day hour minute second
            '*.paidDate' => ['date_format:Y-m-d H:i:s', 'nullable'], // not all invoices are paid
        ];
    }

    // This method is used to prepare the data for validation
    protected function prepareForValidation() {
        $data = [];

        foreach ($this->toArray() as $obj) {
            $obj['customer_id'] = $obj['customerId'] ?? null;
            $obj['billed_date'] = $obj['billedDate'] ?? null;
            $obj['paid_date'] = $obj['paidDate'] ?? null;
            $data[] = $obj;
        }
        
        $this->merge($data);
    }
}
