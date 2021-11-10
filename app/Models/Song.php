<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Song extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table         = "songs";
    protected $primaryKey    = "song_id";
    public    $incrementing  = true;
    public    $timestamps    = true;

    protected $fillable = [
        "title",
        "total_favorite",
        "total_hash",
        "file",
        "img",
        "artist_id",
        "genre_id",
        "has_lyric",
        "has_hash",
    ];

    public function Genre()
    {
        return $this->belongsTo(Genre::class, "genre_id", "genre_id")->withTrashed();
    }

    public function Artist()
    {
        return $this->belongsTo(Artist::class, "artist_id", "artist_id")->withTrashed();
    }
}
