@extends('layout')

@section('body')
    {{-- PESAN ERROR --}}
    @if(count($errors))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <span class="fe fe-x-circle fe-16 mr-2"></span> Data song gagal ditambahkan!
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
    <h2 class="page-title">Insert Song</h2>
    <p class="text-muted">Halaman untuk menambah song baru.</p>

    {{-- START FORM --}}

    <form action="{{url('/song/insert')}}" method="post" enctype="multipart/form-data">
        @csrf
        <div class="card shadow mb-4">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">

                        <div class="form-group mb-3">
                            <label for="title">Title Song</label>
                            <input class="form-control @if (count($errors)) @error('title') is-invalid @else is-valid @enderror @endif"
                            id="title" type="text" name="title" placeholder="Title Song" value="{{old('title')}}">
                            <div class="valid-feedback"> Sudah benar! </div>
                            <div class="invalid-feedback">@error('title') {{$message}} @enderror</div>
                        </div>

                        <div class="form-group mb-3">
                            <label for="artist_id">Artist Song</label>
                            <select class="form-control select2 @if(count($errors)) @error('artist_id') is-invalid @else is-valid @enderror @endif"
                            id="artist_id" name="artist_id">
                                <option value="" selected>- PILIH SONG ARTIST -</option>
                                @foreach ($artists as $item)
                                    <option value="{{$item->artist_id}}" @if (old('artist_id') == $item->artist_id) selected @endif>{{$item->name}}</option>
                                @endforeach
                            </select>
                            <div class="valid-feedback"> Sudah benar! </div>
                            <div class="invalid-feedback">@error('artist_id') {{$message}} @enderror</div>
                        </div>

                        <div class="form-group mb-3">
                            <label for="file">File Song</label><br>
                            <input type="file" class="@if (count($errors)) @error('file') is-invalid @else is-valid @enderror @endif" id="file" name="file">
                            <div class="valid-feedback"> Sudah benar! </div>
                            <div class="invalid-feedback">@error('file') {{$message}} @enderror</div>
                        </div>

                        <div class="form-group mb-3">
                            <label for="img">Image Song</label><br>
                            <input type="file" class="@if (count($errors)) @error('img') is-invalid @else is-valid @enderror @endif" id="img" name="img">
                            <div class="valid-feedback"> Sudah benar! </div>
                            <div class="invalid-feedback">@error('img') {{$message}} @enderror</div>
                        </div>

                        <button class="btn btn-primary" type="submit">TAMBAH</button>
                    </div>
                </div>
            </div>
        </div>
    </form>

    {{-- END FORM --}}

@endsection
