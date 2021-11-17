@extends('layout')

@section('body')
    {{-- PESAN ERROR --}}
    @if(count($errors))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <span class="fe fe-x-circle fe-16 mr-2"></span> Data crawl gagal diubah!
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


    <h4><a href="{{url('/crawl')}}"><span class="fe fe-chevrons-left"></span> Kembali</a></h4>
    <br>
    <h2 class="page-title">Update Crawl</h2>
    <p class="text-muted">Halaman untuk mengubah crawl.</p>

    {{-- START FORM --}}

    <form action="{{url('/crawl/update/' . $crawl->crawl_id)}}" method="post">
        @csrf
        <div class="card shadow mb-4">
            <div class="card-body">
                <div class="row">

                    <div class="col-md-6">

                        <div class="form-group mb-3">
                            <label for="name">Nama Website</label>
                            <input class="form-control @if (count($errors)) @error('name') is-invalid @else is-valid @enderror @endif"
                            id="name" type="text" name="name" placeholder="Nama Website" value="{{$crawl->name}}">
                            <div class="valid-feedback"> Sudah benar! </div>
                            <div class="invalid-feedback">@error('name') {{$message}} @enderror</div>
                        </div>

                        <div class="form-group mb-3">
                            <label for="url">URL Website</label>
                            <input class="form-control @if (count($errors)) @error('url') is-invalid @else is-valid @enderror @endif"
                            id="url" type="text" name="url" placeholder="URL Website" value="{{$crawl->url}}">
                            <div class="valid-feedback"> Sudah benar! </div>
                            <div class="invalid-feedback">@error('url') {{$message}} @enderror</div>
                        </div>

                        <div class="form-group mb-3">
                            <label for="max_depth">Max Depth</label>
                            <input class="form-control @if (count($errors)) @error('max_depth') is-invalid @else is-valid @enderror @endif"
                            id="max_depth" type="text" name="max_depth" placeholder="Max Depth" value="{{$crawl->max_depth}}">
                            <div class="valid-feedback"> Sudah benar! </div>
                            <div class="invalid-feedback">@error('max_depth') {{$message}} @enderror</div>
                        </div>

                        <div class="form-group mb-3">
                            <label for="regex">Regex (pemisah antar regex enter )</label>
                            <textarea class="form-control" id="regex" name="regex" rows="5" @if (count($errors)) @error('regex') is-invalid @else is-valid @enderror @endif>{{$crawl->regex}}</textarea>
                            <div class="valid-feedback"> Sudah benar! </div>
                            <div class="invalid-feedback">@error('regex') {{$message}} @enderror</div>
                        </div>

                        <button class="btn btn-primary" type="submit">UBAH</button>
                        <button class="btn btn-danger" type="button" id="button_delete" url="{{url('crawl/delete/'.$crawl->crawl_id)}}" >DELETE</button>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label for="tag_stop">Tag Stop</label>
                            <input class="form-control @if (count($errors)) @error('tag_stop') is-invalid @else is-valid @enderror @endif"
                            id="tag_stop" type="text" name="tag_stop" placeholder="tag.class|inside/next|number" value="{{$crawl->tag_stop}}">
                            <div class="valid-feedback"> Sudah benar! </div>
                            <div class="invalid-feedback">@error('tag_stop') {{$message}} @enderror</div>
                        </div>

                        <div class="form-group mb-3">
                            <label for="tag_title">Tag Title</label>
                            <input class="form-control @if (count($errors)) @error('tag_title') is-invalid @else is-valid @enderror @endif"
                            id="tag_title" type="text" name="tag_title" placeholder="tag.class|inside/next|number" value="{{$crawl->tag_title}}">
                            <div class="valid-feedback"> Sudah benar! </div>
                            <div class="invalid-feedback">@error('tag_title') {{$message}} @enderror</div>
                        </div>

                        <div class="form-group mb-3">
                            <label for="tag_lyrics">Tag Lyrics</label>
                            <input class="form-control @if (count($errors)) @error('tag_lyrics') is-invalid @else is-valid @enderror @endif"
                            id="tag_lyrics" type="text" name="tag_lyrics" placeholder="tag.class|inside/next|number" value="{{$crawl->tag_lyrics}}">
                            <div class="valid-feedback"> Sudah benar! </div>
                            <div class="invalid-feedback">@error('tag_lyrics') {{$message}} @enderror</div>
                        </div>

                        <div class="form-group mb-3">
                            <label for="correction">Correction (pemisah antar correction enter )</label>
                            <textarea class="form-control" id="correction" name="correction" rows="5" @if (count($errors)) @error('correction') is-invalid @else is-valid @enderror @endif>{{$crawl->correction}}</textarea>
                            <div class="valid-feedback"> Sudah benar! </div>
                            <div class="invalid-feedback">@error('correction') {{$message}} @enderror</div>
                        </div>
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
                "Hapus crawl",
                "Apakah anda yakin untuk menghapus crawl ini?",
                $(this).attr('url')
            );
        });

        // $("#button_restore").click(function() {
        //     confirmationModal(
        //         "Restore plan",
        //         "Apakah anda yakin untuk restore plan ini?",
        //         $(this).attr('url')
        //     );
        // });
    </script>
@endpush
