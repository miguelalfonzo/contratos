<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{!! csrf_token() !!}">
	<link rel="icon" href="{{asset('img/ico-trans.ico')}}" type="image/ico" />

    <title>{{ config('app.name') }}</title>

    <!-- Bootstrap -->
    <link href="{{asset('vendors/bootstrap/dist/css/bootstrap.min.css')}}" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="{{asset('vendors/font-awesome/css/font-awesome.min.css')}}" rel="stylesheet">
    <!-- NProgress -->
    <link href="{{asset('vendors/nprogress/nprogress.css')}}" rel="stylesheet">
    <!-- iCheck -->

    <link href="{{asset('vendors/icheck2/all.css')}}" rel="stylesheet">

    {{-- <link href="{{asset('vendors/iCheck/skins/flat/green.css')}}" rel="stylesheet"> --}}
	
    <!-- bootstrap-progressbar -->
    <link href="{{asset('vendors/bootstrap-progressbar/css/bootstrap-progressbar-3.3.4.min.css')}}" rel="stylesheet">
    <!-- JQVMap -->
    <link href="{{asset('vendors/jqvmap/dist/jqvmap.min.css')}}" rel="stylesheet"/>
    

    
    <!-- Scroll -->
    <link href="{{asset('css/scroll.css')}}" rel="stylesheet">
    
    <!-- alertify -->
    <link href="{{asset('vendors/alertify/css/alertify.css')}}" rel="stylesheet">

    <!-- chosen -->
    <link href="{{asset('vendors/chosen/chosen-bootstrap.css')}}" rel="stylesheet">
    <link href="{{asset('vendors/chosen/chosen.css')}}" rel="stylesheet">
    
    <!-- DROPZONE -->
    <link href="{{asset('vendors/dropzone/dist/min/dropzone.min.css')}}" rel="stylesheet">

    @yield('css')

    <!-- Custom Theme Style -->
    <link href="{{asset('build/css/custom.min.css')}}" rel="stylesheet">
    
    

     <!-- timeline -->
    <link href="{{asset('css/timeline.css')}}" rel="stylesheet" type="text/css">

    <!-- principal -->
    <link href="{{asset('css/principal.css')}}" rel="stylesheet">
    
  </head>

  <body class="nav-md">
    
    
    @inject('permisos', 'App\Rol')
  
    <?php
      
      $string_opciones = $permisos->get_permisos_opciones();
      
      $array_opciones = explode(",",$string_opciones);


    ?>
    

  
  

    <div class="container body">
      <div class="main_container">
        <div class="col-md-3 left_col">
          <div class="left_col scroll-view">
            <div class="navbar nav_title" style="border: 0;">
              

              <a href="{{url('/home')}}" class="site_title"><img height="40" width="40" src="{{asset('img/test.png')}}" alt="..." class=""> <span>{{ config('app.name') }}</span></a>
              
            </div>

            <div class="clearfix"></div>

            <!-- menu profile quick info -->
            <div class="profile clearfix">
              <div class="profile_pic">
                
                
                <img src="{{asset((Auth::user()->imagen!=null)?'profiles/'.Auth::user()->imagen:'img/noimage.png')}}" alt="..." class="img-circle profile_img" height="50">
              </div>
              <div class="profile_info">
                <span>Bienvenido</span>
                <h2>{{ Auth::user()->nombres }} {{ Auth::user()->apellido_paterno }}</h2>
              </div>
            </div>
            <!-- /menu profile quick info -->

            <br />

            <!-- sidebar menu -->
            <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
              <div class="menu_section">
                {{-- <h3>General</h3> --}}
                <ul class="nav side-menu">
                  <li><a><i class="fa fa-cog"></i> Maestro <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                      
                      @if(in_array(3, $array_opciones))
                      <li><a href="{{url('/maestro')}}">Tabla Maestra</a></li>
                      @endif

                      @if(in_array(4, $array_opciones))
                      <li><a href="{{url('/clientes')}}">Clientes</a></li>
                      @endif

                      @if(in_array(8, $array_opciones))
                      <li><a href="{{url('/ubigeo')}}">Ubigeo</a></li>
                      @endif


                      @if(in_array(14, $array_opciones))
                      <li><a href="{{url('/parametros')}}">Parámetros</a></li>
                      @endif
                    </ul>
                  </li>

                  <li><a><i class="fa fa-pencil"></i> Obras <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                      
                      @if(in_array(10, $array_opciones))
                      <li><a href="{{url('/obras')}}">Obras</a></li>
                      @endif
                      
                    </ul>
                  </li>
                  

                  <li><a><i class="fa fa-sort-amount-asc"></i> Gestión <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                      
                      @if(in_array(12, $array_opciones))
                     <li><a href="{{url('/gestion_carta_fianza')}}">Cartas Fianza</a></li>
                      @endif
                    </ul>
                  </li>
                  
 
                </ul>
              </div>
              <div class="menu_section">
                {{-- <h3>Configuracion</h3> --}}
                <ul class="nav side-menu">
                  <li><a><i class="fa fa-unlock"></i> Seguridad <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                      
                      @if(in_array(7, $array_opciones))
                      <li><a href="{{url('/roles')}}">Roles</a></li>
                      @endif

                      @if(in_array(6, $array_opciones))
                      <li><a href="{{url('/usuario')}}">Usuario</a></li>
                      @endif

                      @if(in_array(13, $array_opciones))
                      <li><a href="{{ url('/empresa')}}">Empresa</a></li>
                      @endif

                    </ul>
                  </li>
                  
                  
                </ul>
              </div>

            </div>
            <!-- /sidebar menu -->

            <!-- /menu footer buttons -->
            <div class="sidebar-footer hidden-small">
              <a data-toggle="tooltip" data-placement="top" title="Settings">
                <span class="glyphicon glyphicon-cog" aria-hidden="true"></span>
              </a>
              <a data-toggle="tooltip" data-placement="top" title="FullScreen">
                <span class="glyphicon glyphicon-fullscreen" aria-hidden="true"></span>
              </a>
              <a data-toggle="tooltip" data-placement="top" title="Lock">
                <span class="glyphicon glyphicon-eye-close" aria-hidden="true"></span>
              </a>
              

              <a  data-toggle="tooltip" data-placement="top" title="Logout" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                <span class="glyphicon glyphicon-off" aria-hidden="true"></span>
                    </a>
            </div>
            <!-- /menu footer buttons -->
          </div>
        </div>

        <!-- top navigation -->
        <div class="top_nav">
          <div class="nav_menu">
              <div class="nav toggle">
                <a id="menu_toggle"><i class="fa fa-bars"></i></a>
              </div>
              <nav class="nav navbar-nav">
              <ul class=" navbar-right">
                <li class="nav-item dropdown open" style="padding-left: 15px;">
                  <a href="javascript:;" class="user-profile dropdown-toggle" aria-haspopup="true" id="navbarDropdown" data-toggle="dropdown" aria-expanded="false">
                    <img src="{{asset((Auth::user()->imagen!=null)?'profiles/'.Auth::user()->imagen:'img/noimage.png')}}" alt="">{{ Auth::user()->nombres }} {{ Auth::user()->apellido_paterno }}
                  </a>
                  <div class="dropdown-menu dropdown-usermenu pull-right" aria-labelledby="navbarDropdown">
                    

                      <a class="dropdown-item" href="{{ url('/perfil',array('id'=>Auth::user()->id)) }}">
                        <span class="badge bg-red pull-right"><i class="fa fa-user"></i></span>
                        <span>Mi perfil</span>
                      </a>
                  
                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();"><i class="fa fa-sign-out pull-right"></i>
                                        {{ __('Logout') }}
                    </a>

                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                    </form>

                  </div>
                </li>

             
              </ul>
            </nav>
          </div>
        </div>
        <!-- /top navigation -->

        @yield('content')
        
        <!-- footer content -->
        <footer>
          <div class="pull-right">
            Cayro Soluciones - 2020
          </div>
          <div class="clearfix"></div>
        </footer>
        <!-- /footer content -->
      </div>
    </div>

     
    <!-- jQuery -->
    <script src="{{asset('vendors/jquery/dist/jquery.min.js')}}"></script>
    <!-- Bootstrap -->
    <script src="{{asset('vendors/bootstrap/dist/js/bootstrap.bundle.min.js')}}"></script>
    <!-- UIBLOCK -->
    <script src="{{asset('vendors/uiblock/jquery.blockUI.js')}}"></script>
    <!-- jsprincipal -->
    <script src="{{asset('js/jsApp/principal.js')}}"></script>
    <!-- FastClick -->
    <script src="{{asset('vendors/fastclick/lib/fastclick.js')}}"></script>
    <!-- NProgress -->
    <script src="{{asset('vendors/nprogress/nprogress.js')}}"></script>
    <!-- Chart.js -->
    <script src="{{asset('vendors/Chart.js/dist/Chart.min.js')}}"></script>
    <!-- gauge.js -->
    <script src="{{asset('vendors/gauge.js/dist/gauge.min.js')}}"></script>
    <!-- bootstrap-progressbar -->
    <script src="{{asset('vendors/bootstrap-progressbar/bootstrap-progressbar.min.js')}}"></script>
    <!-- iCheck -->
    {{-- <script src="{{asset('vendors/iCheck/icheck.min.js')}}"></script> --}}
    <!-- Skycons -->
    <script src="{{asset('vendors/skycons/skycons.js')}}"></script>
    
    
    <!-- iCheck -->
    <script src="{{asset('vendors/icheck2/icheck.min.js')}}"></script>

    <!-- JQVMap -->
    <script src="{{asset('vendors/jqvmap/dist/jquery.vmap.js')}}"></script>
    <script src="{{asset('vendors/jqvmap/dist/maps/jquery.vmap.world.js')}}"></script>
    <script src="{{asset('vendors/jqvmap/examples/js/jquery.vmap.sampledata.js')}}"></script>
    
  
  <!-- DateJS -->
    <script src="{{asset('vendors/DateJS/build/date.js')}}"></script>
    

    <!-- Datatables -->
    <script src="{{asset('vendors/datatables.net/js/jquery.dataTables.min.js')}}"></script>
    <script src="{{asset('vendors/datatables.net-bs/js/dataTables.bootstrap.min.js')}}"></script>
    <script src="{{asset('vendors/datatables.net-buttons/js/dataTables.buttons.min.js')}}"></script>
    <script src="{{asset('vendors/datatables.net-buttons-bs/js/buttons.bootstrap.min.js')}}"></script>
    <script src="{{asset('vendors/datatables.net-buttons/js/buttons.flash.min.js')}}"></script>
    <script src="{{asset('vendors/datatables.net-buttons/js/buttons.html5.min.js')}}"></script>
    <script src="{{asset('vendors/datatables.net-buttons/js/buttons.print.min.js')}}"></script>
    <script src="{{asset('vendors/datatables.net-fixedheader/js/dataTables.fixedHeader.min.js')}}"></script>
    <script src="{{asset('vendors/datatables.net-keytable/js/dataTables.keyTable.min.js')}}"></script>
    <script src="{{asset('vendors/datatables.net-responsive/js/dataTables.responsive.min.js')}}"></script>
    <script src="{{asset('vendors/datatables.net-responsive-bs/js/responsive.bootstrap.js')}}"></script>
    <script src="{{asset('vendors/datatables.net-scroller/js/dataTables.scroller.min.js')}}"></script>

    <!-- datatable -moment -->
    <script src="{{asset('vendors/datetime/moment.min.js')}}"></script>
    <script src="{{asset('vendors/datetime/datetime.js')}}"></script>


   <script src="{{asset('vendors/alertify/alertify.js')}}" ></script>
  
  <!-- jQuery input mask -->
    <script src="{{asset('vendors/jquery.inputmask/dist/min/jquery.inputmask.bundle.min.js')}}"></script>

  <!-- chosen -->

  <script src="{{asset('vendors/chosen/chosen.jquery.js')}}"></script>
  
  <!-- Dropzone.js -->
  <script src="{{asset('vendors/dropzone/dist/min/dropzone.min.js')}}"></script>

  

    @yield('js')

    <!-- Custom Theme Scripts -->
    <script src="{{asset('build/js/custom.min.js')}}"></script>
	  
  </body>
</html>
