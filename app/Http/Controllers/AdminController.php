<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\Song;
use App\Models\User;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    // LOGIN
    public function viewLogin()
    {
        return view('login');
    }

    public function login(Request $request)
    {
        $request->validate([
            "username" => "required",
            "password" => "required"
        ],[
            "required" => ":Attribute harus diisi!"
        ],[
            "username" => "Username pegawai",
            "password" => "Password pegawai"
        ]);

        $credential = [
            "username" => $request->username,
            "password" => $request->password
        ];

        if(Auth::guard('web')->attempt($credential))
        {
            $client = new Client([
                'base_uri' => env('BACK_END_URL'),
            ]);

            $response = $client->request('POST', '/admin/admin/login', [
                'form_params' => $credential
            ]);

            $request->session()->put("auth_token", json_decode($response->getBody())->data);

            return redirect('/dashboard');
        }
        else
        {
            return redirect('/')->with('login_error', "Username atau password yang diinputkan salah!");
        }
    }

    // LOGOUT
    public function logout(Request $request) {
        if(Auth::guard('web')->check()){
            Auth::guard('web')->logout();
        }
        $request->session()->flush();
        return redirect('/');
    }

    // DASHBOARD
    public function dashboard(Request $request) {

        if($request->year)
        {
            $year = (int)$request->year;
        }
        else {
            $year = (int)date("Y", strtotime(now()));
        }

        // GET LAST MONTH REPORT
        $total_last_user = User::withTrashed()
                                ->whereDate("created_at", "<", date("Y-m-d", strtotime(($year + 1) . "-12-1")))
                                ->count();

        // GET SELECTED MONTH REPORT
        $free_plan_user = [];
        $paid_plan_user = [];
        for ($month = 1 ; $month < 13 ; $month++) {
            $nextMonth = ($month + 1 == 13) ? 1 : $month + 1;
            $nextYear = ($month + 1 == 13) ? $year + 1 : $year;
            $all_user = User::withTrashed()
                            ->whereDate("created_at", "<", date("Y-m-d", strtotime($nextYear . "-" . $nextMonth . "-1")))
                            ->get();
            $total_new_user = $all_user->count();
            $total_free_plan = 0;
            $total_paid_plan = 0;
            foreach($all_user as $user) {
                $payment = $user->Payment()
                                ->wherePivot('date', "<", date("Y-m-d", strtotime($nextYear . "-" . $nextMonth . "-1")))
                                ->orderBy('payments.date', 'desc')
                                ->limit(1)
                                ->get();

                if(count($payment) == 0){
                    $total_free_plan += 1;
                }
                else {
                    $payment = $payment[0];
                    if($payment->plan_id == 1) {
                        $total_free_plan += 1;
                    }
                    else {
                        $total_paid_plan += 1;
                    }
                }
            }
            $free_plan_user[] = $total_free_plan;
            $paid_plan_user[] = $total_paid_plan;
        }


        $total_user = User::count();

        $favorite_songs = Song::orderBy('total_favorite', 'desc')->limit(10)->get();

        return view('dashboard', compact(
            'year',
            'favorite_songs',
            'total_user', 'total_last_user', 'total_new_user',
            'total_free_plan', 'total_paid_plan',
            'free_plan_user', 'paid_plan_user',
        ));
    }

    // INDEX
    public function index()
    {
        return view('admin.index');
    }

    public function filterAdmin(Request $request)
    {
        $admins = Admin::withTrashed()->get();
        $params = $request->param;

        if ($request->mode == "CARI") {

            $admins = Admin::withTrashed()->where('username', 'like', '%' . $params["username"] == null ? "" : $params["username"] . '%');

            if ($params["role"] != null) $admins = $admins->where('role', $params["role"]);

            if($params['created_at'] != null) $admins = $admins->whereDate('created_at', "<=", date("Y-m-d", strtotime($params["created_at"])));
            if($params['updated_at'] != null) $admins = $admins->whereDate('updated_at', "<=", date("Y-m-d", strtotime($params["updated_at"])));

            $admins = $admins->get();
        }
        return view('admin.table', compact('admins'));
    }

    // INSERT
    public function viewInsert()
    {
        return view('admin.insert');
    }

    public function insert(Request $request)
    {
        $request->validate([
            "username" => "required|unique:admins|max:255",
            "password" => "required|confirmed",
        ],[
            "required" => "Data :attribute harus diisi!",
            "unique" => "Data :attribute sudah dipakai!",
            "confirmed" => "Data :attribute harus sama dengan konfirmasi password!",
        ]);

        Admin::create([
            "username" => $request->username,
            "password" => Hash::make($request['password']),
            "role" => "ADMIN"
        ]);

        return redirect('admin/insert')->with('success', 'Data admin berhasil diinput!');
    }

    // UPDATE
    public function viewUpdate($username)
    {
        $admin = Admin::withTrashed()->find($username);
        return view('admin.update', compact('admin'));
    }

    public function update(Request $request, $username)
    {
        $request->validate([
            "password" => "confirmed",
        ],[
            "required" => "Data :attribute harus diisi!",
            "confirmed" => "Data :attribute harus sama dengan konfirmasi password!",
        ]);

        Admin::find($username)->update([
            "username" => $request->username,
        ]);

        if($request['password'])
        {
            Admin::find($username)->update(
                ["password" => Hash::make($request['password'])]
            );
        }

        return redirect('admin/update/' . $username)->with('success', 'Data admin berhasil diubah!');
    }

    // DELETE
    public function delete($username)
    {
        Admin::find($username)->delete();
        return redirect('admin')->with('success', 'Data admin berhasil dihapus!');
    }

    // RESTORE
    public function restore($username)
    {
        Admin::withTrashed()->find($username)->restore();
        return redirect('admin/update/' . $username)->with('success', 'Data admin berhasil dikembalikan!');
    }
}
