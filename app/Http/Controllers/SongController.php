<?php

namespace App\Http\Controllers;

use App\Models\Artist;
use App\Models\Genre;
use App\Models\Song;
use App\Rules\AudioFile;
use GuzzleHttp\Client;
use Illuminate\Http\Request;

class SongController extends Controller
{
    // INDEX
    public function index()
    {
        $genres = Genre::withTrashed()->get();
        $artists = Artist::withTrashed()->get();
        return view('song.index', compact('genres', 'artists'));
    }

    public function filterSong(Request $request)
    {
        $songs = Song::withTrashed()->get();
        $params = $request->param;

        if ($request->mode == "CARI") {

            $songs = Song::withTrashed()->where('title', 'like', '%' . $params["title"] == null ? "" : $params["title"] . '%');
            if ($params["song_id"] != null) $songs = $songs->where('song_id', $params["song_id"]);

            if ($params["total_hash_min"] != null) $songs = $songs->where('total_hash', ">=", $params["total_hash_min"]);
            if ($params["total_hash_max"] != null) $songs = $songs->where('total_hash', "<=", $params["total_hash_max"]);

            if ($params["total_favorite_min"] != null) $songs = $songs->where('total_favorite', ">=", $params["total_favorite_min"]);
            if ($params["total_favorite_max"] != null) $songs = $songs->where('total_favorite', "<=", $params["total_favorite_max"]);

            if ($params["artist_id"] != null) $songs = $songs->where('artist_id', $params["artist_id"]);
            if ($params["genre_id"] != null) $songs = $songs->where('genre_id', $params["genre_id"]);
            if ($params["has_lyric"] != null) $songs = $params['has_lyric'] == "NULL" ? $songs->whereNull('lyrics') : $songs->whereNotNull('lyrics');
            if ($params["has_hash"] != null) $songs = $songs->where('has_hash', $params["has_hash"]);

            if ($params["file"] != null) $songs = $params['file'] == "NULL" ? $songs->whereNull('file') : $songs->whereNotNull('file');
            if ($params["img"] != null) $songs = $params['img'] == "NULL" ? $songs->whereNull('img') : $songs->whereNotNull('img');

            if($params['created_at'] != null) $songs = $songs->whereDate('created_at', "<=", date("Y-m-d", strtotime($params["created_at"])));
            if($params['updated_at'] != null) $songs = $songs->whereDate('updated_at', "<=", date("Y-m-d", strtotime($params["updated_at"])));

            $songs = $songs->get();
        }
        return view('song.table', compact('songs'));
    }

    // INSERT
    public function viewInsert()
    {
        $artists = Artist::all();
        return view('song.insert', compact('artists'));
    }

    public function insert(Request $request)
    {
        $request->validate([
            "title" => "required|string|max:255",
            "artist_id" => "required",
            "file" => ["required", new AudioFile($request->file('file'))],
            "img" => "nullable|mimes:jpg,jpeg,png",
        ], [
            "required" => "Data :attribute harus diisi!",
            "max" => "Data :attribute maksimal :max karakter!",
            "string" => "Data :attribute hanya boleh mengandung angka dan huruf!",
            "file.mimes" => "Data :attribute harus bertipe (.m4a), (.mp3), (.mp4), (.mpeg), (.wav)!",
            "img.mimes" => "Data :attribute harus bertipe (.jpg), (.jpeg), (.png)!",
        ]);

        $newSong = Song::create([
            "title" => $request->title,
            "lyrics" => null,
            "total_favorite" => 0,
            "total_hash" => 0,
            "file" => "null",
            "genre_id" => Artist::find($request->artist_id)->genre_id,
            "artist_id" => $request->artist_id,
            "has_hash" => 0
        ]);

        // UPLOAD DAN UPDATE SONG FILE
        $newSong->update([
            "file" => $newSong->song_id . "." . $request->file('file')->getClientOriginalExtension()
        ]);

        $client = new Client([
            'base_uri' => env('BACK_END_URL')
        ]);

        $response = $client->request('POST', '/admin/song/file', [
            'headers'  => [
                'auth_token' => $request->session()->get('auth_token')
            ],
            'multipart' => [
                [
                    'name'     => 'file',
                    'contents' => fopen($request->file('file')->getRealPath(), 'r'),
                    'filename' => $newSong->song_id . "." . $request->file('file')->getClientOriginalExtension(),
                ]
            ]
        ]);

        // UPLOAD DAN UPDATE SONG IMAGE
        if($request->file('img')) {

            $newSong->update([
                "img" => $newSong->song_id . "." . $request->file('img')->getClientOriginalExtension()
            ]);

            $response = $client->request('POST', '/admin/song/img', [
                'headers'  => [
                    'auth_token' => $request->session()->get('auth_token')
                ],
                'multipart' => [
                    [
                        'name'     => 'img',
                        'contents' => fopen($request->file('img')->getRealPath(), 'r'),
                        'filename' => $newSong->song_id . "." . $request->file('img')->getClientOriginalExtension()
                    ]
                ]
            ]);
        }

        return redirect('song/insert')->with('success', 'Data song berhasil diinput!');
    }

    // UPDATE
    public function viewUpdate($song_id)
    {
        $song = Song::withTrashed()->find($song_id);
        $artists = Artist::withTrashed()->get();
        return view('song.update', compact('song', 'artists'));
    }

    public function update(Request $request, $song_id)
    {
        $request->validate([
            "title" => "required|string|max:255",
            "artist_id" => "required",
            "file" => new AudioFile($request->file('file')),
            "img" => "nullable|mimes:jpg,jpeg,png",
        ], [
            "required" => "Data :attribute harus diisi!",
            "max" => "Data :attribute maksimal :max karakter!",
            "string" => "Data :attribute hanya boleh mengandung angka dan huruf!",
            "file.mimes" => "Data :attribute harus bertipe (.m4a), (.mp3), (.mp4), (.mpeg), (.wav)!",
            "img.mimes" => "Data :attribute harus bertipe (.jpg), (.jpeg), (.png)!",
        ]);

        $updatedSong = Song::find($song_id);

        $updatedSong->update([
            "title" => $request->title,
            "genre_id" => Artist::find($request->artist_id)->genre_id,
            "artist_id" => $request->artist_id,
        ]);

        $client = new Client([
            'base_uri' => env('BACK_END_URL'),
            'timeout'  => 2.0,
        ]);

        // UPLOAD DAN UPDATE SONG FILE
        if($request->file('file')) {
            $updatedSong->update([
                "file" => $updatedSong->song_id . "." . $request->file('file')->getClientOriginalExtension()
            ]);

            $response = $client->request('POST', '/admin/song/file', [
                'headers'  => [
                    'auth_token' => $request->session()->get('auth_token')
                ],
                'multipart' => [
                    [
                        'name'     => 'file',
                        'contents' => fopen($request->file('file')->getRealPath(), 'r'),
                        'filename' => $updatedSong->song_id . "." . $request->file('file')->getClientOriginalExtension()
                    ]
                ]
            ]);
        }

        // UPLOAD DAN UPDATE SONG IMAGE
        if($request->file('img')) {

            $updatedSong->update([
                "img" => $updatedSong->song_id . "." . $request->file('img')->getClientOriginalExtension()
            ]);

            $response = $client->request('POST', '/admin/song/img', [
                'headers'  => [
                    'auth_token' => $request->session()->get('auth_token')
                ],
                'multipart' => [
                    [
                        'name'     => 'img',
                        'contents' => fopen($request->file('img')->getRealPath(), 'r'),
                        'filename' => $updatedSong->song_id . "." . $request->file('img')->getClientOriginalExtension()
                    ]
                ]
            ]);
        }

        if($request->lyric) {
            Song::where("song_id", $song_id)->update(["lyrics" => $request->lyric]);
        }

        return redirect('song/update/' . $song_id)->with('success', 'Data song berhasil diubah!');
    }

    public function getAllLyric(Request $request)
    {
        $client = new Client([
            'base_uri' => env('BACK_END_URL')
        ]);

        $response = $client->request('POST', '/admin/song/lyric/all', [
            'headers'  => [
                'auth_token' => $request->session()->get('auth_token')
            ]
        ]);

        $message = $response->getReasonPhrase();
        if($response->getStatusCode() == 200) {
            return redirect('song')->with('success', $message);
        }
        else {
            return redirect('song')->with('fail', $message);
        }
    }

    public function getAllHash(Request $request)
    {
        $client = new Client([
            'base_uri' => env('BACK_END_URL')
        ]);

        $response = $client->request('POST', '/admin/song/hash/all', [
            'headers'  => [
                'auth_token' => $request->session()->get('auth_token')
            ]
        ]);

        $message = $response->getReasonPhrase();

        if($response->getStatusCode() == 200) {
            return redirect('song')->with('success', $message);
        }
        else {
            return redirect('song')->with('fail', $message);
        }
    }

    public function refreshLyric(Request $request)
    {
        $client = new Client([
            'base_uri' => env('BACK_END_URL')
        ]);

        $response = $client->request('POST', '/admin/song/lyric/refresh', [
            'headers'  => [
                'auth_token' => $request->session()->get('auth_token')
            ]
        ]);

        $message = $response->getReasonPhrase();
        if($response->getStatusCode() == 200) {
            return redirect('song')->with('success', $message);
        }
        else {
            return redirect('song')->with('fail', $message);
        }
    }

    public function refreshHash(Request $request)
    {
        $client = new Client([
            'base_uri' => env('BACK_END_URL')
        ]);

        $response = $client->request('POST', '/admin/song/hash/refresh', [
            'headers'  => [
                'auth_token' => $request->session()->get('auth_token')
            ]
        ]);

        $message = $response->getReasonPhrase();
        if($response->getStatusCode() == 200) {
            return redirect('song')->with('success', $message);
        }
        else {
            return redirect('song')->with('fail', $message);
        }
    }

    public function getHashSong(Request $request, $song_id)
    {
        $client = new Client([
            'base_uri' => env('BACK_END_URL')
        ]);


        $response = $client->request('POST', '/admin/song/hash/' . $song_id, [
            'headers'  => [
                'auth_token' => $request->session()->get('auth_token')
            ]
        ]);

        $message = $response->getReasonPhrase();
        if($response->getStatusCode() == 200) {
            return redirect('song/update/' . $song_id)->with('success', $message);
        }
        else {
            return redirect('song/update/' . $song_id)->with('fail', $message);
        }
    }

    public function getLyricSong(Request $request, $song_id)
    {
        $client = new Client([
            'base_uri' => env('BACK_END_URL')
        ]);

        $response = $client->request('POST', '/admin/song/lyric/' . $song_id, [
            'headers'  => [
                'auth_token' => $request->session()->get('auth_token')
            ]
        ]);

        $message = $response->getReasonPhrase();
        if($response->getStatusCode() == 200) {
            return redirect('song/update/' . $song_id)->with('success', $message);
        }
        else {
            return redirect('song/update/' . $song_id)->with('fail', $message);
        }
    }

    // DELETE
    public function delete($song_id)
    {
        Song::find($song_id)->delete();
        return redirect('song')->with('success', 'Data song berhasil dihapus!');
    }

    // RESTORE
    public function restore($song_id)
    {
        Song::withTrashed()->find($song_id)->restore();
        return redirect('song/update/' . $song_id)->with('success', 'Data song berhasil dikembalikan!');
    }
}
