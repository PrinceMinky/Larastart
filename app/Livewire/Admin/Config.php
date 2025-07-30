<?php

namespace App\Livewire\Admin;

use App\Livewire\BaseComponent;
use Illuminate\Support\Facades\File;
use Livewire\Attributes\{Computed, Layout, Title};

#[Title('Config')]
#[Layout('components.layouts.admin')]
class Config extends BaseComponent
{
    public ?string $file = null;

    public function mount($config_file = null)
    {
        $this->file = $config_file;
    }

    #[Computed]
    public function getConfigFiles()
    {
        return collect(scandir(config_path()))
            ->filter(fn($file) => pathinfo($file, PATHINFO_EXTENSION) === 'php')
            ->values()
            ->toArray();
    }

    #[Computed]
    public function getFileContent()
    {
        if (!$this->file) {
            return null;
        }

        $filePath = config_path($this->file . '.php');
        
        if (File::exists($filePath)) {
            return File::get($filePath);
        }

        return null;
    }

    public function render()
    {
        return view('livewire.admin.config');
    }
}