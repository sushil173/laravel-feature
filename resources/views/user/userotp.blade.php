<main class="signup-form">
    <div class="cotainer">
        <div class="row justify-content-center">
            <div class="col-md-4">
                <div class="card">
                    <h6 class="card-header text-center">Enter After OTP</h6>
                    <div class="card-body">

                        <form action="{{ route('user.post.otp') }}" method="POST">
                            @csrf
                            <div class="form-group mb-3">
                                <input type="number" placeholder="OTP" id="otp" class="form-control" name="after_otp" required autofocus>
                                @if ($errors->has('after_otp'))
                                <span class="text-danger">{{ $errors->first('after_otp') }}</span>
                                @endif
                            </div>

                            <div class="d-grid mx-auto">
                                <button type="submit" class="btn btn-dark btn-block">Submit</button>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
