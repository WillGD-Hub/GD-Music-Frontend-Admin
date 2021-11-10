@extends('layout')

@section('body')
    {{-- PESAN ERROR --}}
    @if(count($errors))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <span class="fe fe-x-circle fe-16 mr-2"></span> Data artist gagal dihapus!
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

    <h2 class="page-title">List Artist</h2>
    <p class="text-muted">Halaman untuk melihat artist.</p>

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
                            <label for="genre_id">Artist ID</label>
                            <input class="form-control" id="artist_id" type="text" name="artist_id" placeholder="Artist ID">
                        </div>

                        <div class="form-group mb-3">
                            <label for="name">Nama Artist</label>
                            <input class="form-control" id="name" type="text" name="name" placeholder="Name">
                        </div>

                        <div class="form-group mb-3">
                            <label for="genre_id">Genre Artist</label>
                            <select class="form-control select2" id="genre_id" name="genre_id">
                                <option value="" selected>- SEMUA -</option>
                                @foreach ($genres as $genre)
                                    <option value="{{$genre->genre_id}}">{{$genre->name}}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group mb-3">
                            <label for="img">Image Artist</label>
                            <select class="form-control select2" id="img" name="img">
                                <option value="" selected>- SEMUA -</option>
                                <option value="NULL">NO-IMAGE</option>
                                <option value="NON-NULL">HAS-IMAGE</option>
                            </select>
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

                        <button class="btn btn-primary" type="button" onclick="filterArtist('CARI')">CARI</button>
                        <button class="btn btn-danger" type="button" onclick="filterArtist('RESET')">RESET</button>
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
                <div class="card-body">
                    <a class="float-right" href="{{url('/artist/insert')}}">
                        <button type="button" class="btn mb-2 btn-primary">Tambah Artist</button>
                    </a>
                    <br><br><br>
                    <div id="table_container"></div>
                </div>
            </div>
        </div>
    </div>

    {{-- END TABLE --}}

@endsection

@push('script')
    <script>
        $(document).ready(function () {
            filterArtist("RESET");
        });

        const toggleDate = (tipe) => {
            document.getElementById(tipe + "_at").disabled = !document.getElementById("check_" + tipe + "_at").checked;
        }

        const filterArtist = (mode) => {
            if(mode == "RESET") {
                $('#artist_id').val("");
                $('#name').val("");
                $('#genre_id').val("");
                $('#img').val("");

                $('#check_created_at').prop("checked", false);
                $('#check_updated_at').prop("checked", false);

                toggleDate("created");
                toggleDate("updated");
            }

            $.ajax({
                method : "GET",
                url : "/artist/filter-artist",
                datatype : "json",
                data : {
                    _token : " {{csrf_token()}} ",
                    param : {
                        "artist_id": $('#artist_id').val(),
                        "name": $('#name').val(),
                        "genre_id": $('#genre_id').val(),
                        "img": $('#img').val(),
                        "created_at": $('#created_at').val(),
                        "updated_at": $('#updated_at').val(),
                    },
                    mode : mode
                },
                success: function(result){
                    $('#table_container').html(result);
                }
            });
        }
    </script>
@endpush
