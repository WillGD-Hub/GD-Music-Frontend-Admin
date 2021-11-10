@if (count($admins) == 0)

    <center><h2>- NO RECORD -</h2></center>

@else
    <table class="table datatables" id="list_table">
        <thead>
            <tr>
                <th>Username</th>
                <th>Role</th>
                <th>Created At</th>
                <th>Updated At</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($admins as $item)
                <tr>
                    <td>{{$item->username}}</td>
                    <td>{{$item->role}}</td>
                    <td>{{$item->created_at}}</td>
                    <td>{{$item->updated_at}}</td>
                    <td>
                        <span class="badge badge-pill @if($item->deleted_at == null) badge-success @else badge-danger @endif" style="font-size: 100%;">
                            @if ($item->deleted_at == null) AVAILABLE @else DELETED @endif
                        </span>
                    </td>
                    <td><a href="{{url('/admin/update/'.$item->username)}}"><button class="btn btn-primary">Edit</button></a></td>
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
