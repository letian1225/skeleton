<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class TariffCreateRequest extends FormRequest
{
    protected $rules = [
        'slug' => 'required|string|min:3|max:15', 
        'price' => 'required|numeric', 
        'currency' => 'required|string|size:3', 
        'period' => 'required', 
        'prolongable' => 'boolean'
    ];

    protected $nameRules = 'required|string|min:3';

    protected $messages = [
        'name.required' => 'name_required',
        'name.string' => 'name_string',
        'name.min' => 'name_min',
        'slug.required' => 'slug_required',
        'slug.string' => 'slug_string',
        'slug.min' => 'slug_min',
        'slug.max' => 'slug_max',
        'price.required' => 'price_required',
        'price.numeric' => 'price_numeric',
        'currency.required' => 'currency_required',
        'currency.string' => 'currency_string',
        'currency.size' => 'currency_size',
        'period.required' => 'period_required',
        'prolongable.boolean' => 'prolongable_boolean',
    ];

    protected $nameMessages = [
        'required' => 'name_required',
        'string' => 'name_string',
        'min' => 'name_min',
    ];
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    protected function prepareForValidation()
    {
        foreach (config('app.locales') as $locale) {
            $this->rules['name_'.$locale] = $this->nameRules;
            foreach ($this->nameMessages as $rule => $message) {
                $this->messages['name_'.$locale.'.'.$rule] = $message;
            }
        }
    }
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return $this->rules;
    }

    public function messages()
    {
        return $this->messages; 
    }
}
