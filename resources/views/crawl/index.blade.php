@extends('layout')

@section('body')
    {{-- PESAN ERROR --}}
    @if(count($errors))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <span class="fe fe-x-circle fe-16 mr-2"></span> Data crawl gagal dihapus!
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

    <h2 class="page-title">List Crawl</h2>
    <p class="text-muted">Halaman untuk melihat crawl.</p>

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
                            <label for="crawl_id">Crawl ID</label>
                            <input class="form-control" id="crawl_id" type="text" name="crawl_id" placeholder="Crawl ID">
                        </div>

                        <div class="form-group mb-3">
                            <label for="name">Nama URL</label>
                            <input class="form-control" id="name" type="text" name="name" placeholder="Name">
                        </div>

                        <div class="form-group mb-3">
                            <label for="url">URL Website</label>
                            <input class="form-control" id="url" type="text" url="url" placeholder="URL">
                        </div>

                        <button class="btn btn-primary" type="button" onclick="filterCrawl('CARI')">CARI</button>
                        <button class="btn btn-danger" type="button" onclick="filterCrawl('RESET')">RESET</button>
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
                    <a class="float-right" href="{{url('/crawl/insert')}}">
                        <button type="button" class="btn mb-2 btn-primary">Tambah Crawl</button>
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
            filterCrawl("RESET");
        });

        const filterCrawl = (mode) => {
            if(mode == "RESET") {
                $('#crawl_id').val("");
                $('#name').val("");
                $('#url').val("");
            }

            $.ajax({
                method : "GET",
                url : "/crawl/filter-crawl",
                datatype : "json",
                data : {
                    _token : " {{csrf_token()}} ",
                    param : {
                        "crawl_id": $('#crawl_id').val(),
                        "name": $('#name').val(),
                        "url": $('#url').val(),
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
