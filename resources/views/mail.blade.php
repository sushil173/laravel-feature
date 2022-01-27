<h1>Hey, User</h1>
@if ($type == 'admin')
  <h1>Click below link to register</h1>
  <a href="{{ $url.'/verify/'.$email.'/'.$otp.'/'.$id }}">Click Here</a>
@elseif($type == 'user')
  <h1>OTP for complete Registration</h1>
  <p>Your OTP: {{ $after_otp }}</p>
@endif
<p>Sending Mail from Laravel.</p>