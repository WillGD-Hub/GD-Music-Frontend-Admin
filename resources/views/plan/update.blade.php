@extends('layout')

@section('body')
    {{-- PESAN ERROR --}}
    @if(count($errors))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <span class="fe fe-x-circle fe-16 mr-2"></span> Data plan gagal diubah!
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


    <h4><a href="{{url('/plan')}}"><span class="fe fe-chevrons-left"></span> Kembali</a></h4>
    <br>
    <h2 class="page-title">Update Plan</h2>
    <p class="text-muted">Halaman untuk mengubah plan.</p>

    {{-- START FORM --}}

    <form action="{{url('/plan/update/' . $plan->plan_id)}}" method="post" enctype="multipart/form-data">
        @csrf
        <div class="card shadow mb-4">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">

                        <div class="form-group mb-3">
                            <label>ID Plan</label>
                            <input class="form-control" type="text" value="{{$plan->plan_id}}" disabled>
                        </div>

                        <div class="form-group mb-3">
                            <label for="name">Nama Plan</label>
                            <input class="form-control @if (count($errors)) @error('name') is-invalid @else is-valid @enderror @endif"
                            id="name" type="text" name="name" placeholder="Name" value="{{$plan->name}}"  @if ($plan->deleted_at) disabled @endif>
                            <div class="valid-feedback"> Sudah benar! </div>
                            <div class="invalid-feedback">@error('name') {{$message}} @enderror</div>
                        </div>

                        <div class="form-group mb-3">
                            <label for="price">Harga Plan</label>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">Rp.</span>
                                </div>
                                <input class="form-control input-money @if(count($errors)) @error('price') is-invalid @else is-valid @enderror @endif"
                                id="price" type="text" name="price" placeholder="Harga Plan" value="{{$plan->price}}" @if ($plan->deleted_at) disabled @endif>
                                <div class="input-group-append">
                                    <span class="input-group-text">.00</span>
                                </div>
                                <div class="valid-feedback"> Sudah benar!</div>
                                <div class="invalid-feedback"> @error('price'){{$message}}@enderror </div>
                            </div>
                        </div>


                        <div class="form-group mb-3">
                            <label for="validation">Validation Plan</label>
                            <div class="input-group mb-3">
                                <input class="form-control @if(count($errors)) @error('validation') is-invalid @else is-valid @enderror @endif"
                                id="validation" type="text" name="validation" placeholder="Validation Plan" value="{{$plan->validation}}" @if ($plan->deleted_at) disabled @endif>
                                <div class="input-group-append">
                                    <span class="input-group-text">Bulan</span>
                                </div>
                                <div class="valid-feedback"> Sudah benar!</div>
                                <div class="invalid-feedback"> @error('validation'){{$message}}@enderror </div>
                            </div>
                        </div>

                        @if ($plan->deleted_at)
                            <button class="btn btn-warning" type="button" url="{{url('plan/restore/'.$plan->plan_id)}}" id="button_restore">KEMBALIKAN</button>
                        @else
                            <button class="btn btn-primary" type="submit">UBAH</button>
                            <button class="btn btn-danger" type="button" url="{{url('plan/delete/'.$plan->plan_id)}}" id="button_delete">HAPUS</button>
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
