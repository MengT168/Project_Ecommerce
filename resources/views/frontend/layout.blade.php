<!DOCTYPE html>
<html lang="en">
    <head>
        <title>@yield('title')</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="{{ url('css/frontend/theme.css') }}" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
        <link href="{{ url('https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css') }}" rel="stylesheet">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <!-- SweetAlert JS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    </head>
    <body>
        <header>
            <div class="container">
                <div class="logo">
                    <a href="/">
                        
                        <h1>
                           AUDIO BOOK
                        </h1>
                    </a>
                </div>
                <ul class="menu">
                    <li>
                        <a href="/">HOME</a>
                    </li>
                    <li>
                        <a href="shop">SHOP</a>
                    </li>
                    <!-- <li>
                        <a href="news">NEWS</a>
                    </li> -->
                </ul>
                <div class="search">
                    <form action="/search" method="get">
                        <input type="text" name="s" class="box" placeholder="SEARCH HERE">
                        <button>
                            <div style="background-image: url(uploads/search.png);
                                        width: 28px;
                                        height: 28px;
                                        background-position: center;
                                        background-size: contain;
                                        background-repeat: no-repeat;
                            "></div>
                        </button>
                    </form>
                </div>
                <ul class="menu">
                    <li>
                    @if (Auth::check())
                    <a href="/my-order"><i class="fa-solid fa-cart-shopping"></i></a>
                    @endif
                    </li>
                    <li>
                    @if (Auth::check())
                    <a style="font-size: 16px;" href="/logout/{{Auth::user()->id}}">LOG-OUT</a>
                    @else
                    <a style="font-size: 16px;" href="/signin">LOG-IN</a>
                    @endif
                    </li>
                </ul>
               
            </div>
        </header>
        @yield('content')
        <footer>
            <span>
                AllRight Recieved @ {{ date('Y') }}
            </span>
        </footer>

    </body>
    <script src="{{ url('https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js') }}"></script>
</html>
