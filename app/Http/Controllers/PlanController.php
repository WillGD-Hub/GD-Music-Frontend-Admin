<?php

namespace App\Http\Controllers;

use App\Models\Plan;
use Illuminate\Http\Request;

class PlanController extends Controller
{
    // INDEX
    public function index()
    {
        return view('plan.index');
    }

    public function filterPlan(Request $request)
    {
        $plans = Plan::withTrashed()->get();
        $params = $request->param;

        if ($request->mode == "CARI") {

            $plans = Plan::withTrashed()->where('name', 'like', '%' . $params["name"] == null ? "" : $params["name"] . '%');

            if ($params["plan_id"] != null) $plans = $plans->where('plan_id', $params["plan_id"]);
            if ($params["price_min"] != null) $plans = $plans->where('price', ">=", $params["price_min"]);
            if ($params["price_max"] != null) $plans = $plans->where('price', "<=", $params["price_max"]);
            if ($params["validation"] != null) $plans = $plans->where('validation', (int)$params["validation"]);

            if($params['created_at'] != null) $plans = $plans->whereDate('created_at', "<=", date("Y-m-d", strtotime($params["created_at"])));
            if($params['updated_at'] != null) $plans = $plans->whereDate('updated_at', "<=", date("Y-m-d", strtotime($params["updated_at"])));

            $plans = $plans->get();
        }
        return view('plan.table', compact('plans'));
    }

    // INSERT
    public function viewInsert()
    {
        return view('plan.insert');
    }

    public function insert(Request $request)
    {
        $request['price'] = (float)preg_replace("/[^0-9]/", "", $request['price']);

        $request->validate([
            "name" => "required|string|max:100",
            "price" => "required|numeric|digits_between:3,11",
            "validation" => "required|numeric|digits_between:1,2",
        ], [
            "required" => "Data :attribute harus diisi!",
            "max" => "Data :attribute maksimal :max karakter!",
            "string" => "Data :attribute hanya boleh mengandung angka dan huruf!",
            "integer" => "Data :attribute hanya boleh mengandung angka!",
        ]);

        Plan::create([
            "name" => $request->name,
            "price" => $request->price,
            "validation" => $request->validation
        ]);

        return redirect('plan/insert')->with('success', 'Data plan berhasil diinput!');
    }

    // UPDATE
    public function viewUpdate($id)
    {
        $plan = Plan::withTrashed()->find($id);
        return view('plan.update', compact('plan'));
    }

    public function update(Request $request, $id)
    {
        $request['price'] = (float)preg_replace("/[^0-9]/", "", $request['price']);

        $request->validate([
            "name" => "required|string|max:100",
            "price" => "required|numeric|digits_between:3,11",
            "validation" => "required|numeric|digits_between:1,2",
        ], [
            "required" => "Data :attribute harus diisi!",
            "max" => "Data :attribute maksimal :max karakter!",
            "string" => "Data :attribute hanya boleh mengandung angka dan huruf!",
            "integer" => "Data :attribute hanya boleh mengandung angka!",
        ]);

        Plan::find($id)->update([
            "name" => $request->name,
            "price" => $request->price,
            "validation" => $request->validation
        ]);

        return redirect('plan/update/' . $id)->with('success', 'Data plan berhasil diubah!');
    }

    // DELETE
    public function delete($id)
    {
        Plan::find($id)->delete();
        return redirect('plan')->with('success', 'Data plan berhasil dihapus!');
    }

    // RESTORE
    public function restore($id)
    {
        Plan::withTrashed()->find($id)->restore();
        return redirect('plan/update/' . $id)->with('success', 'Data plan berhasil dikembalikan!');
    }
}
