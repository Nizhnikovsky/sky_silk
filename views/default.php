<?php

$router = \App\Core\App::getRouter();
$session = \App\Core\App::getSession();

?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title><?=\App\Core\Config::get('siteName')?></title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css" integrity="sha384-PsH8R72JQ3SOdhVi3uxftmaW6Vc51MKb0q5P2rRUpPvrszuE4W1povHYgTpBfshb" crossorigin="anonymous">
    <link rel="stylesheet" href="/css/default.css" >
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <script type="application/javascript" src="/js/default.js"></script>
</head>
<body>
    <nav class="navbar navbar-expand-md navbar-dark bg-dark fixed-top">
        <a class="navbar-brand" href="/"><?=__('header.homepage')?></a>
        <div class="collapse navbar-collapse" id="navbarsExampleDefault">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item active">
                    <a class="nav-link" href="<?=$session->get('user_id')? $router->buildUri('login.logout'): $router->buildUri('login.index')?>"><?=$session->get('user_id')? __('header.logout') : __('header.login')?></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?=!$session->get('user_id')? $router->buildUri('register.index') : null?>"><?=!$session->get('user_id')?  __('header.register'): null?></a>
                </li>
            </ul>
        </div>
    </nav>

    <main class="container" style="max-width: 1700px">
        <div class="row" >
            <?php if ($session->hasFlash()){ ?>
                <?php foreach ($session->getFlash() as $message){ ?>
                   <div class="alert alert-warning" style="margin-top: 100px;margin-left: 650px;position: absolute">
                       <?= $message ?>
                   </div>
                <?php }?>
            <?php } ?>
            <?=$data['content']?>
        </div>
    </main>

</body>
</html>
