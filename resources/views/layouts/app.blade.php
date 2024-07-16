<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Devdo') }}</title>
    <link href="{{ mix('css/app.css') }}" rel="stylesheet">
    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">

    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
    <script src="{{ mix('js/app.js') }}" defer></script>
    <link href="{{ asset('css/custom.css') }}" rel="stylesheet">
<style>
    /* General Styles */
    body {
        background-color: #0d0d27;
        color: #fff;
        font-family: 'Arial', sans-serif;
    }

    .container {
        max-width: 100%;
        margin: auto;
        position: relative;
    }

  /* Footer Styles */
footer {
    background: linear-gradient(135deg, #1f1f3a, #111122);
    color: #fff;
    padding: 40px 0;
    text-align: left;
    position: relative;
    z-index: 1;
}

.footer-content {
    display: flex;
    flex-wrap: wrap;
    justify-content: space-between;
}

.footer-content .logo-details {
    flex: 1 1 30%; /* Adjusted width for larger space */
}

.footer-content .links-group {
    flex: 1 1 20%;
    margin: 0 20px;
}

.footer-content .newsletter {
    flex: 1 1 40%; /* Adjusted width for larger space */
}

.footer-content h4 {
    font-size: 1.5rem;
    margin-bottom: 20px;
}

.footer-content ul {
    list-style: none;
    padding: 0;
}

.footer-content ul li {
    margin-bottom: 10px;
}

.footer-content ul li a {
    color: #bbb;
    text-decoration: none;
    transition: color 0.3s;
}

.footer-content ul li a:hover {
    color: #fff;
}

.footer-content .newsletter form {
    display: flex;
    flex-direction: row;
}

.footer-content .newsletter input[type="email"] {
    padding: 10px;
    border: none;
    border-radius: 5px 0 0 5px;
    outline: none;
    flex: 1;
}

.footer-content .newsletter button {
    padding: 10px 20px;
    border: none;
    border-radius: 0 5px 5px 0;
    background-color: #ff00ff;
    color: #fff;
    cursor: pointer;
    transition: background-color 0.3s;
}

.footer-content .newsletter button:hover {
    background-color: #e600e6;
}

.social-icons {
    margin-top: 10px;
}

.social-icon {
    display: inline-block;
    color: #fff;
    font-size: 1.5rem;
    margin-right: 10px;
    transition: transform 0.3s ease-in-out;
}

.social-icon:hover {
    transform: scale(1.2);
}

.footer-bottom {
    background: #0d0d27;
    padding: 20px 0;
    text-align: center;
    color: #bbb;
    border-top: 1px solid #222;
}

.footer-bottom a {
    color: #ff00ff;
    text-decoration: none;
}

.footer-bottom a:hover {
    color: #e600e6;
}
.footer-content .newsletter input[type="email"] {
    padding: 10px;
    border: none;
    border-radius: 5px 0 0 5px;
    outline: none;
    flex: 1;
    max-width: 200px; 
    width: 100%; 
}
/* Responsive Styles */
@media (max-width: 768px) {
    .footer-content {
        flex-direction: column;
        align-items: center;
    }

    .footer-content .logo-details,
    .footer-content .links-group,
    .footer-content .newsletter {
        flex: 1 1 100%;
        text-align: center;
        margin: 20px 0;
    }
}

    body {
    background-color: #0d0d27;
    color: #fff;
    font-family: 'Arial', sans-serif;
}

.container {
    max-width: 100%;
    margin: auto;
    position: relative;
}


.navbar {
    background-color: #121027; 
    padding: 10px 0;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

.navbar-brand {
    color: #fff !important; 
    font-size: 1.5rem;
    font-weight: bold;
}

.navbar-nav {
    margin-left: auto;
}

.nav-link {
    color: #fff !important;
    margin: 0 10px;
    font-size: 1.2rem;
    transition: color 0.3s;
}

.nav-link:hover {
    color: #e600e6 !important; 
}

.dropdown-menu {
    background-color: #0d0d27; 
}

.dropdown-menu .dropdown-item {
    color: #fff !important; 
}

.dropdown-menu .dropdown-item:hover {
    background-color: #1f1f3a; 
}

.notification-icon {
    color: #fff;
    font-size: 1.3rem;
    margin-right: 10px;
}

/* Search Form Styles */
.search-form {
    display: flex;
    align-items: center;
}

.search-input {
    width: 200px;
    background-color: #121027;
    border: 1px solid #444;
    color: #fff;
    border-radius: 20px;
    padding: 5px 10px;
    transition: width 0.3s;
}

.search-input:focus {
    width: 300px;
}

.search-button {
    color: #fff;
}

/* Responsive Styles */
@media (max-width: 768px) {
    .nav-link {
        font-size: 1rem;
    }
}

</style>
</head>
<body>
    <div id="app">
    <nav class="navbar navbar-expand-md navbar-dark shadow-sm">
    <div class="container">
        <a class="navbar-brand" href="{{ url('/') }}">
            {{ config('app.name', 'Devdo') }}
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <!-- Right Side Of Navbar -->
            <ul class="navbar-nav ml-auto">
                @guest
                    @if (Route::has('login'))
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                        </li>
                    @endif

                    @if (Route::has('register'))
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                        </li>
                    @endif
                @else
                    <li class="nav-item">
                        <form class="nav-link search-form" action="{{ route('search') }}" method="GET" style="background: transparent">
                            <input type="text" name="query" placeholder="Search for users..." class="form-control search-input">
                            <button type="submit" class="btn btn-link search-button"><i class="fas fa-search"></i></button>
                        </form>
                    </li>
                    <li class="nav-item">
                                <a class="nav-link" href="{{ route('explore.posts') }}">
                                    <i class="fas fa-globe explore-icon"></i> 
                                </a>
                            </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('profile.requests') }}">
                            <i class="fas fa-bell notification-icon"></i>
                        </a>
                    </li>
                    <li class="nav-item dropdown">
                        <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                            {{ Auth::user()->name }}
                        </a>
                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="{{ route('profile.show', ['id' => Auth::id()]) }}">
                                My Profile
                            </a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="{{ route('logout') }}"
                               onclick="event.preventDefault();
                                             document.getElementById('logout-form').submit();">
                                {{ __('Logout') }}
                            </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                        </div>
                    </li>
                @endguest
            </ul>
        </div>
    </div>
</nav>

        <main class="py-4">
            @yield('content')
        </main>

        <footer>
    <div class="container">
        <div class="footer-content">
            <div class="logo-details">
                <h4>DevDo</h4>
                <p>is your go-to social media platform, whether you're a Developer, Designer, or Company. Connect, share, and collaborate on your favorite projects.</p>
            </div>
            <div class="links-group">
                <h4>Support</h4>
                <ul>
                    <li><a href="{{ route('faq') }}">FAQs</a></li>
                    <li><a href="{{ route('about') }}">About Us</a></li>
                    <li><a href="{{ route('contact') }}">Contact Us</a></li>
                    <li><a href="{{ route('terms') }}">Terms & Conditions</a></li>
                    <li><a href="{{ route('privacy') }}">Privacy Policy</a></li>
                </ul>
            </div>
            <div class="newsletter">
                <h4>Join Newsletter</h4>
                <p>Subscribe to our newsletter to get the latest updates and offers.</p>
                <form action="#" style="background: transparent; box-shadow: none; padding: 0">
                    <input type="email" placeholder="Enter your email" style="padding: 8px; font-size: 14px; width: 140px" >
                    <button type="submit">→</button>
                </form>
                <div class="social-icons">
                    <a href="#" class="social-icon"><i class="fab fa-facebook-f"></i></a>
                    <a href="#" class="social-icon"><i class="fab fa-twitter"></i></a>
                    <a href="#" class="social-icon"><i class="fab fa-instagram"></i></a>
                </div>
            </div>
        </div>
        <div class="footer-bottom">
            <p>&copy; 2024 Devdo. All rights reserved.</p>
            <p>We use cookies for better service. <a href="#">Accept</a></p>
        </div>
    </div>
</footer>

    </div>
    
    <!-- Include jQuery and Bootstrap JS if not already included -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.1/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
    var dropdown = document.getElementById('navbarDropdown');
    var menu = document.querySelector('.dropdown-menu');

    dropdown.addEventListener('click', function() {
        menu.classList.toggle('show');
    });

    document.addEventListener('click', function(event) {
        if (!dropdown.contains(event.target)) {
            menu.classList.remove('show');
        }
    });
});

    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
    const unfollowButtons = document.querySelectorAll('.unfollow-button');

    unfollowButtons.forEach(button => {
        button.addEventListener('click', function(event) {
            event.preventDefault();
            const userId = this.dataset.userId;
            const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            
            fetch(`/profile/${userId}/unfollow`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': token,
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Remove the post or update the UI accordingly
                    this.closest('.post').remove(); // Assuming each post has a .post class
                } else {
                    console.error('An error occurred:', data.message);
                }
            })
            .catch(error => console.error('Error:', error));
        });
    });
});

    </script>
</body>
</html>
