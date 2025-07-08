<?php

namespace App\Livewire\Traits;

use Flux\Flux;

trait WithModal
{
    /**
     * Show a modal by name.
     * Optionally reset validation errors before showing.
     *
     * @param string $modalName Name of the modal to show.
     * @param bool $resetValidation Whether to reset validation before showing (default true).
     */
    protected function showModal(string $modalName, bool $resetValidation = true): void
    {
        if ($resetValidation) {
            $this->resetValidation();
        }

        if ($modalName) {
            $this->modal($modalName)->show();
        } else {
            Flux::modals()->show();
        }
    }

    /**
     * Close a modal by name.
     * Optionally reset component state after closing.
     *
     * @param string|null $modalName Name of the modal to close, or null for default.
     * @param bool $resetState Whether to reset component state after closing (default true).
     */
    protected function closeModal(?string $modalName = null, bool $resetState = true): void
    {
        $resetCallback = $resetState ? fn() => $this->reset() : null;

        if ($modalName) {
            $this->modal($modalName)->close($resetCallback);
        } else {
            Flux::modals()->close($resetCallback);
        }
    }
}
