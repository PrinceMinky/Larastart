<?php

namespace App\Livewire\Admin;

use App\Models\Badword;
use Livewire\Attributes\Title;
use App\Livewire\BaseComponent;
use App\Livewire\Traits\WithDataTables;
use App\Livewire\Traits\WithInlineEditing;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Computed;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Cache;

#[Title('Badwords Management')]
#[Layout('components.layouts.admin')]
class BadwordManagement extends BaseComponent
{
    use WithDataTables, WithInlineEditing;

    public int|null $id = null;
    public string $word = '';
    public string $replacement = '';

    public array $words = [];

    public bool $replace_badwords;

    /**
     * Validation rules for the form inputs.
     */
    public function rules(): array
    {
        return [
            'word' => ['required', 'min:3', Rule::unique('badwords', 'word')->ignore($this->id)],
            'replacement' => ['nullable', 'min:3']
        ];
    }

    /**
     * Create a new badword record.
     */
    public function create(): void
    {
        $this->authorize('create badwords');

        $this->validate();

        Badword::create([
            'word' => $this->pull('word'),
            'replacement' => $this->pull('replacement')
        ]);

        $this->toast([
            'heading' => 'Badword Added',
            'text' => 'Badword added successfully.',
            'variant' => 'success'
        ]);

        $this->closeModal();
    }

    /**
     * Show confirmation modal for deleting a badword.
     */
    public function showConfirmDeleteForm($id): void
    {
        $this->authorize('delete badwords');

        $badword = Badword::findOrFail($id);

        $this->id = $badword->id;

        $this->showModal('delete-badword-form');
    }

    /**
     * Delete a badword record.
     */
    public function delete(): void
    {
        $this->authorize('delete badwords');

        $badword = Badword::findOrFail($this->id);

        $badword->delete();

        $this->toast([
            'heading' => 'Badword Deleted',
            'text' => 'Badword deleted successfully.',
            'variant' => 'danger'
        ]);

        $this->closeModal();
    }

    /**
     * Bulk Delete badword record.
     */
    public function deleteSelected()
    {
        $this->authorize('delete badwords');

        Badword::whereIn('id', $this->selectedItems)->delete();

        $this->toast([
            'heading' => 'Badwords Deleted',
            'text' => 'Badwords deleted successfully.',
            'variant' => 'danger'
        ]);

        $this->reset('selectedItems');
    }

    public function updatedReplaceBadwords($value)
    {
        // Coming soon
    }

    /**
     * Paginated badword results with search and sort applied, cached.
     */
    #[Computed]
    public function badwords(): \Illuminate\Pagination\LengthAwarePaginator
    {
        $query = Badword::query();

        $this->applySorting($query);
        $this->applySearch($query, ['word', 'replacement']);

        return $query->paginate(10);
    }

    /**
     * Render the Livewire component view.
     */
    public function render(): View
    {
        return view('livewire.admin.badword-management');
    }
}