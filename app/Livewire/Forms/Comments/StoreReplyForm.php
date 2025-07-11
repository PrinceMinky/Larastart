<?php

namespace App\Livewire\Forms\Comments;

use Livewire\Form;

class StoreReplyForm extends Form
{
    /**
     * Reply bodies keyed by parent comment ID.
     *
     * @var array<int, string>
     */
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
