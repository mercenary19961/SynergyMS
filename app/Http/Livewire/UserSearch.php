<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\User;

class UserSearch extends Component
{
    public $query = '';       // Holds the current input value or selected user's name
    public $users = [];       // Stores the list of matching users
    public $userId = null;    // Stores the selected user's ID

    /**
     * Handle the search functionality based on user input.
     *
     * @param string $query
     * @return void
     */
    public function searchUsers($query)
    {
        $this->query = $query;

        if (strlen($query) > 0) {
            // Search users by name or email based on the input value
            $this->users = User::where('name', 'like', '%' . $query . '%')
                ->orWhere('email', 'like', '%' . $query . '%')
                ->limit(5)
                ->get();
        } else {
            // Clear search results and selected user if input is empty
            $this->users = [];
            $this->userId = null;
        }
    }

    /**
     * Handle the selection of a user from the dropdown.
     *
     * @param int $userId
     * @return void
     */
    public function selectUser($userId)
    {
        $user = User::find($userId);
        if ($user) {
            $this->query = $user->name; // Update the input field with the selected user's name
            $this->userId = $user->id;  // Store the selected user's ID
            $this->users = [];           // Clear the dropdown list
        }
    }

    /**
     * Render the Livewire component view.
     *
     * @return \Illuminate\View\View
     */
    public function render()
    {
        return view('livewire.user-search');
    }
}
