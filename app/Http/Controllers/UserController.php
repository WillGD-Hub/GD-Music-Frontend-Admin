<?php

namespace App\Http\Controllers;

use App\Models\Plan;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
// INDEX
    public function index()
    {
        $plans = Plan::withTrashed()->get();
        return view('user.index', compact('plans'));
    }

    public function filterUser(Request $request)
    {
        $users = User::withTrashed()->get();
        $params = $request->param;

        if ($request->mode == "CARI") {

            $users = User::withTrashed()->where('username', 'like', '%' . $params["username"] == null ? "" : $params["username"] . '%');

            if ($params["plan_id"] != null) $users = $users->where('plan_id', $params["plan_id"]);

            if($params['created_at'] != null) $users = $users->whereDate('created_at', "<=", date("Y-m-d", strtotime($params["created_at"])));
            if($params['updated_at'] != null) $users = $users->whereDate('updated_at', "<=", date("Y-m-d", strtotime($params["updated_at"])));

            $users = $users->get();
        }
        return view('user.table', compact('users'));
    }

    // UPDATE
    public function viewUpdate($username)
    {
        $user = User::withTrashed()->find($username);
        return view('user.update', compact('user'));
    }
}
