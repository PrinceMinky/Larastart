<?php

namespace App\Livewire\Traits;

use Illuminate\Database\Eloquent\Model;

trait WithInlineEditing 
{
    public $editing = null;
    public $temp = '';

    /**
     * Start editing a field inline.
     */
    public function startEditing($id, $field, $currentValue): void
    {
        $this->editing = [$id, $field];
        $this->temp = $currentValue;
    }

    /**
     * Cancel current inline edit state.
     */
    public function cancelEdit(): void
    {
        $this->editing = null;
        $this->temp = '';
    }

    /**
     * Save updates to a field.
     */
    public function saveInline($modelClass, $id, $field, $permission, $rules = []): void
    {
        $this->authorize($permission);

        /** @var Model $model */
        $model = $modelClass::findOrFail($id);

        if ($model->$field === $this->temp) {
            $this->cancelEdit();
            return;
        }

        try {
            $validationRules = $rules ?: ($this->rules()[$field] ?? ['required']);
            $this->validateOnly('temp', ['temp' => $validationRules]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            $this->cancelEdit();

            $this->toast([
                'heading' => 'Validation Error',
                'text' => ucfirst($field) . ' was not saved - it is invalid.',
                'variant' => 'danger'
            ]);

            return;
        }

        // Store original value
        $originalValue = $model->$field;

        // Call before hook if method exists
        if (method_exists($this, 'beforeInlineUpdate')) {
            $this->beforeInlineUpdate($model, $field, $originalValue, $this->temp);
        }

        // Update the model
        $model->$field = $this->temp;
        $model->save();

        // Call after hook if method exists
        if (method_exists($this, 'afterInlineUpdate')) {
            $this->afterInlineUpdate($model, $field, $originalValue, $model->$field);
        }

        // Reset editing state
        $this->editing = null;
        $this->temp = '';

        $this->toast([
            'heading' => ucfirst($field) . ' Updated',
            'text' => ucfirst($field) . ' updated successfully.',
            'variant' => 'success'
        ]);
    }
}