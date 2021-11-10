@extends('layout')

@section('body')
    {{-- PESAN ERROR --}}
    @if(count($errors))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <span class="fe fe-x-circle fe-16 mr-2"></span> Data plan gagal dihapus!
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

    <h2 class="page-title">List Plan</h2>
    <p class="text-muted">Halaman untuk melihat plan.</p>

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
                            <label for="plan_id">Plan ID</label>
                            <input class="form-control" id="plan_id" type="text" name="plan_id" placeholder="Plan ID">
                        </div>

                        <div class="form-group mb-3">
                            <label for="name">Nama Plan</label>
                            <input class="form-control" id="name" type="text" name="name" placeholder="Name">
                        </div>

                        <div class="row">
                            <div class="form-group col-md-6">
                                <label for="price_min">Harga Min Plan</label>
                                <input class="form-control" id="price_min" type="text" name="price_min" placeholder="Harga Min Plan">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="price_max">Harga Max Plan</label>
                                <input class="form-control" id="price_max" type="text" name="price_max" placeholder="Harga Max Plan">
                            </div>
                        </div>

                        <div class="form-group mb-3">
                            <label for="img">Validation Plan</label>
                            <input class="form-control" id="validation" type="text" name="validation" placeholder="Validation">
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

                        <button class="btn btn-primary" type="button" onclick="filterPlan('CARI')">CARI</button>
                        <button class="btn btn-danger" type="button" onclick="filterPlan('RESET')">RESET</button>
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
                    <a class="float-right" href="{{url('/plan/insert')}}">
                        <button type="button" class="btn mb-2 btn-primary">Tambah Plan</button>
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
            filterPlan("RESET");
        });

        const toggleDate = (tipe) => {
            document.getElementById(tipe + "_at").disabled = !document.getElementById("check_" + tipe + "_at").checked;
        }

        const filterPlan = (mode) => {
            if(mode == "RESET") {
                $('#plan_id').val("");
                $('#name').val("");
                $('#price_min').val("");
                $('#price_max').val("");
                $('#validation').val("");

                $('#check_created_at').prop("checked", false);
                $('#check_updated_at').prop("checked", false);

                toggleDate("created");
                toggleDate("updated");
            }

            $.ajax({
                method : "GET",
                url : "/plan/filter-plan",
                datatype : "json",
                data : {
                    _token : " {{csrf_token()}} ",
                    param : {
                        "plan_id": $('#plan_id').val(),
                        "name": $('#name').val(),
                        "price_min": $('#price_min').val(),
                        "price_max": $('#price_max').val(),
                        "validation": $('#validation').val(),
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
