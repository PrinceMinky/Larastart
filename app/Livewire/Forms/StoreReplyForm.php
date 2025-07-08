<?php

namespace App\Livewire\Forms;

use Livewire\Form;

class StoreReplyForm extends Form
{
    public array $body = [];

    public function rules(): array
    {
        return [
            'body.*' => 'required|string|max:1000',
        ];
    }

    public function messages(): array
    {
        return [
            'body.*.required' => 'Reply cannot be empty.',
            'body.*.max' => 'Reply cannot exceed 1000 characters.',
        ];
    }
}
