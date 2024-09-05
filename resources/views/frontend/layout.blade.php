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
   <style>
    .menu {
    list-style-type: none;
    margin: 0;
    padding: 0;
}

.menu li {
    display: inline-block;
    position: relative;
}

.profile-img {
    object-fit: cover;
    border-radius: 50%;
    cursor: pointer;
}

.dropdown-menu {
    display: none;
    position: absolute;
    top: 60px; /* Adjust based on image height */
    left: 0;
    background-color: white;
    border: 1px solid #ccc;
    padding: 15px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    border-radius: 5px;
    z-index: 1000;
    width: 250px;
}

.dropdown-menu li {
    margin: 5px 0;
}

.dropdown-menu a {
    text-decoration: none;
    color: #333;
    font-size: 14px;
}

.dropdown-menu a:hover {
    color: #007bff;
}
result that you can see in the preview selection

body{
    margin-top:20px;
    color: #1a202c;
    text-align: left;
    background-color: #e2e8f0;    
}
.main-body {
    padding: 15px;
}
.card {
    box-shadow: 0 1px 3px 0 rgba(0,0,0,.1), 0 1px 2px 0 rgba(0,0,0,.06);
}

.card {
    position: relative;
    display: flex;
    flex-direction: column;
    min-width: 0;
    word-wrap: break-word;
    background-color: #fff;
    background-clip: border-box;
    border: 0 solid rgba(0,0,0,.125);
    border-radius: .25rem;
}

.card-body {
    flex: 1 1 auto;
    min-height: 1px;
    padding: 1rem;
}

.gutters-sm {
    margin-right: -8px;
    margin-left: -8px;
}

.gutters-sm>.col, .gutters-sm>[class*=col-] {
    padding-right: 8px;
    padding-left: 8px;
}
.mb-3, .my-3 {
    margin-bottom: 1rem!important;
}

.bg-gray-300 {
    background-color: #e2e8f0;
}
.h-100 {
    height: 100%!important;
}
.shadow-none {
    box-shadow: none!important;
}

   </style>
    </head>
    <body>
        <header>
            <div class="container">
                <div class="logo">
                    <a href="/">
                        
                        <!-- <h1>
                           AUDIO BOOK
                        </h1> -->
                        <img src="../uploads/{{$logo[0]->thumbnail}}" width="80px" style="border-radius: 40%;" > 
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
    <li class="profile-menu" id="profileMenu">
        @if (Auth::check())
            <img src="/uploads/{{ Auth::user()->image }}" alt="" width="50" height="50" class="profile-img" id="profileImg">
            <ul class="dropdown-menu" id="dropdownMenu">
                <li><a href="/my-profile"><i class="fa-solid fa-user"></i></a></li>
                <li><a href="/my-order"><i class="fa-solid fa-money-check-dollar"></i></a></li>
                <li><a href="/cart-item"><i class="fa-solid fa-cart-shopping"></i></a></li>
                <li><a href="/my-subscribe"><i class="fa-solid fa-music"></i></a></li>
                <li><a href="/logout/{{ Auth::user()->id }}"><i class="fa-solid fa-right-from-bracket"></i></a></li>
            </ul>
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
    <script>
        document.addEventListener("DOMContentLoaded", function() {
    const profileImg = document.getElementById('profileImg');
    const dropdownMenu = document.getElementById('dropdownMenu');
    const profileMenu = document.getElementById('profileMenu');

    let timeoutId;

    profileImg.addEventListener('mouseover', function() {
        dropdownMenu.style.display = 'block';
    });

    profileMenu.addEventListener('mouseleave', function() {
        timeoutId = setTimeout(function() {
            dropdownMenu.style.display = 'none';
        }, 500); 
    });

    dropdownMenu.addEventListener('mouseover', function() {
        clearTimeout(timeoutId);
        dropdownMenu.style.display = 'block';
    });

    dropdownMenu.addEventListener('mouseleave', function() {
        timeoutId = setTimeout(function() {
            dropdownMenu.style.display = 'none';
        }, 500); 
    });
});

    </script>
</html>
