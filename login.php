<!DOCTYPE html>
<html lang="en" data-bs-theme="dark">

<head>
    <title>Iniciar Sesión</title>

    <!-- Required meta tags -->
    <meta charset="utf-8" />
    <meta
        name="viewport"
        content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <!-- Bootstrap CSS v5.2.1 -->
    <link rel="icon" href="./img/web/favicon.ico" sizes="32x32">
    <link rel="apple-touch-icon" href="./img/web/apple-touch-icon.png" type="image/png">
    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css"
        rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN"
        crossorigin="anonymous" />
    <script src="https://kit.fontawesome.com/34afac4ad4.js" crossorigin="anonymous"></script>
    <style>
        html,
        body {
            height: 100%;
        }

        body {
            display: flex;
            align-items: center;
            padding-top: 20px;
            padding-bottom: 20px;
        }

        .form-signin {
            width: 100%;
            max-width: 330px;
            padding: 15px;
            margin: auto;
        }

        .form-signin .form-floating:focus-within {
            z-index: 2;
        }
    </style>
</head>

<body class="text-center">
    <main class="form-signin">
        <?php
        session_start();
        if (isset($_SESSION['statusLogin'])) {
            if ($_SESSION['statusLogin'] == 0) {
        ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="fa-solid fa-triangle-exclamation"></i> <strong>PROBLEMAS!</strong> Usuario y/o contraseña incorrectos, favor ingresar nuevamente
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php
            } else if ($_SESSION['statusLogin'] == 1) {
            ?>
                <div class="alert alert-warning alert-dismissible fade show" role="alert">
                    <i class="fa-solid fa-triangle-exclamation"></i> <strong>PROBLEMAS!</strong> Usuario no activo, favor ingresar con un usuario activo
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php
            } else if ($_SESSION['statusLogin'] == 2) {
            ?>
                <div class="alert alert-warning alert-dismissible fade show" role="alert">
                    <i class="fa-solid fa-triangle-exclamation"></i> <strong>PROBLEMAS!</strong> Usuario sin permisos, favor ingresar con un usuario con permisos
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
        <?php
            }
        }
        unset($_SESSION['statusLogin']);
        ?>
        <form action="model/validate.php" method="post">
            <img src="./img/logo_usr.png" class="rounded mx-auto d-block" alt height="200">
            <h1 class="h3 mb-3 fw-normal">Iniciar Sesión</h1>
            <div class="form-floating mb-3">
                <input
                    type="text"
                    class="form-control"
                    id="username"
                    name="username"
                    required />
                <label for="username">Usuario</label>
            </div>
            <div class="form-floating mb-3">
                <input
                    type="password"
                    class="form-control"
                    id="password"
                    name="password"
                    required />
                <label for="password">Contraseña</label>
            </div>
            <button type="submit" class="w-100 btn btn-lg btn-primary">Ingresar</button>
            <p class="mt-5 mb-3 text-muted"><img src="./img/logo_dev.png" class="rounded" alt height="60"> © 2025</p>
        </form>
    </main>
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