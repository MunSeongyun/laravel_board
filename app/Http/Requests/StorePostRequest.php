<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Services\TrixSanitizer;

class StorePostRequest extends FormRequest
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
        return [
            'title' => 'required|string|max:100',
            'content' => 'required|string',
        ];
    }

    protected function prepareForValidation()
    {
        $sanitizer = app(TrixSanitizer::class);

        if($this->has('content')){
            $this->merge([
                'content' => $sanitizer->clean($this->input('content')),
            ]);
        }
    }
}
