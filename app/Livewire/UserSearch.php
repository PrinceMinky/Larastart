<?php

namespace App\Livewire;

use App\Models\User;
use App\Traits\Searchable;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;

#[Title('Users')]
class UserSearch extends Component
{
    use WithPagination, Searchable;

    #[Computed]
    public function users()
    {
        $query = User::query();

        $query->with(['posts','following','followers']);

        $this->applySearch($query, ['name','username','email']);

        return $query->paginate(25);
    }

    public function render()
    {
        return view('livewire.user-search.index');
    }
}
