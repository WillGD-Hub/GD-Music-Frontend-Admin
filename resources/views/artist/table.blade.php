@if (count($artists) == 0)

    <center><h2>- NO RECORD -</h2></center>

@else
    <table class="table datatables" id="list_table">
        <thead>
            <tr>
                <th>ID Artist</th>
                <th>Nama</th>
                <th>Genre</th>
                <th>Images</th>
                <th>Total Song</th>
                <th>Created At</th>
                <th>Updated At</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($artists as $item)
                <tr>
                    <td>{{$item->artist_id}}</td>
                    <td>{{$item->name}}</td>
                    <td>{{$item->Genre->name}}</td>
                    <td>
                        <span class="badge badge-pill @if($item->img == null) badge-danger @else badge-success @endif" style="font-size: 100%;">
                            @if ($item->img == null) NO-IMAGE @else HAS-IMAGE @endif
                        </span>
                    </td>
                    <td>{{$countSong->where('artist_id', $item->artist_id)->count()}}</td>
                    <td>{{$item->created_at}}</td>
                    <td>{{$item->updated_at}}</td>
                    <td>
                        <span class="badge badge-pill @if($item->deleted_at == null) badge-success @else badge-danger @endif" style="font-size: 100%;">
                            @if ($item->deleted_at == null) AVAILABLE @else DELETED @endif
                        </span>
                    </td>
                    <td><a href="{{url('/artist/update/'.$item->artist_id)}}"><button class="btn btn-primary">Edit</button></a></td>
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
