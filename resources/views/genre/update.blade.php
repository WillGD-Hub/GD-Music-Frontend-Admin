@extends('layout')

@section('body')
    {{-- PESAN ERROR --}}
    @if(count($errors))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <span class="fe fe-x-circle fe-16 mr-2"></span> Data genre gagal diubah!
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


    <h4><a href="{{url('/genre')}}"><span class="fe fe-chevrons-left"></span> Kembali</a></h4>
    <br>
    <h2 class="page-title">Update Genre</h2>
    <p class="text-muted">Halaman untuk mengubah genre.</p>

    {{-- START FORM --}}

    <form action="{{url('/genre/update/' . $genre->genre_id)}}" method="post" enctype="multipart/form-data">
        @csrf
        <div class="card shadow mb-4">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">

                        <div class="form-group mb-3">
                            <label>ID Genre</label>
                            <input class="form-control" type="text" value="{{$genre->genre_id}}" disabled>
                        </div>

                        <div class="form-group mb-3">
                            <label for="name">Nama Genre</label>
                            <input class="form-control @if (count($errors)) @error('name') is-invalid @else is-valid @enderror @endif"
                            id="name" type="text" name="name" placeholder="Nama Genre" value="{{$genre->name}}" @if ($genre->deleted_at) disabled @endif>
                            <div class="valid-feedback"> Sudah benar! </div>
                            <div class="invalid-feedback">@error('name') {{$message}} @enderror</div>
                        </div>

                        <div class="form-group mb-3">
                            <label for="img">Image Genre</label><br>
                            @if ($genre->img)
                                <img src="{{env('BACK_END_URL') . "/storage/" . session('auth_token') . "/images-genre/" . $genre->img}}" class="card-img-top img-fluid rounded">
                            @else
                                <u><b>NO-IMAGE</b></u>
                            @endif
                            <br><br>
                            <input type="file" class="@if (count($errors)) @error('img') is-invalid @else is-valid @enderror @endif" id="img" name="img" @if ($genre->deleted_at) disabled @endif>
                            <div class="valid-feedback"> Sudah benar! </div>
                            <div class="invalid-feedback">@error('img') {{$message}} @enderror</div>
                        </div>

                        @if ($genre->deleted_at)
                            <button class="btn btn-warning" type="button" url="{{url('genre/restore/'.$genre->genre_id)}}" id="button_restore">KEMBALIKAN</button>
                        @else
                            <button class="btn btn-primary" type="submit">UBAH</button>
                            <button class="btn btn-danger" type="button" url="{{url('genre/delete/'.$genre->genre_id)}}" id="button_delete">HAPUS</button>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection

@push('script')
    <script>
        $("#button_delete").click(function() {
            confirmationModal(
                "Hapus genre",
                "Apakah anda yakin untuk menghapus genre ini?",
                $(this).attr('url')
            );
        });

        $("#button_restore").click(function() {
            confirmationModal(
                "Restore genre",
                "Apakah anda yakin untuk restore genre ini?",
                $(this).attr('url')
            );
        });
    </script>
@endpush
