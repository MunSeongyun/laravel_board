<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Services\TrixSanitizer;

class UpdatePostRequest extends FormRequest
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
            'title' => 'string|max:100',
            'content' => 'string',
        ];
    }

    protected function prepareForValidation()
    {
        $sanitizer = app(TrixSanitizer::class); // TrixSanitizer 서비스 인스턴스 가져오기 (Resolving)

        if($this->has('content')){
            $this->merge([
                'content' => $sanitizer->clean($this->input('content')),
            ]);
        }
    }
}
