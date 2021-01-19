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

    <title>Registrarse en el sitio</title>
</head>

<body>
    <?php
    include_once('app/nav.php');
    ?>

    <div class="container mt-3">
        <h1 class="h1 text-center">Registrarse en Reportes QCI</h1>

        <div class="mt-5 row justify-content-center">
            <div class="col-12 col-md-7 text-center">
                <form action="" method="post" id="registerForm" autocomplete="off">
                    <input type="hidden" name="register" id="register">

                    <div class="row justify-content-center mt-3">
                        <label for="name" class="col-12 col-md-5 text-center text-md-end mt-1">Nombre completo<span class="text-danger">*</span></label>
                        <div class="col-12 col-md-6 text-center">
                            <input type="text" name="name" id="name" class="form-control" required placeholder="Puedes usar solo tus iniciales o un apodo si lo deseas">
                        </div>
                    </div>

                    <div class="row justify-content-center mt-3">
                        <label for="username" class="col-12 col-md-5 text-center text-md-end mt-1">Nombre de usuario<span class="text-danger">*</span></label>
                        <div class="col-12 col-md-6 text-center">
                            <input type="text" name="username" id="username" class="form-control" placeholder="Nombre para iniciar sesión" required>
                        </div>
                    </div>

                    <div class="row justify-content-center mt-3">
                        <label for="email" class="col-12 col-md-5 text-center text-md-end mt-1">Correo electronico<span class="text-danger">*</span></label>
                        <div class="col-12 col-md-6 text-center">
                            <input type="email" name="email" id="email" class="form-control" placeholder="Ingresa tu correo electronico" required>
                        </div>
                    </div>

                    <div class="row justify-content-center mt-3">
                        <label for="password" class="col-12 col-md-5 text-center text-md-end mt-1">Contraseña<span class="text-danger">*</span></label>
                        <div class="col-12 col-md-6 text-center">
                            <input type="password" name="password" id="password" class="form-control" placeholder="Ingresa una contraseña" required>
                        </div>
                    </div>

                    <div class="row justify-content-center mt-3">
                        <label for="school" class="col-12 col-md-5 text-center text-md-end mt-1">Escuela/Centro universitario</label>
                        <div class="col-12 col-md-6 text-center">
                            <input type="text" name="school" id="school" class="form-control" placeholder="Ingresa el nombre o iniciales de tu escuela">
                        </div>
                    </div>

                    <div class="row justify-content-center mt-3">
                        <div class="col-auto text-center">
                            <button type="submit" class="btn btn-primary" id="btnRegister">Registrarse</button>
                        </div>
                    </div>

                    <div class="row justify-content-center mt-3">
                        <div class="col-12 col-md-8 text-center alert alert-success d-none" role="alert" id="registerAlert">
                            A simple primary alert—check it out!
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!--Scripts-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-ygbV9kiqUc6oa4msXn9868pTtWMgiQaeYH7/t7LECLbyPA2x65Kgf80OJFdroafW" crossorigin="anonymous"></script>

    <script>
        var registerForm = document.getElementById("registerForm");

        registerForm.addEventListener("submit", function(evt) {
            evt.preventDefault();
            let formData = new FormData(registerForm);
            let url = "app/app-users.php"

            fetch(url, {
                    method: 'post',
                    body: formData
                })
                .then(response => response.text())
                .then(function(text) {
                    let registerAlert = document.getElementById("registerAlert");
                    if (text == "success") {
                        registerAlert.innerHTML = "Usuario creado, inicia sesión";
                        registerAlert.classList.add('alert-success');
                        registerAlert.classList.remove('alert-danger', 'd-none');
                        setTimeout(function() {
                            window.location.href = 'login.php';
                        }, 2000);

                    } else {

                        registerAlert.innerHTML = text;
                        registerAlert.classList.add('alert-danger');
                        registerAlert.classList.remove('alert-success', 'd-none');

                        setTimeout(function() {
                            registerAlert.classList.add('d-none');
                        }, 2000);
                        console.log(text);
                    }
                })
        });
    </script>
</body>

</html>