<?php

namespace App\View\Composers;

use App\Models\User;
use Illuminate\View\View;

class UsersComposer
{
    public function compose(View $view): void
    {
        $view->with('users', User::all());
    }
}