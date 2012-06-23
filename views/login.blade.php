{{ Form::open('auth/login') }} <!-- check for login errors flash var -->
@if (Session::has('login_errors'))
<span class="error">Username and password don't match</span>
@endif

{{ Form::label('username', 'Username') }}:
{{ Form::text('username') }}
{{ Form::label('password', 'Password') }}:
{{ Form::text('password') }}
{{ Form::submit('Login') }}
{{ Form::close() }}

