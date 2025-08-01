<?php

namespace App\Livewire\Forms\Comments;

use Livewire\Form;

class UpdateCommentForm extends Form
{
    /**
     * Body
     *
     * @var string
     */
    public string $body = '';

    public function rules(): array
    {
        return [
            'body' => 'required|string|max:1000',
        ];
    }

    public function messages(): array
    {
        return [
            'body.required' => 'Comment cannot be empty.',
            'body.max' => 'Comment cannot exceed 1000 characters.',
        ];
    }
}
