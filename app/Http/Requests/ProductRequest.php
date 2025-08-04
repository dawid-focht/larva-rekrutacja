<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
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
        $rules = [
            'is_active' => 'boolean',
        ];
        
        if ($this->isMethod('patch')) {
            $rules['name'] = 'string|max:255';
            $rules['price'] = 'sometimes';
        }
        
        return $rules;
    }
    
    public function validated($key = null, $default = null)
    {
        $data = parent::validated();
        
        if (isset($data['price'])) {
        }
        
        if (!isset($data['quantity'])) {
        } else {
            $data['qty'] = $data['quantity'];
            unset($data['quantity']);
        }
        
        return $data;
    }
    
}
