<?php

/** @var array $data */

$router = \App\Core\App::getRouter();
$session = \App\Core\App::getSession();


?>
<div style="margin-top: 150px; margin-left: 700px">
<form action="/login/auth" method="post" class="needs-validation" novalidate>
    <div class="form-group">
        <label for="uname">Login</label>
        <input type="text" class="form-control" id="uname" placeholder="Enter username" name="login" required>
        <div class="valid-feedback">Valid.</div>
        <div class="invalid-feedback">Please fill out this field.</div>
    </div>
    <div class="form-group">
        <label for="pwd">Password:</label>
        <input type="password" class="form-control" id="pwd" placeholder="Enter password" name="password" required>
        <div class="valid-feedback">Valid.</div>
        <div class="invalid-feedback">Please fill out this field.</div>
    </div>
    <button type="submit" class="btn btn-primary">Submit</button>
</form>
</div>
