<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreBiografiRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        // Require authentication to submit biography
        return auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255', 'unique:biografis,name'],
            'birth_place' => ['nullable', 'string', 'max:255'],
            'birth_date' => ['nullable', 'date'],
            'death_date' => ['nullable', 'date', 'after:birth_date'],
            'category_id' => ['nullable', 'exists:categories,id'],
            'achievements' => ['nullable', 'string'],
            'life_story' => ['required', 'string'],
            'image' => ['nullable', 'image', 'mimes:jpg,jpeg,png', 'max:2048'], // max 2MB
        ];
    }

    /**
     * Get custom error messages for validation rules.
     */
    public function messages(): array
    {
        return [
            'name.required' => 'Nama tokoh wajib diisi.',
            'name.unique' => 'Nama tokoh sudah ada di database.',
            'life_story.required' => 'Kisah hidup wajib diisi.',
            'death_date.after' => 'Tanggal meninggal harus setelah tanggal lahir.',
            'image.image' => 'File harus berupa gambar.',
            'image.mimes' => 'Format gambar harus jpg, jpeg, atau png.',
            'image.max' => 'Ukuran gambar maksimal 2MB.',
        ];
    }
}
