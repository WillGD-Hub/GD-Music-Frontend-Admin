@extends('layout')

@section('body')
    {{-- PESAN ERROR --}}
    @if(count($errors))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <span class="fe fe-x-circle fe-16 mr-2"></span> Data artist gagal ditambahkan!
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

    <h4><a href="{{url('/artist')}}"><span class="fe fe-chevrons-left"></span> Kembali</a></h4>
    <br>
    <h2 class="page-title">Insert Artist</h2>
    <p class="text-muted">Halaman untuk menambah artist baru.</p>

    {{-- START FORM --}}

    <form action="{{url('/artist/insert')}}" method="post" enctype="multipart/form-data">
        @csrf
        <div class="card shadow mb-4">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">

                        <div class="form-group mb-3">
                            <label for="name">Nama Artist</label>
                            <input class="form-control @if (count($errors)) @error('name') is-invalid @else is-valid @enderror @endif"
                            id="name" type="text" name="name" placeholder="Nama Artist" value="{{old('name')}}">
                            <div class="valid-feedback"> Sudah benar! </div>
                            <div class="invalid-feedback">@error('name') {{$message}} @enderror</div>
                        </div>

                        <div class="form-group mb-3">
                            <label for="genre_id">Genre Artist</label>
                            <select class="form-control select2 @if(count($errors)) @error('genre_id') is-invalid @else is-valid @enderror @endif"
                            id="genre_id" name="genre_id">
                                <option value="" selected>- PILIH GENRE ARTIST -</option>
                                @foreach ($genres as $item)
                                    <option value="{{$item->genre_id}}"@if (old('genre_id') == $item->genre_id) selected @endif>{{$item->name}}</option>
                                @endforeach
                            </select>
                            <div class="valid-feedback"> Sudah benar! </div>
                            <div class="invalid-feedback">@error('genre_id') {{$message}} @enderror</div>
                        </div>

                        <div class="form-group mb-3">
                            <label for="img">Image Artist</label><br>
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
