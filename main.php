<?php
session_start();
if ($_SESSION['login_active'] == 1) {
    $usuario = $_SESSION['user'];
?>
    <!doctype html>
    <html lang="es">

    <head>
        <title>Bienvenido(a)</title>
        <!-- Required meta tags -->
        <meta charset="utf-8" />
        <meta
            name="viewport"
            content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <!-- Bootstrap CSS v5.2.1 -->
        <link
            href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css"
            rel="stylesheet"
            integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN"
            crossorigin="anonymous" />
        <script
            src="https://code.jquery.com/jquery-3.7.1.min.js"
            integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo="
            crossorigin="anonymous"></script>
        <script src="https://kit.fontawesome.com/34afac4ad4.js" crossorigin="anonymous"></script>
    </head>

    <body data-bs-theme="dark">
        <nav class="navbar navbar-expand-sm">
            <div class="container-fluid">
                <span class="navbar-brand mb-0 h1">Hola, <?= $usuario ?></span>
                <div>
                    <form action="model/logout.php" method="post" class="fixed-right d-flex">
                        <button class="btn btn-danger" type="submit" value="0" name="out"><i class="fa-solid fa-right-from-bracket"></i></button>
                    </form>
                </div>
            </div>
        </nav>
        <div class="container text-center">
            <div class="row">
                <div class="col-6">
                    <div class="card">
                        <div class="card-header">Despachos</div>
                        <div class="card-body">
                            <a href="pages/mod_despachos.php"><button type="button" class="btn btn-primary btn-lg"><i class="fa-solid fa-truck-fast"></i></button></a>
                        </div>
                    </div>
                </div>
                <div class="col-6">
                    <div class="card">
                        <div class="card-header">Próximamente</div>
                        <div class="card-body">
                            <button type="button" class="btn btn-primary btn-lg" disabled><i class="fa-solid fa-clipboard-question"></i></button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script
            src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
            integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r"
            crossorigin="anonymous"></script>

        <script
            src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"
            integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+"
            crossorigin="anonymous"></script>
    </body>

    </html>
<?php
} else {
    session_unset();
    session_destroy();
    header('Location: login.php');
}
?>