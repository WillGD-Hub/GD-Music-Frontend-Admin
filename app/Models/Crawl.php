<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Crawl extends Model
{
    use HasFactory;

    protected $table         = "crawls";
    protected $primaryKey    = "crawl_id";
    public    $incrementing  = true;
    public    $timestamps    = false;

    protected $fillable = [
        "name",
        "url",
        "tag_stop",
        "tag_title",
        "tag_lyrics",
        "max_depth",
        "regex",
        "correction",
    ];
}
