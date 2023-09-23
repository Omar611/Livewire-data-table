<?php

namespace App\Livewire;

use App\Models\User;
use Livewire\Attributes\Rule;
use Livewire\Component;
use Livewire\WithPagination;

class UsersTable extends Component
{
    use WithPagination;

    #[Rule(['perPage' => 'required|integer|min:1'])]
    public $perPage = 10;

    public function render()
    {
        return view('livewire.users-table', [
            'users' => User::paginate($this->perPage),
        ]);
    }
}
