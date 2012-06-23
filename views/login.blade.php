{{ Form::open('auth/login') }} <!-- check for login errors flash var -->
@if (Session::has('login_errors'))
<span class="error">Username and password don't match</span>
@endif

<table>
    <tr>
        <td>{{ Form::label('username', 'Username') }}:
        <br />
        {{ Form::text('username') }}</td>
    </tr>
    <tr>
        <td>{{ Form::label('password', 'Password') }}:
        <br />
        {{ Form::text('password') }}</td>
    </tr>
    <tr>
        <td style="text-align: right">{{ Form::submit('Login') }} O Remember me</td>
    </tr>
</table>
{{ Form::close() }}