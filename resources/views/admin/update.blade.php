@extends('layout')

@section('body')
    {{-- PESAN ERROR --}}
    @if(count($errors))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <span class="fe fe-x-circle fe-16 mr-2"></span> Data admin gagal diubah!
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


    <h4><a href="{{url('/admin')}}"><span class="fe fe-chevrons-left"></span> Kembali</a></h4>
    <br>
    <h2 class="page-title">Update Admin</h2>
    <p class="text-muted">Halaman untuk mengubah admin.</p>

    {{-- START FORM --}}

    <form action="{{url('/admin/update/' . $admin->username)}}" method="post" enctype="multipart/form-data">
        @csrf
        <div class="card shadow mb-4">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">

                        <div class="form-group mb-3">
                            <label for="username">Username Admin</label>
                            <input class="form-control" id="username" type="text" name="username" placeholder="Username Admin" value="{{$admin->username}}" disabled>
                        </div>

                        <div class="form-group mb-3">
                            <label for="password">Password Admin</label>
                            <input class="form-control @if (count($errors)) @error('password') is-invalid @else is-valid @enderror @endif"
                            id="password" type="password" name="password" placeholder="Password Admin">
                            <div class="valid-feedback"> Sudah benar! </div>
                            <div class="invalid-feedback">@error('password') {{$message}} @enderror</div>
                        </div>

                        <div class="form-group mb-3">
                            <label for="password_confirmation">Konfirmasi Password Admin</label>
                            <input class="form-control @if (count($errors)) @error('password') is-invalid @else is-valid @enderror @endif"
                            id="password_confirmation" type="password" name="password_confirmation" placeholder="Konfirmasi Password Admin">
                            <div class="valid-feedback"> Sudah benar! </div>
                            <div class="invalid-feedback">@error('password') {{$message}} @enderror</div>
                        </div>

                        @if ($admin->deleted_at)
                            <button class="btn btn-warning" type="button" url="{{url('plan/restore/'.$admin->username)}}" id="button_restore">KEMBALIKAN</button>
                        @else
                            <button class="btn btn-primary" type="submit">UBAH</button>
                            <button class="btn btn-danger" type="button" url="{{url('plan/delete/'.$admin->username)}}" id="button_delete">HAPUS</button>
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
                "Hapus plan",
                "Apakah anda yakin untuk menghapus plan ini?",
                $(this).attr('url')
            );
        });

        $("#button_restore").click(function() {
            confirmationModal(
                "Restore plan",
                "Apakah anda yakin untuk restore plan ini?",
                $(this).attr('url')
            );
        });
    </script>
@endpush
