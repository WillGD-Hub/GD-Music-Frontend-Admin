@extends('layout')

@section('body')
    {{-- PESAN ERROR --}}
    @if(count($errors))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <span class="fe fe-x-circle fe-16 mr-2"></span> Data song gagal dihapus!
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    {{-- PESAN GAGAL --}}
    @elseif(session('fail'))
        <div class="alert alert-fail alert-dismissible fade show" role="alert">
            <span class="fe fe-check-circle fe-16 mr-2"></span> {{session('fail')}}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    {{-- PESAN SUKSES --}}
    @elseif(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <span class="fe fe-check-circle fe-16 mr-2"></span> {{session('success')}}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    <h2 class="page-title">List Song</h2>
    <p class="text-muted">Halaman untuk melihat song.</p>

    {{-- START FILTER --}}

    <div class="card shadow mb-4">
        <div class="card-header" id="heading1">
            <a role="button" href="#filter" data-toggle="collapse" data-target="#filter" aria-expanded="false" aria-controls="filter">
                <button type="button" class="btn mb-2 btn-primary">Filter<span class="fe fe-arrow-down fe-16 ml-2"></span></button>
            </a>
        </div>
        <div id="filter" class="collapse" aria-labelledby="heading1" data-parent="#filter">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">

                        <div class="form-group mb-3">
                            <label for="genre_id">Song ID</label>
                            <input class="form-control" id="song_id" type="text" name="song_id" placeholder="Song ID">
                        </div>

                        <div class="form-group mb-3">
                            <label for="title">Title Song</label>
                            <input class="form-control" id="title" type="text" name="title" placeholder="Title">
                        </div>

                        <div class="form-group mb-3">
                            <label for="genre_id">Genre Song</label>
                            <select class="form-control select2" id="genre_id" name="genre_id">
                                <option value="" selected>- SEMUA -</option>
                                @foreach ($genres as $genre)
                                    <option value="{{$genre->genre_id}}">{{$genre->name}}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group mb-3">
                            <label for="artist_id">Artist Song</label>
                            <select class="form-control select2" id="artist_id" name="artist_id">
                                <option value="" selected>- SEMUA -</option>
                                @foreach ($artists as $artist)
                                    <option value="{{$artist->artist_id}}">{{$artist->name}}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group mb-3">
                            <label for="has_lyric">Lyric Song</label>
                            <select class="form-control" id="has_lyric" name="has_lyric">
                                <option value="" selected>- SEMUA -</option>
                                <option value="NULL">NO-LYRIC</option>
                                <option value="NOT NULL">HAS-LYRIC</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="has_hash">Hash Song</label>
                            <select class="form-control" id="has_hash" name="has_hash">
                                <option value="" selected>- SEMUA -</option>
                                <option value="0">NO-HASH</option>
                                <option value="1">HAS-HASH</option>
                            </select>
                        </div>

                        <button class="btn btn-primary" type="button" onclick="filterSong('CARI')">CARI</button>
                        <button class="btn btn-danger" type="button" onclick="filterSong('RESET')">RESET</button>
                    </div>

                    <div class="col-md-6">

                        <div class="form-group mb-3">
                            <label for="img">Image Song</label>
                            <select class="form-control" id="img" name="img">
                                <option value="" selected>- SEMUA -</option>
                                <option value="NULL">NO-IMAGE</option>
                                <option value="NON-NULL">HAS-IMAGE</option>
                            </select>
                        </div>

                        <div class="form-group mb-3">
                            <label for="file">File Song</label>
                            <select class="form-control" id="file" name="file">
                                <option value="" selected>- SEMUA -</option>
                                <option value="NULL">NO-FILE</option>
                                <option value="NON-NULL">HAS-FILE</option>
                            </select>
                        </div>

                        <div class="row">
                            <div class="form-group col-md-6">
                                <label for="total_favorite_min">Total Favorite Min</label>
                                <input class="form-control" id="total_favorite_min" type="text" name="total_favorite_min" placeholder="Total Favorite Min">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="total_favorite_max">Total Favorite Max</label>
                                <input class="form-control" id="total_favorite_max" type="text" name="total_favorite_max" placeholder="Total Favorite Max">
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-md-6">
                                <label for="total_hash_min">Total Hash Min</label>
                                <input class="form-control" id="total_hash_min" type="text" name="total_hash_min" placeholder="Total Hash Min">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="total_hash_max">Total Hash Max</label>
                                <input class="form-control" id="total_hash_max" type="text" name="total_hash_max" placeholder="Total Hash Max">
                            </div>
                        </div>

                        <div class="form-group col-md-6">
                            <label for="created_at">Created At</label>
                            <div class="input-group">
                                <div class="custom-control custom-checkbox input-group-append">
                                    <div class="input-group-text" id="button-addon-date" style="border-style: none;">
                                        <input class="form-check-input" type="checkbox" id="check_created_at" onclick="toggleDate('created')"> &nbsp;
                                    </div>
                                </div>
                                <input type="text" class="form-control drgpicker" id="created_at" name="created_at" value="{{date('m/d/Y', strtotime(date("Y/m/d") . ' +1 day'))}}" disabled>
                                <div class="input-group-append">
                                    <div class="input-group-text" id="button-addon-date"><span class="fe fe-calendar fe-16"></span></div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group col-md-6">
                            <label for="updated_at">Updated At</label>
                            <div class="input-group">
                                <div class="custom-control custom-checkbox input-group-append">
                                    <div class="input-group-text" id="button-addon-date" style="border-style: none;">
                                        <input class="form-check-input" type="checkbox" id="check_updated_at" onclick="toggleDate('updated')"> &nbsp;
                                    </div>
                                </div>
                                <input type="text" class="form-control drgpicker" id="updated_at" name="updated_at" value="{{date('m/d/Y', strtotime(date("Y/m/d") . ' +1 day'))}}" disabled>
                                <div class="input-group-append">
                                    <div class="input-group-text" id="button-addon-date"><span class="fe fe-calendar fe-16"></span></div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- END FILTER --}}

    {{-- START TABLE --}}

    <div class="row my-4">
        <div class="col-md-12">
            <div class="card shadow">
                <div class="card-header">
                    <strong class="card-title">List Song</strong>
                </div>
                <div class="card-body">
                    <a class="float-right" href="{{url('/song/insert')}}">
                        <button type="button" class="btn mb-2 btn-primary">Tambah Song</button>
                    </a>
                    <br><br><br>
                    <div id="table_container-song"></div>
                </div>
            </div>
        </div>
    </div>

    <div class="row my-4">
        <div class="col-md-12">
            <div class="card shadow">

                <div class="card-header">
                    <strong class="card-title">Control Song</strong>
                </div>

                <div class="card-body row-md-12">
                    <h4>Control Hashes</h4>
                    <div class="row-md-12 d-flex justify-content-start">
                        <button type="button" class="btn mb-2 btn-primary mr-2" url="{{url('/song/get-all-hash')}}" id="button_get_hash">Get All Hash with No Hash</button>
                        <button type="button" class="btn mb-2 btn-warning ml-2" url="{{url('/song/refresh-hash')}}" id="button_refresh_hash">Refresh All Hash</button>
                    </div>
                </div>

                <div class="card-body row-md-12">
                    <h4>Control Lyrics</h4>
                    <form action="{{url('/crawl/get-lyric/-1')}}" method="get" id="form_lyrics">
                        @csrf
                        <div class="form-group mb-3">
                            <label for="crawl_id">Crawl Sources</label>
                            <select class="form-control" id="crawl_id" name="crawl_id">
                                @foreach ($crawls as $item)
                                    <option value="{{$item->crawl_id}}">{{$item->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group mb-3">
                            <label for="crawl_option">Get Lyrics Type</label>
                            <select class="form-control" id="crawl_option" name="crawl_option">
                                <option value="get">Get All Lyrics with No Lyrics</option>
                                <option value="refresh">Refresh Lyrics</option>
                            </select>
                        </div>
                        <div class="d-flex justify-content-start">
                            <button type="submit" class="btn mb-2 btn-primary" id="button_get_lyric">Get Lyrics</button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>

    {{-- END TABLE --}}

@endsection

@push('script')
    <script>
        $(document).ready(function () {
            filterSong("RESET");
        });

        $("#button_get_hash").click(function() {
            confirmationModal(
                "Hash song",
                "Apakah anda yakin untuk mendapatkan semua hash pada data song yang tidak memiliki hash?",
                $(this).attr('url')
            );
        });

        $("#button_refresh_hash").click(function() {
            confirmationModal(
                "Hash song",
                "Apakah anda yakin untuk menghapus dan mendapatkan kembali semua hash pada semua data song?",
                $(this).attr('url')
            );
        });

        const toggleDate = (tipe) => {
            document.getElementById(tipe + "_at").disabled = !document.getElementById("check_" + tipe + "_at").checked;
        }

        const filterSong = (mode) => {
            if(mode == "RESET") {
                $('#song_id').val("");
                $('#title').val("");
                $('#genre_id').val("");
                $('#artist_id').val("");
                $('#img').val("");
                $('#file').val("");
                $('#total_favorite_min').val("");
                $('#total_favorite_max').val("");
                $('#total_hash_min').val("");
                $('#total_hash_max').val("");
                $('#has_lyric').val("");
                $('#has_hash').val("");

                $('#check_created_at').prop("checked", false);
                $('#check_updated_at').prop("checked", false);

                toggleDate("created");
                toggleDate("updated");
            }

            $.ajax({
                method : "GET",
                url : "/song/filter-song",
                datatype : "json",
                data : {
                    _token : " {{csrf_token()}} ",
                    param : {
                        "song_id": $('#song_id').val(),
                        "title": $('#title').val(),
                        "genre_id": $('#genre_id').val(),
                        "artist_id": $('#artist_id').val(),
                        "img": $('#img').val(),
                        "file": $('#file').val(),
                        "total_favorite_min": $('#total_favorite_min').val(),
                        "total_favorite_max": $('#total_favorite_max').val(),
                        "total_hash_min": $('#total_hash_min').val(),
                        "total_hash_max": $('#total_hash_max').val(),
                        "has_lyric": $('#has_lyric').val(),
                        "has_hash": $('#has_hash').val(),

                        "created_at": $('#created_at').val(),
                        "updated_at": $('#updated_at').val(),
                    },
                    mode : mode
                },
                success: function(result){
                    $('#table_container-song').html(result);
                }
            });
        }
    </script>
@endpush
