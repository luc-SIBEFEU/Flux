<?php

namespace App\Policies;

use App\Models\Contact;
use App\Models\User;

class ContactPolicy
{
    /**
     * Seul un admin peut voir les contacts.
     */
    public function view(User $user, Contact $contact): bool
    {
        return $user->role === 'admin';
    }

    /**
     * Seul un admin peut mettre à jour un contact.
     */
    public function update(User $user, Contact $contact): bool
    {
        return $user->role === 'admin';
    }

    /**
     * Seul un admin peut supprimer un contact.
     */
    public function delete(User $user, Contact $contact): bool
    {
        return $user->role === 'admin';
    }

    /**
     * Seul un admin peut répondre à un contact.
     */
    public function reply(User $user, Contact $contact): bool
    {
        return $user->role === 'admin';
    }
}
