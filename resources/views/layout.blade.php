<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>GD Music - Admin</title>

    {{-- START CSS --}}

    <!-- Simple bar CSS -->
    <link rel="stylesheet" href="{{asset('/tinydash/css/simplebar.css')}}">
    <!-- Fonts CSS -->
    <link href="https://fonts.googleapis.com/css2?family=Overpass:ital,wght@0,100;0,200;0,300;0,400;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <!-- Icons CSS -->
    <link rel="stylesheet" href="{{asset('/tinydash/css/feather.css')}}">
    <link rel="stylesheet" href="{{asset('/tinydash/css/select2.css')}}">
    <link rel="stylesheet" href="{{asset('/tinydash/css/dropzone.css')}}">
    <link rel="stylesheet" href="{{asset('/tinydash/css/uppy.min.css')}}">
    <link rel="stylesheet" href="{{asset('/tinydash/css/jquery.steps.css')}}">
    <link rel="stylesheet" href="{{asset('/tinydash/css/jquery.timepicker.css')}}">
    <link rel="stylesheet" href="{{asset('/tinydash/css/quill.snow.css')}}">
    <!-- Date Range Picker CSS -->
    <link rel="stylesheet" href="{{asset('/tinydash/css/daterangepicker.css')}}">
    <!-- App CSS -->
    <link rel="stylesheet" href="{{asset('/tinydash/css/app-light.css')}}" id="lightTheme" disabled>
    <link rel="stylesheet" href="{{asset('/tinydash/css/app-dark.css')}}" id="darkTheme">
    {{-- DATATABLE --}}
    <link rel="stylesheet" href="{{asset('/tinydash/css/dataTables.bootstrap4.css')}}">

    {{-- END CSS --}}

  </head>

  <body class="vertical light">
    <div class="wrapper">

      {{-- START NAVBAR --}}

      <nav class="topnav navbar navbar-light">
        <button type="button" class="navbar-toggler text-muted mt-2 p-0 mr-3 collapseSidebar">
          <i class="fe fe-menu navbar-toggler-icon"></i>
        </button>
        <ul class="nav">
          <li class="nav-item">
            <a class="nav-link text-muted my-2" href="#" id="modeSwitcher" data-mode="dark">
              <i class="fe fe-sun fe-16"></i>
            </a>
          </li>
          <li class="nav-item dropdown mt-1">
            <a class="nav-link dropdown-toggle text-muted pr-0" href="#" id="navbarDropdownMenuLink" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              <span style="font-size: 1.3em;">{{ getUser()->username }}</span>
            </a>
            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownMenuLink">
                {{-- <a class="dropdown-item" href="{{ url('pegawai/update/' . getUser()->username) }}">Profile</a> --}}
                <a class="dropdown-item" href="{{ url('logout') }}">Logout</a>
            </div>
          </li>
        </ul>
      </nav>

      {{-- END NAVBAR --}}

      {{-- START SIDEBAR --}}

      <aside class="sidebar-left border-right bg-white shadow" id="leftSidebar" data-simplebar>
        <a href="#" class="btn collapseSidebar toggle-btn d-lg-none text-muted ml-2 mt-3" data-toggle="toggle">
          <i class="fe fe-x"><span class="sr-only"></span></i>
        </a>
        <nav class="vertnav navbar navbar-light">
          <div class="w-100 mt-3 d-flex justify-content-center">
            <h1>GD Music</h1>
          </div>
          <ul class="navbar-nav flex-fill w-100 mb-2">

            {{-- INFORMASI UTAMA --}}
            <p class="text-muted nav-heading mt-4 mb-1">
                <span>Informasi Utama</span>
            </p>
            <li class="nav-item dropdown">
                <a href="{{url('dashboard')}}" class="nav-link">
                    <i class="fe fe-bell fe-16"></i>
                    <span class="ml-3 item-text">Dashboard</span>
                </a>
            </li>

            {{-- INFORMASI SONG --}}
            <p class="text-muted nav-heading mt-3 mb-1">
                <span>Informasi Song</span>
            </p>
            <li class="nav-item dropdown">
                <a href="#genre" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle nav-link">
                    <i class="fe fe-headphones fe-16"></i>
                    <span class="ml-3 item-text">Genre</span><span class="sr-only">(current)</span>
                </a>
                <ul class="collapse list-unstyled pl-4 w-100" id="genre">
                    <li class="nav-item active">
                        <a class="nav-link pl-3" href="{{url('genre')}}"><span class="ml-1 item-text">List Genre</span></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link pl-3" href="{{url('genre/insert')}}"><span class="ml-1 item-text">Tambah Genre</span></a>
                    </li>
                </ul>
            </li>
            <li class="nav-item dropdown">
                <a href="#artist" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle nav-link">
                    <i class="fe fe-user-check fe-16"></i>
                    <span class="ml-3 item-text">Artist</span><span class="sr-only">(current)</span>
                </a>
                <ul class="collapse list-unstyled pl-4 w-100" id="artist">
                    <li class="nav-item active">
                        <a class="nav-link pl-3" href="{{url('artist')}}"><span class="ml-1 item-text">List Artist</span></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link pl-3" href="{{url('artist/insert')}}"><span class="ml-1 item-text">Tambah Artist</span></a>
                    </li>
                </ul>
            </li>
            <li class="nav-item dropdown">
                <a href="#song" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle nav-link">
                    <i class="fe fe-music fe-16"></i>
                    <span class="ml-3 item-text">Song</span><span class="sr-only">(current)</span>
                </a>
                <ul class="collapse list-unstyled pl-4 w-100" id="song">
                    <li class="nav-item active">
                        <a class="nav-link pl-3" href="{{url('song')}}"><span class="ml-1 item-text">List Song</span></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link pl-3" href="{{url('song/insert')}}"><span class="ml-1 item-text">Tambah Song</span></a>
                    </li>
                </ul>
            </li>
            <li class="nav-item dropdown">
                <a href="#crawl" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle nav-link">
                    <i class="fe fe-edit fe-16"></i>
                    <span class="ml-3 item-text">Crawler</span><span class="sr-only">(current)</span>
                </a>
                <ul class="collapse list-unstyled pl-4 w-100" id="crawl">
                        <li class="nav-item active">
                            <a class="nav-link pl-3" href="{{url('crawl')}}"><span class="ml-1 item-text">List Crawler</span></a>
                        </li>
                    <li class="nav-item">
                        <a class="nav-link pl-3" href="{{url('crawl/insert')}}"><span class="ml-1 item-text">Tambah Crawler</span></a>
                    </li>
                </ul>
            </li>

            {{-- INFORMASI USER --}}
            <p class="text-muted nav-heading mt-3 mb-1">
                <span>Informasi Administrasi</span>
            </p>

            <li class="nav-item dropdown">
                <a href="#plan" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle nav-link">
                    <i class="fe fe-book-open fe-16"></i>
                    <span class="ml-3 item-text">Plan</span><span class="sr-only">(current)</span>
                </a>
                <ul class="collapse list-unstyled pl-4 w-100" id="plan">
                        <li class="nav-item active">
                            <a class="nav-link pl-3" href="{{url('plan')}}"><span class="ml-1 item-text">List Plan</span></a>
                        </li>
                    <li class="nav-item">
                        <a class="nav-link pl-3" href="{{url('plan/insert')}}"><span class="ml-1 item-text">Tambah Plan</span></a>
                    </li>
                </ul>
            </li>

            <li class="nav-item dropdown">
                <a href="#user" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle nav-link">
                    <i class="fe fe-users fe-16"></i>
                    <span class="ml-3 item-text">User</span><span class="sr-only">(current)</span>
                </a>
                <ul class="collapse list-unstyled pl-4 w-100" id="user">
                        <li class="nav-item active">
                            <a class="nav-link pl-3" href="{{url('user')}}"><span class="ml-1 item-text">List User</span></a>
                        </li>
                    <li class="nav-item">
                        <a class="nav-link pl-3" href="{{url('user/insert')}}"><span class="ml-1 item-text">Tambah User</span></a>
                    </li>
                </ul>
            </li>
            @if (getUser()->role == "SUPERADMIN")
                <li class="nav-item dropdown">
                    <a href="#admin" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle nav-link">
                        <i class="fe fe-user fe-16"></i>
                        <span class="ml-3 item-text">Admin</span><span class="sr-only">(current)</span>
                    </a>
                    <ul class="collapse list-unstyled pl-4 w-100" id="admin">
                            <li class="nav-item active">
                                <a class="nav-link pl-3" href="{{url('admin')}}"><span class="ml-1 item-text">List Admin</span></a>
                            </li>
                        <li class="nav-item">
                            <a class="nav-link pl-3" href="{{url('admin/insert')}}"><span class="ml-1 item-text">Tambah Admin</span></a>
                        </li>
                    </ul>
                </li>
            @endif
        </nav>
      </aside>

      {{-- END SIDEBAR --}}

      <main role="main" class="main-content">
        {{-- START BODY --}}
        <div class="container-fluid">
          <div class="row justify-content-center">
            <div class="col-12">
              @yield('body')
            </div> <!-- .col-12 -->
          </div> <!-- .row -->
        </div> <!-- .container-fluid -->
        {{-- END BODY --}}
      </main>
    </div>

    {{-- START CONFIRMATION MODAL --}}

    <button type="button" class="btn mb-2 btn-primary" data-toggle="modal" data-target="#confirmationModal" id="confirmation_modal_trigger" hidden> Launch confirmation modal </button>
    <div class="modal fade" id="confirmationModal" tabindex="-1" role="dialog" aria-labelledby="confirmationModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="confirmation_modal_label"></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="confirmation_modal_body"></div>
                <div class="modal-footer">
                    <button type="button" class="btn mb-2 btn-danger" data-dismiss="modal">Cancel</button>
                    <a id="confirmation_modal_url" href=""><button type="button" class="btn mb-2 btn-primary">Yes</button></a>
                </div>
            </div>
        </div>
    </div>

    {{-- END CONFIRMATION MODAL --}}

    {{-- START JS --}}

    <script src="{{asset('/tinydash/js/jquery.min.js')}}"></script>
    <script src="{{asset('/tinydash/js/popper.min.js')}}"></script>
    <script src="{{asset('/tinydash/js/moment.min.js')}}"></script>
    <script src="{{asset('/tinydash/js/bootstrap.min.js')}}"></script>
    <script src="{{asset('/tinydash/js/simplebar.min.js')}}"></script>
    <script src="{{asset('/tinydash/js/daterangepicker.js')}}"></script>
    <script src="{{asset('/tinydash/js/jquery.stickOnScroll.js')}}"></script>
    <script src="{{asset('/tinydash/js/tinycolor-min.js')}}"></script>
    <script src="{{asset('/tinydash/js/config.js')}}"></script>
    <script src="{{asset('/tinydash/js/jquery.mask.min.js')}}"></script>
    <script src="{{asset('/tinydash/js/select2.min.js')}}"></script>
    <script src="{{asset('/tinydash/js/jquery.steps.min.js')}}"></script>
    <script src="{{asset('/tinydash/js/jquery.validate.min.js')}}"></script>
    <script src="{{asset('/tinydash/js/jquery.timepicker.js')}}"></script>
    <script src="{{asset('/tinydash/js/dropzone.min.js')}}"></script>
    <script src="{{asset('/tinydash/js/uppy.min.js')}}"></script>
    <script src="{{asset('/tinydash/js/quill.min.js')}}"></script>
    <script src="{{asset('/tinydash/js/jquery.dataTables.min.js')}}"></script>
    <script src="{{asset('/tinydash/js/dataTables.bootstrap4.min.js')}}"></script>
    <script>
        $('.select2').select2(
        {
            theme: 'bootstrap4',
        });
        $('.select2-multi').select2(
        {
            multiple: true,
            theme: 'bootstrap4',
        });
        $('.drgpicker').daterangepicker(
        {
            singleDatePicker: true,
            timePicker: false,
            showDropdowns: true,
            locale:
            {
            format: 'MM/DD/YYYY'
            }
        });
        $('.time-input').timepicker(
        {
            'scrollDefault': 'now',
            'zindex': '9999' /* fix modal open */
        });
        /** date range picker */
        if ($('.datetimes').length)
        {
            $('.datetimes').daterangepicker(
            {
            timePicker: true,
            startDate: moment().startOf('hour'),
            endDate: moment().startOf('hour').add(32, 'hour'),
            locale:
            {
                format: 'M/DD hh:mm A'
            }
            });
        }
        var start = moment().subtract(29, 'days');
        var end = moment();

        function cb(start, end)
        {
            $('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
        }

        $('#reportrange').daterangepicker(
        {
            startDate: start,
            endDate: end,
            ranges:
            {
            'Today': [moment(), moment()],
            'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
            'Last 7 Days': [moment().subtract(6, 'days'), moment()],
            'Last 30 Days': [moment().subtract(29, 'days'), moment()],
            'This Month': [moment().startOf('month'), moment().endOf('month')],
            'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
            }
        }, cb);
        cb(start, end);
        $('.input-placeholder').mask("00/00/0000",
        {
            placeholder: "__/__/____"
        });
        $('.input-zip').mask('00000-000',
        {
            placeholder: "____-___"
        });
        $('.input-money').mask("#.##0",
        {
            reverse: true
        });
        $('.input-phoneus').mask('(000) 000-0000');
        $('.input-mixed').mask('AAA 000-S0S');
        $('.input-ip').mask('0ZZ.0ZZ.0ZZ.0ZZ',
        {
            translation:
            {
            'Z':
            {
                pattern: /[0-9]/,
                optional: true
            }
            },
            placeholder: "___.___.___.___"
        });
        // editor
        var editor = document.getElementById('editor');
        if (editor)
        {
            var toolbarOptions = [
            [
            {
                'font': []
            }],
            [
            {
                'header': [1, 2, 3, 4, 5, 6, false]
            }],
            ['bold', 'italic', 'underline', 'strike'],
            ['blockquote', 'code-block'],
            [
            {
                'header': 1
            },
            {
                'header': 2
            }],
            [
            {
                'list': 'ordered'
            },
            {
                'list': 'bullet'
            }],
            [
            {
                'script': 'sub'
            },
            {
                'script': 'super'
            }],
            [
            {
                'indent': '-1'
            },
            {
                'indent': '+1'
            }], // outdent/indent
            [
            {
                'direction': 'rtl'
            }], // text direction
            [
            {
                'color': []
            },
            {
                'background': []
            }], // dropdown with defaults from theme
            [
            {
                'align': []
            }],
            ['clean'] // remove formatting button
            ];
            var quill = new Quill(editor,
            {
            modules:
            {
                toolbar: toolbarOptions
            },
            theme: 'snow'
            });
        }
        // FORMAT RUPIAH
        // function formatRupiah(angka){
        //   var number_string = angka.replace(/[^.\d]/g, '').toString(),
        //   split   		= number_string.split('.'),
        //   sisa     		= split[0].length % 3,
        //   rupiah     	= split[0].substr(0, sisa),
        //   ribuan     	= split[0].substr(sisa).match(/\d{3}/gi);

        //   // tambahkan koma jika yang di input sudah menjadi angka ribuan
        //   if(ribuan){
        //       separator = sisa ? '.' : '';
        //       rupiah += separator + ribuan.join('.');
        //   }

        //   // rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
        //   return rupiah;
        // }
        // END OF FORMAT RUPIAH

        function confirmationModal(title,body,url){
            $("#confirmation_modal_label").html(title);
            $("#confirmation_modal_body").html(body);
            $("#confirmation_modal_url").attr("href",url);
            $("#confirmation_modal_trigger").click();
        }
    </script>

    <script src="{{asset('tinydash/js/apps.js')}}"></script>

    @stack('script')

    {{-- END JS --}}
  </body>
</html>
