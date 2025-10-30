<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class UpdateSettingsRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules():array
    {
        return [
            "name" => ['required', 'string'],
            'description' => ['required', 'string'],
            'keywords' => ['required', 'string'],
            'link_per_bitrate' => ['required', 'numeric', 'min:1', 'max:3'],
        ];
    }
}
