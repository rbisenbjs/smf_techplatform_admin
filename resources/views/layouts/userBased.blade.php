<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="description" content="">
        <meta name="author" content="">
        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>{{ config('app.name', 'SMF Platform') }}</title>
        <!-- Custom fonts for this template-->
        <link href="{{asset('vendor/fontawesome-free/css/all.min.css')}}" rel="stylesheet" type="text/css">
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.8.0/css/bootstrap-datepicker.css">
        <!-- Custom styles for this template-->
        <link href="{{asset('css/sb-admin-2.css')}}" rel="stylesheet">
        <!-- Custom styles for this page -->
         <!-- <link href="{{asset('vendor/datatables/dataTables.bootstrap4.min.css')}}" rel="stylesheet"> -->
        @stack('css')
    </head>
    <body id="page-top">
        <!-- Page Wrapper -->
        <div id="wrapper">

            <!-- Sidebar -->
            <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">
                <!-- Sidebar - Brand -->
                <a class="sidebar-brand d-flex align-items-center justify-content-center" href="/home">
                    <div class="sidebar-brand-icon">
                        <img id="bjs_logo" src="{{ asset('image/bjs_logo.png') }}">
                    </div>
                    <div class="sidebar-brand-text mx-3">
                        {{ config('app.name', 'SMF Platform') }}
                    </div>
                </a>
                <!-- Divider -->
                <hr class="sidebar-divider my-0">
                <!-- Heading -->
                <!-- Nav Item - Pages Collapse Menu -->
                @if(Session::get('adminAccessRole') == 1 && Session::get('adminAccessProject') == 1) 
					<li class="nav-item {{ (request()->segment(2) == 'forms' || request()->segment(2) == 'editForm' || request()->segment(2) == 'setKeys') ? 'active' : '' }}">
						<a class="nav-link" href="/{{$orgId}}/forms">
							<span>Forms</span>
						</a>
					</li>
					<li class="nav-item {{ ((request()->segment(2) == 'microservices') || (request()->segment(1) == 'microservice')) ? 'active' : '' }}">
						<a class="nav-link" href="/{{$orgId}}/microservices">
							<span>Microservices</span>
						</a>
					</li>
					<li class="nav-item {{ ((request()->segment(2) == 'entities') || (request()->segment(2) == 'entity') || (request()->segment(1) == 'entity') ) ? 'active' : '' }}">
						<a class="nav-link" href="/{{$orgId}}/entities">
							<span>Entities</span>
						</a>
					</li>
					<li class="nav-item {{ (request()->segment(2) == 'categories' || request()->segment(2) == 'category' || request()->segment(1) == 'category' ) ? 'active' : '' }}">
						<a class="nav-link" href="/{{$orgId}}/categories">
							<span>Categories</span>
						</a>
					</li>
					<li class="nav-item {{ (request()->segment(2) == 'event-types' || request()->segment(2) == 'event-type' || request()->segment(1) == 'event-type' ) ? 'active' : '' }}">
						<a class="nav-link" href="/{{$orgId}}/event-types">
							<span>Event Types</span>
						</a>
					</li>                
					<!-- Divider -->
					<hr class="sidebar-divider">
					<li class="nav-item {{ (request()->segment(2) == 'jurisdictions' || request()->segment(2) == 'jurisdiction' || request()->segment(1) == 'jurisdictions') ? 'active' : '' }}">
						<a class="nav-link" href="/{{$orgId}}/jurisdictions">
							<span>Jurisdictions</span>
						</a>
					</li>
					<li class="nav-item {{ (request()->segment(2) == 'jurisdiction-types') ? 'active' : '' }}">
						<a class="nav-link" href="/{{$orgId}}/jurisdiction-types">
							<span>Jurisdiction Types</span>
						</a>
					</li>
					<li class="nav-item {{ (request()->segment(2) == 'locations') ? 'active' : '' }}">
						<a class="nav-link" href="/{{$orgId}}/locations">
							<span>Locations</span>
						</a>
					</li>
				@endif
                <!-- Divider -->
                <hr class="sidebar-divider">
                <li class="nav-item {{ (request()->segment(2) == 'projects' || request()->segment(2) == 'project' || request()->segment(1) == 'project') ? 'active' : '' }}">
                    <a class="nav-link" href="/{{$orgId}}/projects">
                        <span>Projects</span>
                    </a>
                </li>
				
				@if(Session::get('adminAccessRole') == 1) 
                <li class="nav-item {{ ((request()->segment(2) == 'roles')) ? 'active' : '' }}">
                    <a class="nav-link" href="/{{$orgId}}/roles">
                        <span>Roles Configuration</span>
                    </a>
                </li>				
                <li class="nav-item {{ ((request()->segment(2) == 'associates')) ? 'active' : '' }}">
                    <a class="nav-link" href="/{{$orgId}}/associates">
                        <span>Associates</span>
                    </a>
                </li>
                <li class="nav-item {{ ((request()->segment(2) == 'modules')) ? 'active' : '' }}">
                    <a class="nav-link" href="/{{$orgId}}/modules">
                        <span>Modules</span>
                    </a>
                </li>				
                <!-- Divider -->
                <hr class="sidebar-divider">
                <li class="nav-item {{ ((request()->segment(2) == 'reports')) ? 'active' : '' }}">
                    <a class="nav-link" href="/{{$orgId}}/reports">
                        <span>Reports</span>
                    </a>
                </li>
				@endif
                <!-- Divider -->
                <hr class="sidebar-divider">
                <!-- Sidebar Toggler (Sidebar) -->
                <div class="text-center d-none d-md-inline">
                    <button class="rounded-circle border-0" id="sidebarToggle"></button>
                </div>
            </ul>
            <!-- End of Sidebar -->

            <!-- Content Wrapper -->
            <div id="content-wrapper" class="d-flex flex-column">

                <!-- Main Content -->
                <div id="content">
                    <!-- Topbar -->
                    <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">
                        <!-- Sidebar Toggle (Topbar) -->
                        <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                            <i class="fa fa-bars"></i>
                        </button>
                        <!-- Topbar Navbar -->
                        <ul class="navbar-nav ml-auto">
                            @guest
                                <!-- Nav Item - User Information -->
                                <li class="nav-item dropdown no-arrow">
                                    <a class="nav-link dropdown-toggle" href="{{ route('login') }}" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <span class="mr-2 d-none d-lg-inline text-gray-600 small">{{ __('Login') }}</span>
                                    </a>
                                </li>
                                <li class="nav-item dropdown no-arrow">
                                    @if (Route::has('register'))
                                        <a class="nav-link dropdown-toggle" href="{{ route('register') }}" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <span class="mr-2 d-none d-lg-inline text-gray-600 small">{{ __('Register') }}</span>
                                        </a>
                                    @endif
                                </li>
                            @else
                                <li class="nav-item dropdown no-arrow">
                                    <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <span class="mr-2 d-none d-lg-inline text-gray-600 small">{{ Auth::user()->name }}</span>
                                    </a>
                                    <!-- Dropdown - User Information -->
                                    <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                                        <a class="dropdown-item" href="{{ route('logout') }}" data-toggle="modal" data-target="#logoutModal" onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                                        <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                            Logout
                                        </a>
                                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                            @csrf
                                        </form>
                                    </div>
                                </li>
                            @endguest
                        </ul>
                    </nav>
                    <!-- End of Topbar -->
                    @yield('content')

                </div>
                <!-- End of Main Content -->
                <!-- Footer -->
                <footer class="sticky-footer bg-white">
                    <div class="container my-auto">
                        <div class="copyright text-center my-auto">
                            <span>Copyright &copy; SMF 2019</span>
                        </div>
                    </div>
                </footer>
                <!-- End of Footer -->

            </div>
            <!-- End of Content Wrapper -->
        </div>
        <!-- End of Page Wrapper -->

        <!-- Bootstrap core JavaScript-->
        <!-- <script src="{{asset('vendor/jquery/jquery.min.js')}}"></script>
        <script src="{{asset('vendor/bootstrap/js/bootstrap.bundle.min.js')}}"></script> -->
        <!-- Core plugin JavaScript-->
        <!-- <script src="{{asset('vendor/jquery-easing/jquery.easing.min.js')}}"></script> -->
        <!-- Scripts -->
        
       <!--  <script src="{{ asset('argon') }}/vendor/jquery/dist/jquery.min.js"></script> -->
	    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	  <script src="https://cdnjs.cloudflare.com/ajax/libs/knockout/3.4.0/knockout-min.js"></script>
        <!-- modal pop up script begins-->
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" ></script>
        <!-- modal pop up script ends-->
        <script src="https://surveyjs.azureedge.net/1.0.56/survey.ko.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/ace/1.2.0/ace.min.js" type="text/javascript" charset="utf-8"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/ace/1.2.0/ext-language_tools.js" type="text/javascript" charset="utf-8"></script>
        <link href="https://surveyjs.azureedge.net/1.0.56/surveyeditor.css" type="text/css" rel="stylesheet"/>
        <script src="https://surveyjs.azureedge.net/1.0.56/surveyeditor.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.8.0/js/bootstrap-datepicker.min.js"></script>
        <!-- Custom scripts for all pages-->
         <script src="{{asset('js/sb-admin-2.min.js')}}"></script>
        <!-- Page level plugins -->
       <!-- <script src="{{asset('vendor/datatables/jquery.dataTables.min.js')}}"></script>
        <script src="{{asset('vendor/datatables/dataTables.bootstrap4.min.js')}}"></script>
		
        <script src="{{ asset('argon') }}/vendor/bootstrap/dist/js/bootstrap.bundle.min.js"></script> -->
        
		 <!-- Page level custom scripts -->
    
      <!--   <script src="{{asset('js/demo/datatables-demo.js')}}"></script>-->
        <script src="{{ asset('js/index.js') }}"></script> 
        @stack('scripts')
    </body>
</html>
