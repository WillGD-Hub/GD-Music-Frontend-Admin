<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Genre extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table         = "genres";
    protected $primaryKey    = "genre_id";
    public    $incrementing  = true;
    public    $timestamps    = true;

    protected $fillable = [
        "name",
        "img",
    ];
}
