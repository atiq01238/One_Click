<?php

namespace App\Services;

use App\Models\User; // Import the User model if needed

class FetchUserRoles {

    /**
     * Fetch roles for the given user.
     *
     * @param  User  $user
     * @return array
     */
    public function fetch(User $user)
    {
        // Your logic here to fetch roles for the user
        // For example, you might fetch roles from a database table
        // This is just a placeholder implementation
        return $user->roles()->pluck('name')->toArray();
    }

    // You can define other methods as needed
}
