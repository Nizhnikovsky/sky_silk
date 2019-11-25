<?php
?>
<div style="margin-top: 150px; margin-left: 700px">
    <div class="col-lg-12">
        <form method="post" action="">
            <div class="form-group">
                <input class="form-control" name="login" value="<?= $data['login'] ?>">
            </div>
            <div class="form-group">
                <input class="form-control" name="email" value="<?= $data['email'] ?>">
            </div>
            <div class="form-group">
                <input class="form-control" name="password">
            </div>

            <button type="submit" class="btn btn-success">Edit</button>
        </form>
    </div>
</div>
