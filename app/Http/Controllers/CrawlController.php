<?php

namespace App\Http\Controllers;

use App\Models\Crawl;
use Illuminate\Http\Request;

class CrawlController extends Controller
{
    // INDEX
    public function index()
    {
        return view('crawl.index');
    }

    public function filterCrawl(Request $request)
    {
        $crawls = Crawl::all();
        $params = $request->param;

        if ($request->mode == "CARI") {

            $crawls = Crawl::where('name', 'like', '%' . $params["name"] == null ? "" : $params["name"] . '%');
            if ($params["crawl_id"] != null) $crawls = $crawls->where('crawl_id', $params["crawl_id"]);
            if ($params["url"] != null) $crawls = $crawls->where('url', $params["url"]);

            $crawls = $crawls->get();
        }
        return view('crawl.table', compact('crawls'));
    }

    // INSERT
    public function viewInsert()
    {
        return view('crawl.insert');
    }

    public function insert(Request $request)
    {
        $request->validate([
            "name" => "required|max:255",
            "url" => "required|max:255",
            "tag_stop" => "required|max:255",
            "tag_title" => "required|max:255",
            "tag_lyrics" => "required|max:255",
            "max_depth" => "required",
            "regex" => "required",
            "correction" => "required",
        ], [
            "required" => "Data :attribute harus diisi!",
            "max" => "Data :attribute maksimal :max karakter!",
        ]);

        $newCrawl = Crawl::create([
            "name" => $request->name,
            "url" => $request->url,
            "tag_stop" => $request->tag_stop,
            "tag_title" => $request->tag_title,
            "tag_lyrics" => $request->tag_lyrics,
            "max_depth" => $request->max_depth,
            "regex" => $request->regex,
            "correction" => $request->correction,
        ]);

        return redirect('crawl/insert')->with('success', 'Data crawl berhasil diinput!');
    }

    // UPDATE
    public function viewUpdate($id)
    {
        $crawl = Crawl::find($id);
        return view('crawl.update', compact('crawl'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            "name" => "required|max:255",
            "url" => "required|max:255",
            "tag_stop" => "required|max:255",
            "tag_title" => "required|max:255",
            "tag_lyrics" => "required|max:255",
            "max_depth" => "required",
            "regex" => "required",
            "correction" => "required",
        ], [
            "required" => "Data :attribute harus diisi!",
            "max" => "Data :attribute maksimal :max karakter!",
        ]);

        $updatedCrawl = Crawl::find($id);

        $updatedCrawl->update([
            "name" => $request->name,
            "url" => $request->url,
            "tag_stop" => $request->tag_stop,
            "tag_title" => $request->tag_title,
            "tag_lyrics" => $request->tag_lyrics,
            "max_depth" => $request->max_depth,
            "regex" => $request->regex,
            "correction" => $request->correction,
        ]);

        return redirect('crawl/update/' . $id)->with('success', 'Data crawl berhasil diubah!');
    }

    // DELETE
    public function delete($id)
    {
        Crawl::find($id)->delete();
        return redirect('crawl')->with('success', 'Data crawl berhasil dihapus!');
    }

    public function getLyrics(Request $request, $song_id) {
        if(!$request['crawl_option']) {
            return redirect('song/lyric/' . $song_id . "/" . $request['crawl_id']);
        }
        else if($request['crawl_option'] == "get") {
            return redirect('song/get-all-lyric/' . $request['crawl_id']);
        }
        else if($request['crawl_option'] == "refresh"){
            return redirect('song/refresh-lyric/' . $request['crawl_id']);
        }
    }
}
