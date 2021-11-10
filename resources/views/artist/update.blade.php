@extends('layout')

@section('body')
    {{-- PESAN ERROR --}}
    @if(count($errors))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <span class="fe fe-x-circle fe-16 mr-2"></span> Data artist gagal diubah!
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
    <h2 class="page-title">Update Artist</h2>
    <p class="text-muted">Halaman untuk mengubah artist.</p>

    {{-- START FORM --}}

    <form action="{{url('/artist/update/' . $artist->artist_id)}}" method="post" enctype="multipart/form-data">
        @csrf
        <div class="card shadow mb-4">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">

                        <div class="form-group mb-3">
                            <label>ID Artist</label>
                            <input class="form-control" type="text" value="{{$artist->artist_id}}" disabled>
                        </div>

                        <div class="form-group mb-3">
                            <label for="name">Nama Artist</label>
                            <input class="form-control @if (count($errors)) @error('name') is-invalid @else is-valid @enderror @endif"
                            id="name" type="text" name="name" placeholder="Nama Artist" value="{{$artist->name}}"  @if ($artist->deleted_at) disabled @endif>
                            <div class="valid-feedback"> Sudah benar! </div>
                            <div class="invalid-feedback">@error('name') {{$message}} @enderror</div>
                        </div>

                        <div class="form-group mb-3">
                            <label for="genre_id">Genre Artist</label>
                            <select class="form-control select2 @if(count($errors)) @error('genre_id') is-invalid @else is-valid @enderror @endif"
                            id="genre_id" name="genre_id">
                                <option value="" selected>- PILIH GENRE ARTIST -</option>
                                @foreach ($genres as $item)
                                    <option value="{{$item->genre_id}}"@if ($artist->genre_id == $item->genre_id) selected @endif>{{$item->name}}</option>
                                @endforeach
                            </select>
                            <div class="valid-feedback"> Sudah benar! </div>
                            <div class="invalid-feedback">@error('genre_id') {{$message}} @enderror</div>
                        </div>

                        <div class="form-group mb-3">
                            <label for="img">Image Artist</label><br>
                            @if ($artist->img)
                                <img src="{{env('BACK_END_URL') . "/storage/" . session('auth_token') . "/images-artist/" . $artist->img}}" class="card-img-top img-fluid rounded">
                                <br><br>
                                <u><b>{{$artist->img}}</b></u>
                            @else
                                <u><b>NO-IMAGE</b></u>
                            @endif
                            <br><br>
                            <input type="file" class="@if (count($errors)) @error('img') is-invalid @else is-valid @enderror @endif" id="img" name="img" @if ($artist->deleted_at) disabled @endif>
                            <div class="valid-feedback"> Sudah benar! </div>
                            <div class="invalid-feedback">@error('img') {{$message}} @enderror</div>
                        </div>

                        @if ($artist->deleted_at)
                            <button class="btn btn-warning" type="button" url="{{url('artist/restore/'.$artist->artist_id)}}" id="button_restore">KEMBALIKAN</button>
                        @else
                            <button class="btn btn-primary" type="submit">UBAH</button>
                            <button class="btn btn-danger" type="button" url="{{url('artist/delete/'.$artist->artist_id)}}" id="button_delete">HAPUS</button>
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
                "Hapus artist",
                "Apakah anda yakin untuk menghapus artist ini?",
                $(this).attr('url')
            );
        });

        $("#button_restore").click(function() {
            confirmationModal(
                "Restore artist",
                "Apakah anda yakin untuk restore artist ini?",
                $(this).attr('url')
            );
        });
    </script>
@endpush
