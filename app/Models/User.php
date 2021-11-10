<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table         = "users";
    protected $primaryKey    = "username";
    public    $incrementing  = false;
    public    $timestamps    = true;

    protected $fillable = [
        "username",
        "password",
        "img",
        "plan_id",
        "stream_hit",
        "search_hit",
    ];

    public function Plan()
    {
        return $this->belongsTo(Plan::class, "plan_id", "plan_id");
    }

    public function Payment()
    {
        return $this->belongsToMany(Plan::class, 'payments', 'username', 'plan_id')
                    ->withPivot('date', 'price', 'validation');
    }
}
