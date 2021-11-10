<?php

namespace App\Http\Controllers;

use App\Models\Artist;
use App\Models\Genre;
use App\Models\Song;
use GuzzleHttp\Client;
use Illuminate\Http\Request;

class ArtistController extends Controller
{
    // INDEX
    public function index()
    {
        $genres = Genre::withTrashed()->get();
        return view('artist.index', compact('genres'));
    }

    public function filterArtist(Request $request)
    {
        $artists = Artist::withTrashed()->get();
        $countSong = Song::all();
        $params = $request->param;

        if ($request->mode == "CARI") {

            $artists = Artist::withTrashed()->where('name', 'like', '%' . $params["name"] == null ? "" : $params["name"] . '%');
            if ($params["artist_id"] != null) $artists = $artists->where('artist_id', $params["artist_id"]);
            if ($params["genre_id"] != null) $artists = $artists->where('genre_id', $params["genre_id"]);
            if ($params["img"] != null) $artists = $params['img'] == "NULL" ? $artists->whereNull('img') : $artists->whereNotNull('img');

            if($params['created_at'] != null) $artists = $artists->whereDate('created_at', "<=", date("Y-m-d", strtotime($params["created_at"])));
            if($params['updated_at'] != null) $artists = $artists->whereDate('updated_at', "<=", date("Y-m-d", strtotime($params["updated_at"])));

            $artists = $artists->get();
        }
        return view('artist.table', compact('artists', 'countSong'));
    }

    // INSERT
    public function viewInsert()
    {
        $genres = Genre::all();
        return view('artist.insert', compact('genres'));
    }

    public function insert(Request $request)
    {
        $request->validate([
            "name" => "required|string|max:255",
            "genre_id" => "required",
            "img" => "nullable|mimes:jpg,jpeg,png",
        ], [
            "required" => "Data :attribute harus diisi!",
            "max" => "Data :attribute maksimal :max karakter!",
            "string" => "Data :attribute hanya boleh mengandung angka dan huruf!",
            "mimes" => "Data :attribute harus bertipe (.jpg), (.jpeg), (.png)!",
        ]);

        $newArtist = Artist::create([
            "name" => $request->name,
            "genre_id" => $request->genre_id,
        ]);

        // UPLOAD DAN UPDATE ARTIST IMAGE
        if($request->file('img')) {

            $newArtist->update([
                "img" => $newArtist->artist_id . "." . $request->file('img')->getClientOriginalExtension()
            ]);

            $client = new Client([
                'base_uri' => env('BACK_END_URL'),
                'timeout'  => 2.0,
            ]);

            $response = $client->request('POST', '/admin/artist/img', [
                'headers'  => [
                    'auth_token' => $request->session()->get('auth_token')
                ],
                'multipart' => [
                    [
                        'name'     => 'img',
                        'contents' => fopen($request->file('img')->getRealPath(), 'r'),
                        'filename' => $newArtist->artist_id . "." . $request->file('img')->getClientOriginalExtension()
                    ]
                ]
            ]);
        }

        return redirect('artist/insert')->with('success', 'Data artist berhasil diinput!');
    }

    // UPDATE
    public function viewUpdate($id)
    {
        $artist = Artist::withTrashed()->find($id);
        $genres = Genre::all();
        return view('artist.update', compact('artist', 'genres'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            "name" => "required|string|max:255",
            "genre_id" => "required",
            "img" => "nullable|mimes:jpg,jpeg,png",
        ], [
            "required" => "Data :attribute harus diisi!",
            "max" => "Data :attribute maksimal :max karakter!",
            "string" => "Data :attribute hanya boleh mengandung angka dan huruf!",
            "mimes" => "Data :attribute harus bertipe (.jpg), (.jpeg), (.png)!",
        ]);

        $updatedArtist = Artist::find($id);

        $updatedArtist->update([
            "name" => $request->name
        ]);

        // UPLOAD DAN UPDATE ARTIST IMAGE
        if($request->file('img')) {

            $updatedArtist->update([
                "img" => $updatedArtist->artist_id . "." . $request->file('img')->getClientOriginalExtension()
            ]);

            $client = new Client([
                'base_uri' => env('BACK_END_URL'),
                'timeout'  => 2.0,
            ]);

            $response = $client->request('POST', '/admin/artist/img', [
                'headers'  => [
                    'auth_token' => $request->session()->get('auth_token')
                ],
                'multipart' => [
                    [
                        'name'     => 'img',
                        'contents' => fopen($request->file('img')->getRealPath(), 'r'),
                        'filename' => $updatedArtist->artist_id . "." . $request->file('img')->getClientOriginalExtension()
                    ]
                ]
            ]);
        }

        return redirect('artist/update/' . $id)->with('success', 'Data artist berhasil diubah!');
    }

    // DELETE
    public function delete($id)
    {
        Artist::find($id)->delete();
        return redirect('artist')->with('success', 'Data artist berhasil dihapus!');
    }

    // RESTORE
    public function restore($id)
    {
        Artist::withTrashed()->find($id)->restore();
        return redirect('artist/update/' . $id)->with('success', 'Data artist berhasil dikembalikan!');
    }
}
