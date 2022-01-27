<!DOCTYPE html>
<html>
<head>
    <title>Feature Auth in Laravel</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>

    <nav class="navbar navbar-light navbar-expand-lg mb-5" style="background-color: #e3f2fd;">
        <div class="container">
            <a class="navbar-brand mr-auto" href="#">Laravel</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    @guest
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('login') }}">Login</a>
                    </li>
                    @endguest
                    @auth
                        @if(\Auth::user()->is_admin)
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('invite-user') }}">Invite</a>
                            </li>
                        @endif
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('signout') }}">Logout</a>
                    </li>
                    @endauth
                </ul>
            </div>
        </div>
    </nav>
    @if (\Session::has('success'))
        <div class="alert alert-success">
            <ul>
                <li>{!! \Session::get('success') !!}</li>
            </ul>
        </div>
    @elseif(\Session::has('info'))
        <div class="alert alert-info">
            <ul>
                <li>{!! \Session::get('info') !!}</li>
            </ul>
        </div>

    @endif
    @yield('content')

</body>

</html>