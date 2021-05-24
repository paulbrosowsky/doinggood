<?php

namespace App\Http\Controllers;

use App\Exports\UsersExport;
use App\User;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class AdminUsersController extends Controller
{
    public function index()
    {
        $users = User::orderBy('created_at', 'desc')->paginate(50);
        return view('admin.users.index', [
            'users' => $users,
        ]);
    }

    public function export()
    {
        return Excel::download(new UsersExport, 'users.xlsx');
    }
}
