<?php $uri_segement = Request::segment(2);  ?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title></title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <nav class="navbar navbar-expand-lg bg-light">
        <div class="container">
          <a class="navbar-brand" href="{{ URL('/') }}">Home</a>
          <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
          <div class="collapse navbar-collapse" id="navbarNavDropdown">
            <ul class="navbar-nav ms-auto">
                @guest
                    <li class="nav-item">
                    <?php if(session()->get('username') !=""){ ?>
                        <a class="nav-link" href="{{ route('logout') }}"
                                onclick="event.preventDefault();
                                document.getElementById('logout-form').submit();"
                                >Logout <?php if(session()->get('role_id') == 1) { echo "User"; } elseif(session()->get('role_id') == 3) {
                                echo "Admin"; }elseif(session()->get('role_id') == 2) { echo "Provider"; }elseif(session()->get('role_id') == 4) { echo "Franchise"; } ?></a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST">
                                    @csrf
                                </form>
                     <?php } else { ?> 
                        <a class="nav-link {{ (request()->is('login')) ? 'active' : '' }}" href="{{ route('provider.loginHome') }}"><?php if($uri_segement == 'homeRegister') { echo 'Login'; }?></a>
                     <?php } ?>
                    </li>
                    <?php if(session()->get('username') ==""){ ?>
                    <li class="nav-item">
                        <a class="nav-link {{ (request()->is('register')) ? 'active' : '' }}" href="{{ route('franchise.home.register') }}"> <?php if($uri_segement == 'login' || $uri_segement =='') { echo 'Register'; } ?></a>
                    </li>
                    <?php } ?>
                @else  
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            {{ Auth::user()->name }}
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="{{ route('logout') }}"
                                onclick="event.preventDefault();
                                document.getElementById('logout-form').submit();"
                                >Logout</a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST">
                                    @csrf
                                </form>
                            </li>
                        </ul>
                    </li>
                @endguest
            </ul>
          </div>
        </div>
    </nav>    

    <div class="container">
        @yield('content')
        <div class="row justify-content-center text-center mt-3">
            <div class="col-md-12">
                <p>
                   <a href="#"><strong></strong></a>
                </p>
            </div>
        </div>
    </div>
   
</body>
</html>