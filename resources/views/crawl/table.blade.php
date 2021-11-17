@if (count($crawls) == 0)

    <center><h2>- NO RECORD -</h2></center>

@else
    <table class="table datatables" id="list_table">

        <thead>
            <tr>
                <td>Crawl ID</td>
                <td>Name</td>
                <td>URL</td>
                <td>Tag Stop</td>
                <td>Tag Title</td>
                <td>Tag Lyrics</td>
                <td>Max Depth</td>
                <td>Action</td>
            </tr>
        </thead>
        <tbody>
            @foreach ($crawls as $item)
                <tr>
                    <td>{{$item->crawl_id}}</td>
                    <td>{{$item->name}}</td>
                    <td>{{$item->url}}</td>
                    <td>{{$item->tag_stop}}</td>
                    <td>{{$item->tag_title}}</td>
                    <td>{{$item->tag_lyrics}}</td>
                    <td>{{$item->max_depth}}</td>
                    <td>
                        <a href="{{url('/crawl/update/' . $item->crawl_id)}}">
                            <button type="button" class="btn btn-primary">Edit</button>
                        </a>
                    </td>
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
