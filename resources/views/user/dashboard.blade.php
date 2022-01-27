@extends('app')

@section('content')
<main class="login-form">
    <div class="cotainer">
        <div class="row justify-content-center">
            <div class="col-md-4">
                <div class="card">
                    <h3 class="card-header text-center">User Verify OTP</h3>
                </div>
            </div>
        </div>
    </div>
</main>
@auth
@if(\Auth::user()->status == 3)
    @include('user.userotp')
@endif
@endauth
@endsection