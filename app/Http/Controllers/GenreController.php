<?php

namespace App\Http\Controllers;

use App\Models\Genre;
use App\Models\Song;
use Illuminate\Http\Request;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7;

class GenreController extends Controller
{
    // INDEX
    public function index()
    {
        return view('genre.index');
    }

    public function filterGenre(Request $request)
    {
        $genres = Genre::withTrashed()->get();
        $countSong = Song::all();
        $params = $request->param;

        if ($request->mode == "CARI") {

            $genres = Genre::withTrashed()->where('name', 'like', '%' . $params["name"] == null ? "" : $params["name"] . '%');
            if ($params["genre_id"] != null) $genres = $genres->where('genre_id', $params["genre_id"]);
            if ($params["img"] != null) $genres = $params['img'] == "NULL" ? $genres->whereNull('img') : $genres->whereNotNull('img');

            if($params['created_at'] != null) $genres = $genres->whereDate('created_at', "<=", date("Y-m-d", strtotime($params["created_at"])));
            if($params['updated_at'] != null) $genres = $genres->whereDate('updated_at', "<=", date("Y-m-d", strtotime($params["updated_at"])));

            $genres = $genres->get();
        }
        return view('genre.table', compact('genres', 'countSong'));
    }

    // INSERT
    public function viewInsert()
    {
        return view('genre.insert');
    }

    public function insert(Request $request)
    {
        $request->validate([
            "name" => "required|string|max:255",
            "img" => "nullable|mimes:jpg,jpeg,png",
        ], [
            "required" => "Data :attribute harus diisi!",
            "max" => "Data :attribute maksimal :max karakter!",
            "string" => "Data :attribute hanya boleh mengandung angka dan huruf!",
            "mimes" => "Data :attribute harus bertipe (.jpg), (.jpeg), (.png)!",
        ]);

        $newGenre = Genre::create([
            "name" => $request->name
        ]);

        // UPLOAD DAN UPDATE GENRE IMAGE
        if($request->file('img')) {

            $newGenre->update([
                "img" => $newGenre->genre_id . "." . $request->file('img')->getClientOriginalExtension()
            ]);

            $client = new Client([
                'base_uri' => env('BACK_END_URL'),
                'timeout'  => 2.0,
            ]);

            $response = $client->request('POST', '/admin/genre/img', [
                'headers'  => [
                    'auth_token' => $request->session()->get('auth_token')
                ],
                'multipart' => [
                    [
                        'name'     => 'img',
                        'contents' => fopen($request->file('img')->getRealPath(), 'r'),
                        'filename' => $newGenre->genre_id . "." . $request->file('img')->getClientOriginalExtension()
                    ]
                ]
            ]);
        }

        return redirect('genre/insert')->with('success', 'Data genre berhasil diinput!');
    }

    // UPDATE
    public function viewUpdate($id)
    {
        $genre = Genre::withTrashed()->find($id);
        return view('genre.update', compact('genre'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            "name" => "required|string|max:255",
            "img" => "nullable|mimes:jpg,jpeg,png",
        ], [
            "required" => "Data :attribute harus diisi!",
            "max" => "Data :attribute maksimal :max karakter!",
            "string" => "Data :attribute hanya boleh mengandung angka dan huruf!",
            "mimes" => "Data :attribute harus bertipe (.jpg), (.jpeg), (.png)!",
        ]);

        $updatedGenre = Genre::find($id);

        $updatedGenre->update([
            "name" => $request->name
        ]);

        // UPLOAD DAN UPDATE GENRE IMAGE
        if($request->file('img')) {

            $updatedGenre->update([
                "img" => $updatedGenre->genre_id . "." . $request->file('img')->getClientOriginalExtension()
            ]);

            $client = new Client([
                'base_uri' => env('BACK_END_URL'),
                'timeout'  => 2.0,
            ]);

            $response = $client->request('POST', '/admin/genre/img', [
                'headers'  => [
                    'auth_token' => $request->session()->get('auth_token')
                ],
                'multipart' => [
                    [
                        'name'     => 'img',
                        'contents' => fopen($request->file('img')->getRealPath(), 'r'),
                        'filename' => $updatedGenre->genre_id . "." . $request->file('img')->getClientOriginalExtension()
                    ]
                ]
            ]);
        }

        return redirect('genre/update/' . $id)->with('success', 'Data genre berhasil diubah!');
    }

    // DELETE
    public function delete($id)
    {
        Genre::find($id)->delete();
        return redirect('genre')->with('success', 'Data genre berhasil dihapus!');
    }

    // RESTORE
    public function restore($id)
    {
        Genre::withTrashed()->find($id)->restore();
        return redirect('genre/update/' . $id)->with('success', 'Data genre berhasil dikembalikan!');
    }
}
