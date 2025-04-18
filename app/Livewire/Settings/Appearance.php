<?php

namespace App\Livewire\Settings;

use App\Livewire\BaseComponent;

class Appearance extends BaseComponent
{
    public function update()
    {
        $this->toast([
            'heading' => 'Appearance updated',
            'text' => 'Appearance updated successfully.',
            'variant' => 'success',
        ]);
    }
}
