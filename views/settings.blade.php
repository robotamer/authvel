<div class="header">
     {{ Auth::user()->username }} {{ HTML::link('auth/logout', 'Logout') }}
</div>
<div class="content">
    <h1>Settings</h1>

<p>Change password:</p>

</div>
<pre>
<?php 
$i = Auth::check();
var_dump($i);
$i = Auth::guest();
var_dump($i);
?>
</pre>