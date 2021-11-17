@extends('layout')

@section('body')
    {{-- PESAN ERROR --}}
    @if(count($errors))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <span class="fe fe-x-circle fe-16 mr-2"></span> Data song gagal diubah!
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


    <h4><a href="{{url('/song')}}"><span class="fe fe-chevrons-left"></span> Kembali</a></h4>
    <br>
    <h2 class="page-title">Update Song</h2>
    <p class="text-muted">Halaman untuk mengubah song.</p>

    {{-- START FORM --}}

    <form action="{{url('/song/update/' . $song->song_id)}}" method="post" enctype="multipart/form-data">
        @csrf
        <div class="card shadow mb-4">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">

                        <div class="form-group mb-3">
                            <label>ID Song</label>
                            <input class="form-control" type="text" value="{{$song->song_id}}" disabled>
                        </div>

                        <div class="form-group mb-3">
                            <label for="title">Title Song</label>
                            <input class="form-control @if (count($errors)) @error('title') is-invalid @else is-valid @enderror @endif"
                            id="title" type="text" name="title" placeholder="Title Song" value="{{$song->title}}"  @if ($song->deleted_at) disabled @endif>
                            <div class="valid-feedback"> Sudah benar! </div>
                            <div class="invalid-feedback">@error('title') {{$message}} @enderror</div>
                        </div>

                        <div class="form-group mb-3">
                            <label for="artist_id">Artist Song</label>
                            <select class="form-control select2 @if(count($errors)) @error('artist_id') is-invalid @else is-valid @enderror @endif"
                            id="artist_id" name="artist_id">
                                <option value="" selected>- PILIH SONG ARTIST -</option>
                                @foreach ($artists as $item)
                                    <option value="{{$item->artist_id}}" @if ($song->artist_id == $item->artist_id) selected @endif>{{$item->name}}</option>
                                @endforeach
                            </select>
                            <div class="valid-feedback"> Sudah benar! </div>
                            <div class="invalid-feedback">@error('artist_id') {{$message}} @enderror</div>
                        </div>

                        <div class="form-group mb-3">
                            <label for="img">File Song</label><br>
                            @if ($song->file)
                                <audio controls>
                                    <source src="{{env('BACK_END_URL') . "/storage/" . session('auth_token') . "/songs/" . $song->file}}" type="audio/mpeg">
                                    Your browser does not support the audio element.
                                </audio>
                            @else
                                <u><b>NO-FILE</b></u>
                            @endif
                            <br><br>
                            <input type="file" class="@if (count($errors)) @error('file') is-invalid @else is-valid @enderror @endif" id="file" name="file" @if ($song->deleted_at) disabled @endif>
                            <div class="valid-feedback"> Sudah benar! </div>
                            <div class="invalid-feedback">@error('file') {{$message}} @enderror</div>
                        </div>

                        <div class="form-group mb-3">
                            <label for="img">Image Song</label>
                            <br>
                            @if ($song->img)
                                <img src="{{env('BACK_END_URL') . "/storage/" . session('auth_token') . "/images-song/" . $song->img}}" class="card-img-top img-fluid rounded">
                            @else
                                <u><b>NO-IMAGE</b></u>
                            @endif
                            <br><br>
                            <input type="file" class="@if (count($errors)) @error('img') is-invalid @else is-valid @enderror @endif" id="img" name="img" @if ($song->deleted_at) disabled @endif>
                            <div class="valid-feedback"> Sudah benar! </div>
                            <div class="invalid-feedback">@error('img') {{$message}} @enderror</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card shadow mb-4">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">

                        <div class="form-group mb-3">
                            <label>Total Favorite</label>
                            <h4>{{$song->total_favorite}}</h4>
                        </div>

                        <div class="form-group mb-3">
                            <label>Total Hash</label>
                            <h4>{{$song->total_hash}}</h4>
                        </div>

                        @if ($song->lyrics != null)
                            <div class="form-group mb-3">
                                <label>Source Lyrics</label>
                                <h4>{{$song->source_lyrics}}</h4>
                            </div>
                        @endif

                        <div class="form-group mb-3">
                            <label for="title">Lyrics</label>
                            <textarea class="form-control" id="lyric" name="lyric" rows="10" @if ($song->deleted_at) disabled @endif>{{$song->lyrics}}</textarea>
                            <div class="valid-feedback"> Sudah benar! </div>
                            <div class="invalid-feedback">@error('title') {{$message}} @enderror</div>
                        </div>

                        @if ($song->deleted_at)
                            <button class="btn btn-warning" type="button" url="{{url('song/restore/'.$song->song_id)}}" id="button_restore">KEMBALIKAN</button>
                        @else
                            <button class="btn btn-primary" type="submit">UBAH</button>
                            <button class="btn btn-danger" type="button" url="{{url('song/delete/'.$song->song_id)}}" id="button_delete">HAPUS</button>
                        @endif
                    </div>
                </div>
            </div>
        </div>

    </form>



    @if ($song->deleted_at == null)

        <div class="row my-4">
            <div class="col-md-12">
                <div class="card shadow">

                    <div class="card-header">
                        <strong class="card-title">Control Song</strong>
                    </div>

                    <div class="card-body row-md-12">
                        <h4>Control Hashes</h4>
                        <div class="row-md-12 d-flex justify-content-start">
                            <button class="btn btn-primary" type="button" id="button_hash" url="{{url('song/hash/'.$song->song_id)}}">Get Hash</button>
                        </div>
                    </div>

                    <div class="card-body row-md-12">
                        <h4>Control Lyrics</h4>
                        <form action="{{url('/crawl/get-lyric/'.$song->song_id)}}" method="get" id="form_lyrics">
                            @csrf
                            <div class="form-group mb-3 mt-3">
                                <label for="crawl_id">Crawl Sources</label>
                                <select class="form-control" id="crawl_id" name="crawl_id">
                                    @foreach ($crawls as $item)
                                        <option value="{{$item->crawl_id}}">{{$item->name}}</option>
                                    @endforeach
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

    @endif
@endsection

@push('script')
    <script>
        $("#button_hash").click(function() {
            confirmationModal(
                "Hash song",
                "Apakah anda yakin untuk mendapatkan hash song ini?",
                $(this).attr('url')
            );
        });

        $("#button_lyric").click(function() {
            confirmationModal(
                "Lyric song",
                "Apakah anda yakin untuk mendapatkan lyric song ini?",
                $(this).attr('url')
            );
        });

        $("#button_delete").click(function() {
            confirmationModal(
                "Hapus song",
                "Apakah anda yakin untuk menghapus song ini?",
                $(this).attr('url')
            );
        });

        $("#button_restore").click(function() {
            confirmationModal(
                "Restore song",
                "Apakah anda yakin untuk restore song ini?",
                $(this).attr('url')
            );
        });
    </script>
@endpush
