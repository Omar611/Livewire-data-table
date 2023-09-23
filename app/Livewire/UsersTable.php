<?php

namespace App\Livewire;

use App\Models\User;
use Livewire\Attributes\Rule;
use Livewire\Component;
use Livewire\WithPagination;

class UsersTable extends Component
{
    use WithPagination;

    #[Rule(['perPage' => 'required|integer|min:1|max:100'])]
    public $perPage = 10;

    #[Rule(['search' => 'nullable|string|min:1|max:255'])]
    public $search = '';

    #[Rule(['userType' => 'nullable|string|in:0,1'])]
    public $userType = '';

    public function deleteUser(User $user)
    {
        $user->delete();

        return redirect()->back()->with('success', 'User deleted.');
    }

    public function render()
    {
        return view('livewire.users-table', [
            'users' => User::search($this->search)
                ->whereUserType($this->userType)
                ->paginate($this->perPage),
        ]);
    }
}
