<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Artist extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table         = "artists";
    protected $primaryKey    = "artist_id";
    public    $incrementing  = true;
    public    $timestamps    = true;

    protected $fillable = [
        "name",
        "img",
        "genre_id"
    ];

    public function Genre()
    {
        return $this->belongsTo(Genre::class, "genre_id", "genre_id")->withTrashed();
    }
}
