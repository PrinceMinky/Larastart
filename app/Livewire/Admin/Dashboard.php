<?php

namespace App\Livewire\Admin;

use App\Livewire\BaseComponent;
use Livewire\Attributes\Layout;

#[Layout('components.layouts.admin')]
class Dashboard extends BaseComponent
{
    public function render()
    {
        return view('livewire.admin.dashboard');
    }
}
