<?php

namespace App\Listeners;

use App\Events\AssignDefaultRole;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Spatie\Permission\Models\Role;

class AssignDefaultRoleListener
{
    use InteractsWithQueue;

    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(AssignDefaultRole $event): void
    {
        // Assign the default role to the user
        $defaultRole = Role::where('name', 'User')->first();

        if ($defaultRole) {
            $event->user->assignRole($defaultRole);
        }
    }
}
