<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\GenreController;
use App\Http\Controllers\ArtistController;
use App\Http\Controllers\PlanController;
use App\Http\Controllers\SongController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::group(["middleware" => "LoginCheck:offline"], function () {

    // LOGIN
    Route::get('/', [AdminController::class, "viewLogin"]);
    Route::post('/login', [AdminController::class, "login"]);

});

Route::group(["middleware" => ["LoginCheck:online", "RoleCheck:ADMIN"]], function () {

    // LOGOUT
    Route::get('/logout', [AdminController::class, "logout"]);

    // DASHBOARD
    Route::get('/dashboard', [AdminController::class, "dashboard"]);

    // GENRE
    Route::prefix('genre')->name('genre.')->group(function () {
        // INDEX
        Route::get('/', [GenreController::class, "index"]);
        Route::get('/filter-genre', [GenreController::class, "filterGenre"]);

        // INSERT
        Route::get('/insert', [GenreController::class, "viewInsert"]);
        Route::post('/insert', [GenreController::class, "insert"]);

        // UPDATE
        Route::get('/update/{id}', [GenreController::class, "viewUpdate"]);
        Route::post('/update/{id}', [GenreController::class, "update"]);

        // DELETE
        Route::get('/delete/{id}', [GenreController::class, "delete"]);

        // RESTORE
        Route::get('/restore/{id}', [GenreController::class, "restore"]);
    });

    // ARTIST
    Route::prefix('artist')->name('artist.')->group(function () {
        // INDEX
        Route::get('/', [ArtistController::class, "index"]);
        Route::get('/filter-artist', [ArtistController::class, "filterArtist"]);

        // INSERT
        Route::get('/insert', [ArtistController::class, "viewInsert"]);
        Route::post('/insert', [ArtistController::class, "insert"]);

        // UPDATE
        Route::get('/update/{id}', [ArtistController::class, "viewUpdate"]);
        Route::post('/update/{id}', [ArtistController::class, "update"]);

        // DELETE
        Route::get('/delete/{id}', [ArtistController::class, "delete"]);

        // RESTORE
        Route::get('/restore/{id}', [ArtistController::class, "restore"]);
    });

    // SONG
    Route::prefix('song')->name('song.')->group(function () {
        // INDEX
        Route::get('/', [SongController::class, "index"]);
        Route::get('/filter-song', [SongController::class, "filterSong"]);

        // INSERT
        Route::get('/insert', [SongController::class, "viewInsert"]);
        Route::post('/insert', [SongController::class, "insert"]);

        // UPDATE
        Route::get('/update/{id}', [SongController::class, "viewUpdate"]);
        Route::post('/update/{id}', [SongController::class, "update"]);

        Route::get('/get-all-lyric', [SongController::class, "getAllLyric"]);
        Route::get('/get-all-hash', [SongController::class, "getAllHash"]);
        Route::get('/refresh-lyric', [SongController::class, "refreshLyric"]);
        Route::get('/refresh-hash', [SongController::class, "refreshHash"]);

        Route::get('/hash/{id}', [SongController::class, "getHashSong"]);
        Route::get('/lyric/{id}', [SongController::class, "getLyricSong"]);

        // DELETE
        Route::get('/delete/{id}', [SongController::class, "delete"]);

        // RESTORE
        Route::get('/restore/{id}', [SongController::class, "restore"]);
    });

    // PLAN
    Route::prefix('plan')->name('plan.')->group(function () {
        // INDEX
        Route::get('/', [PlanController::class, "index"]);
        Route::get('/filter-plan', [PlanController::class, "filterPlan"]);

        // INSERT
        Route::get('/insert', [PlanController::class, "viewInsert"]);
        Route::post('/insert', [PlanController::class, "insert"]);

        // UPDATE
        Route::get('/update/{id}', [PlanController::class, "viewUpdate"]);
        Route::post('/update/{id}', [PlanController::class, "update"]);

        // DELETE
        Route::get('/delete/{id}', [PlanController::class, "delete"]);

        // RESTORE
        Route::get('/restore/{id}', [PlanController::class, "restore"]);
    });

    // USER
    Route::prefix('user')->name('user.')->group(function () {
        // INDEX
        Route::get('/', [UserController::class, "index"]);
        Route::get('/filter-user', [UserController::class, "filterUser"]);

        // UPDATE
        Route::get('/update/{username}', [UserController::class, "viewUpdate"]);
    });
});

Route::group(["middleware" => ["LoginCheck:online", "RoleCheck:SUPERADMIN"]], function () {
    // ADMIN
    Route::prefix('admin')->name('admin.')->group(function () {
        // INDEX
        Route::get('/', [AdminController::class, "index"]);
        Route::get('/filter-admin', [AdminController::class, "filterAdmin"]);

        // INSERT
        Route::get('/insert', [AdminController::class, "viewInsert"]);
        Route::post('/insert', [AdminController::class, "insert"]);

        // UPDATE
        Route::get('/update/{username}', [AdminController::class, "viewUpdate"]);
        Route::post('/update/{username}', [AdminController::class, "update"]);

        // DELETE
        Route::get('/delete/{id}', [AdminController::class, "delete"]);

        // RESTORE
        Route::get('/restore/{id}', [AdminController::class, "restore"]);
    });
});
