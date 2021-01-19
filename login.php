<?php
session_start();
if (isset($_SESSION["name"])) {
    header('Location: index.php');
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!--CSS-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">

    <title>Iniciar sesión</title>
</head>

<body>
    <?php
    include_once('app/nav.php');
    ?>

    <div class="container mt-3">
        <h1 class="h1 text-center mt-5">Iniciar sesión</h1>
        <div class="mt-5" id="form-body">
            <div class="row justify-content-center">
                <div class="col-12 col-md-6">
                    <form action="" method="post" id="loginForm" autocomplete="off">
                        <input type="hidden" name="login" id="login">
                        <div class="row justify-content-center">
                            <div class="col-12">
                                <img src="img/logo.jpg" class="img-fluid" alt="">
                            </div>
                        </div>
                        <div class="row mt-3">
                            <label for="username" class="h6 mt-2 col-12 col-md-5 text-center text-md-end">Usuario o correo</label>
                            <div class="col-12 col-md-6">
                                <input type="text" name="username" id="username" class="form-control" required>
                            </div>
                        </div>

                        <div class="row mt-3">
                            <label for="password" class="h6 mt-2 col-12 col-md-5 text-center text-md-end">Contraseña</label>
                            <div class="col-12 col-md-6">
                                <input type="password" name="password" id="password" class="form-control" required>
                            </div>
                        </div>

                        <div class="mt-4 row justify-content-center">
                            <div class="col-auto">
                                <button type="submit" class="btn btn-primary">Ingresar</button>
                            </div>
                        </div>

                        <div class="row justify-content-center mt-3">
                            <div class="col-12 col-md-8 text-center alert alert-danger d-none" role="alert" id="failAlert">
                                A simple primary alert—check it out!
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>



    <!--Scripts-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-ygbV9kiqUc6oa4msXn9868pTtWMgiQaeYH7/t7LECLbyPA2x65Kgf80OJFdroafW" crossorigin="anonymous"></script>

    <script>
        var loginForm = document.getElementById("loginForm");

        loginForm.addEventListener("submit", function(evt) {
            evt.preventDefault();
            let formData = new FormData(loginForm);
            let url = "app/app-users.php"

            fetch(url, {
                    method: 'post',
                    body: formData
                })
                .then(response => response.text())
                .then(function(text) {
                    if (text == "success") {
                        window.location.href = 'index.php';
                    } else {
                        let failAlert = document.getElementById("failAlert");
                        failAlert.innerHTML = text;
                        failAlert.classList.remove('d-none');
                        setTimeout(function() {
                            failAlert.classList.add('d-none');
                        }, 2000);
                        console.log(text);
                    }
                })
        });
    </script>
</body>

</html>