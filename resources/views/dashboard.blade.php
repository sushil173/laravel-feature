@extends('app')

@section('content')
<main class="login-form">
    <div class="cotainer">
        <div class="row justify-content-center">
            <div class="col-md-4">
                <div class="card">
                    <h3 class="card-header text-center">User Verify Success</h3>
                </div>
            </div>
        </div>
    </div>
</main>
@auth
@if(\Auth::user()->status == 2)
    @include('auth.registration')
@endif
@endauth
@endsection