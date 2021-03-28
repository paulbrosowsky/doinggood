<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

class AdminUsersController extends Controller
{
    public function index()
    {
        $users = User::paginate(50);
        return view('admin.users.index', [
            'users' => $users,
        ]);
    }
}
