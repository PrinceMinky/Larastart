<?php

namespace App\Traits;

use Flux\Flux;

trait WithModal
{
    protected function resetAndShowModal(string $modalName): void
    {
        $this->resetValidation();

        if ($modalName) {
            $this->modal($modalName)->show();
        } else {
            Flux::modals()->show();
        }
    }

    protected function resetAndCloseModal($modalName = null)
    {
        if ($modalName) {
            $this->modal($modalName)->close(function () {
                $this->reset();
            });
        } else {
            Flux::modals()->close(function () {
                $this->reset();
            });
        }
    }
}
