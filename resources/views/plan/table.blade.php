@if (count($plans) == 0)

    <center><h2>- NO RECORD -</h2></center>

@else
    <table class="table datatables" id="list_table">
        <thead>
            <tr>
                <th>ID Plan</th>
                <th>Nama</th>
                <th>Harga</th>
                <th>Validation</th>
                <th>Created At</th>
                <th>Updated At</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($plans as $item)
                <tr>
                    <td>{{$item->plan_id}}</td>
                    <td>{{$item->name}}</td>
                    <td>{{$item->price}}</td>
                    <td>{{$item->validation . " Bulan"}}</td>
                    <td>{{$item->created_at}}</td>
                    <td>{{$item->updated_at}}</td>
                    <td>
                        <span class="badge badge-pill @if($item->deleted_at == null) badge-success @else badge-danger @endif" style="font-size: 100%;">
                            @if ($item->deleted_at == null) <i class="fe fe-check-circle fe-16"></i> @else <i class="fe fe-x-circle fe-16"></i> @endif
                        </span>
                    </td>
                    <td><a href="{{url('/plan/update/'.$item->plan_id)}}"><button class="btn btn-primary">Edit</button></a></td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <script>
        $('#list_table').DataTable(
        {
            autoWidth: true,
            "lengthMenu": [
            [10, 20, 30, -1],
            [10, 20, 30, "All"]
            ]
        });
    </script>

@endif
