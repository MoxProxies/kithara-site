<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ContactRequest extends FormRequest
{
    public const TOPICS = [
        'support' => 'Help with the app',
        'billing' => 'Billing or the Pro purchase',
        'feedback' => 'Feature request or feedback',
        'press' => 'Press or partnership',
        'other' => 'Something else',
    ];

    public function authorize(): bool
    {
        return true;
    }

    /**
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:100'],
            'email' => ['required', 'email:rfc', 'max:255'],
            'topic' => ['required', 'in:'.implode(',', array_keys(self::TOPICS))],
            'message' => ['required', 'string', 'min:10', 'max:5000'],
            // Honeypot: real users never see this field, so it must stay empty.
            'website' => ['nullable', 'size:0'],
        ];
    }

    /**
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'website.size' => 'Submission rejected.',
            'message.min' => 'Please give us a little more detail (at least 10 characters).',
        ];
    }

    public function topicLabel(): string
    {
        return self::TOPICS[$this->validated('topic')] ?? 'General';
    }
}
