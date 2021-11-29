@if (count($songs) == 0)

    <center><h2>- NO RECORD -</h2></center>

@else
    <table class="table datatables" id="list_table">
        <thead>
            <tr>
                <th>ID Song</th>
                <th>Title</th>
                <th>Artist</th>
                <th>Genre</th>
                <th>Total Favorite</th>
                <th>Total Hash</th>
                <th>File</th>
                <th>Images</th>
                <th>Lyrics</th>
                <th>Hashes</th>
                <th>Created At</th>
                <th>Updated At</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($songs as $item)
                <tr>
                    <td>{{$item->song_id}}</td>
                    <td>{{$item->title}}</td>
                    <td>{{$item->Artist->name}}</td>
                    <td>{{$item->Genre->name}}</td>
                    <td>{{$item->total_favorite}}</td>
                    <td>{{$item->total_hash}}</td>
                    <td>
                        <span class="badge badge-pill @if($item->file == null) badge-danger @else badge-success @endif" style="font-size: 100%;">
                            @if ($item->file == null) <i class="fe fe-x-circle fe-16"></i> @else <i class="fe fe-check-circle fe-16"></i> @endif
                        </span>
                    </td>
                    <td>
                        <span class="badge badge-pill @if($item->img == null) badge-danger @else badge-success @endif" style="font-size: 100%;">
                            @if ($item->img == null) <i class="fe fe-x-circle fe-16"></i> @else <i class="fe fe-check-circle fe-16"></i> @endif
                        </span>
                    </td>
                    <td>
                        <span class="badge badge-pill @if($item->lyrics == null) badge-danger @else badge-success @endif" style="font-size: 100%;">
                            @if ($item->lyrics == null) <i class="fe fe-x-circle fe-16"></i> @else {{$item->source_lyrics}} @endif
                        </span>
                    </td>
                    <td>
                        <span class="badge badge-pill @if($item->has_hash == null) badge-danger @else badge-success @endif" style="font-size: 100%;">
                            @if ($item->has_hash == null) <i class="fe fe-x-circle fe-16"></i> @else <i class="fe fe-check-circle fe-16"></i> @endif
                        </span>
                    </td>
                    <td>{{$item->created_at}}</td>
                    <td>{{$item->updated_at}}</td>
                    <td>
                        <span class="badge badge-pill @if($item->deleted_at == null) badge-success @else badge-danger @endif" style="font-size: 100%;">
                            @if ($item->deleted_at == null) <i class="fe fe-check-circle fe-16"></i> @else <i class="fe fe-x-circle fe-16"></i> @endif
                        </span>
                    </td>
                    <td><a href="{{url('/song/update/'.$item->song_id)}}"><button class="btn btn-primary">Edit</button></a></td>
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
