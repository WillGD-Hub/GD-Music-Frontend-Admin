@extends('layout')

@section('body')

    <h4><a href="{{url('/user')}}"><span class="fe fe-chevrons-left"></span> Kembali</a></h4>
    <br>
    <h2 class="page-title">View User</h2>
    <p class="text-muted">Halaman untuk melihat user.</p>

    {{-- START FORM --}}

    <div class="card shadow mb-4">
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">

                    <div class="form-group mb-3">
                        <label>Username</label>
                        <h4>{{$user->username}}</h4>
                    </div>

                    <div class="form-group mb-3">
                        <label>Plan Sekarang</label>
                        <h4>{{$user->Plan->name}}</h4>
                    </div>


                    <div class="form-group mb-3">
                        <label>Payment History</label>
                        <br><br>
                        <table class="table datatables" id="list_table">
                            <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>Plan</th>
                                    <th>Price</th>
                                    <th>Validation</th>
                                </tr>
                            </thead>
                            <tbody id="table-body">
                                @if ($user->Payment)
                                    @foreach ($user->Payment as $item)
                                        <tr>
                                            <td>{{$item->pivot->date}}</td>
                                            <td>{{$item->name}}</td>
                                            <td>{{$item->pivot->price}}</td>
                                            <td>{{$item->pivot->validation}}</td>
                                        </tr>
                                    @endforeach
                                @endif
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <script>
        $('#list_table').DataTable(
        {
            autoWidth: true,
            "lengthMenu": [
            [10, 20, 30, -1],
            [10, 20, 30, "All"]
            ],
            "order": [[ 0, "desc" ]]
        });

    </script>
@endpush
