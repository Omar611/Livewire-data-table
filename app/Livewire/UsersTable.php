<?php

namespace App\Livewire;

use App\Models\User;
use Livewire\Attributes\Rule;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

class UsersTable extends Component
{
    use WithPagination;

    #[Rule(['perPage' => 'required|integer|min:1|max:100'])]
    public $perPage = 10;

    #[Rule(['search' => 'nullable|string|min:1|max:255'])]
    #[Url(history: true)]
    public $search = '';

    #[Rule(['userType' => 'nullable|string|in:0,1'])]
    #[Url(history: true)]
    public $userType = '';

    #[Rule(['orderBy' => 'nullable|string'])]
    #[Url(history: true)]
    public $orderBy = 'name';

    #[Rule(['orderDirection' => 'nullable|string|in:asc,desc'])]
    #[Url(history: true)]
    public $orderDirection = 'asc';


    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function deleteUser(User $user)
    {
        $user->delete();

        return redirect()->back()->with('success', 'User deleted.');
    }

    public function setOrderBy($field)
    {
        if ($this->orderBy === $field) {
            $this->orderDirection = $this->orderDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->orderBy = $field;
            $this->orderDirection = 'asc';
        }
    }

    public function render()
    {
        return view('livewire.users-table', [
            'users' => User::search($this->search)
                ->whereUserType($this->userType)
                ->orderBy($this->orderBy, $this->orderDirection)
                ->paginate($this->perPage),
        ]);
    }
}
