@extends('layout')

@section('body')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.6.0/chart.min.js" integrity="sha512-GMGzUEevhWh8Tc/njS0bDpwgxdCJLQBWG3Z2Ct+JGOpVnEmjvNx6ts4v6A2XJf1HOrtOsfhv3hBKpK9kE5z8AQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <div class="row">
        <div class="col-md-6 col-xl-12 mb-4">
            <div class="card shadow border-0">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col">
                            <h5>Total User of All Time</h5>
                            <div class="row align-items-center no-gutters">
                                <div class="col-auto">
                                    <span class="h1 mr-2 mb-0">{{$total_user}}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-12">
            <div class="card shadow">
                <h5 class="mt-4 ml-3">Top 10 Favorite Songs of All Time</h5>
                <div class="card-body">
                    <div id="table_container-song">
                        <table class="table">
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
                                @foreach ($favorite_songs as $item)
                                    <tr>
                                        <td>{{$item->song_id}}</td>
                                        <td>{{$item->title}}</td>
                                        <td>{{$item->Artist->name}}</td>
                                        <td>{{$item->Genre->name}}</td>
                                        <td>{{$item->total_favorite}}</td>
                                        <td>{{$item->total_hash}}</td>
                                        <td>
                                            <span class="badge badge-pill @if($item->file == null) badge-danger @else badge-success @endif" style="font-size: 100%;">
                                                @if ($item->file == null) NO-FILE @else HAS-FILE @endif
                                            </span>
                                        </td>
                                        <td>
                                            <span class="badge badge-pill @if($item->img == null) badge-danger @else badge-success @endif" style="font-size: 100%;">
                                                @if ($item->img == null) NO-IMAGE @else HAS-IMAGE @endif
                                            </span>
                                        </td>
                                        <td>
                                            <span class="badge badge-pill @if($item->lyrics == null) badge-danger @else badge-success @endif" style="font-size: 100%;">
                                                @if ($item->lyrics == null) NO-LYRIC @else {{$item->source_lyrics}} @endif
                                            </span>
                                        </td>
                                        <td>
                                            <span class="badge badge-pill @if($item->has_hash == null) badge-danger @else badge-success @endif" style="font-size: 100%;">
                                                @if ($item->has_hash == null) NO-HASH @else HAS-HASH @endif
                                            </span>
                                        </td>
                                        <td>{{$item->created_at}}</td>
                                        <td>{{$item->updated_at}}</td>
                                        <td>
                                            <span class="badge badge-pill @if($item->deleted_at == null) badge-success @else badge-danger @endif" style="font-size: 100%;">
                                                @if ($item->deleted_at == null) AVAILABLE @else DELETED @endif
                                            </span>
                                        </td>
                                        <td><a href="{{url('/song/update/'.$item->song_id)}}"><button class="btn btn-primary">Edit</button></a></td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <hr>

    <div class="row align-items-center mt-5 mb-5 my-2">
        <div class="col-md-12 align-items-center">
            <div class="form-group mb-3">
                <h4>PICK YEAR</h4>
            </div>
            <form class="form-inline" action="{{url('/dashboard')}}" method="get">
                <div class="form-group mr-3">
                    <input class="form-control" id="year" name="year" value="{{$year}}">
                </div>
                <button class="btn btn-primary ml-3" type="submit">PILIH</button>
            </form>
        </div>
    </div>

    <div class="form-group mb-3">
        <h4>ALL REPORT</h4>
    </div>

    <div class="row">

        <div class="col-md-6 col-xl-12 mb-4">
            <div class="card shadow border-0">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col">
                            <p class="small text-muted mb-0">Total User on Selected Year</p>
                            <div class="row align-items-center no-gutters">
                                <div class="col-auto">
                                    <span class="h3 mr-2 mb-0">{{$total_last_user}}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-xl-12 mb-4">
            <div class="card shadow border-0">
                <div class="card-body">


                    <div class="container">
                        <canvas id="myChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        {{-- <div class="col-md-6 mb-4 col-xl-4">
            <div class="card shadow border-0">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-4 text-center"><h4>+{{$total_last_user != 0 ? (($total_new_user - $total_last_user) / $total_last_user * 100) : 0}}%</h4></div>
                        <div class="col-8">
                            <p class="small text-muted mb-0">NEW USER</p>
                            <div class="row align-items-center no-gutters">
                                <div class="col-auto">
                                    <span class="h4 mr-2 mb-0">+{{$total_new_user - $total_last_user}}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6 mb-4 col-xl-4">
            <div class="card shadow border-0">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-4 text-center"><h4>{{$total_new_user != 0 ? floor($total_free_plan / $total_new_user * 100) : 0}}%</h4></div>
                        <div class="col-8">
                            <p class="small text-muted mb-0">FREE PLAN</p>
                            <div class="row align-items-center no-gutters">
                                <div class="col-auto">
                                    <span class="h4 mr-2 mb-0">{{$total_free_plan}}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6 mb-4 col-xl-4">
            <div class="card shadow border-0">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-4 text-center"><h4>{{$total_new_user != 0 ? 100 - floor($total_free_plan / $total_new_user * 100)  : 0}}%</h4></div>
                        <div class="col-8">
                            <p class="small text-muted mb-0">PAID PLAN</p>
                            <div class="row align-items-center no-gutters">
                                <div class="col-auto">
                                    <span class="h4 mr-2 mb-0">{{$total_paid_plan}}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div> --}}

    </div>
    <script>
        let myChart = document.getElementById('myChart').getContext('2d');
        <?php
            $free_plan_user = json_encode($free_plan_user);
            $paid_plan_user = json_encode($paid_plan_user);
            echo "var free_plan_user = ". $free_plan_user . ";\n";
            echo "var paid_plan_user = ". $paid_plan_user . ";\n";
        ?>

        let massPopChart = new Chart(myChart, {
          type:'bar',
          data:{
            labels:['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'],
            datasets:[{
              label:'FREE PLAN',
              data: free_plan_user,
              //backgroundColor:'green',
              backgroundColor:[
                'rgba(75, 192, 192, 0.6)',
              ],
              borderWidth:1,
              borderColor:'#777',
              hoverBorderWidth:3,
              hoverBorderColor:'#000'
            },
            {
              label:'PREMIUM PLAN',
              data: paid_plan_user,
              //backgroundColor:'green',
              backgroundColor:[
                'rgba(255, 206, 86, 0.6)',
              ],
              borderWidth:1,
              borderColor:'#777',
              hoverBorderWidth:3,
              hoverBorderColor:'#000'
            }]
          },
          options:{
            title:{
              display:true,
              text:'Total free plan vs premium plan',
              fontSize:25
            },
            legend:{
              display:true,
              position:'center',
              labels:{
                fontColor:'red'
              }
            },
            layout:{
              padding:{
                left:0,
                right:0,
                bottom:0,
                top:0
              }
            },
            tooltips:{
              enabled:true
            }
          }
        });
      </script>
@endsection
