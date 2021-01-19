<?php
session_start();
if (!isset($_SESSION["name"])) {
    header('Location: login.php?url=' . basename($_SERVER['PHP_SELF']));
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!--CSS-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">

    <title>Mi cuenta</title>
</head>

<body>
    <?php
    include_once('app/nav.php');
    ?>

    <div class="container mt-3">
        <h1 class="h1 text-center">
            Información de mi cuenta
        </h1>

        <!-- Targeta para presentar información del usuario -->
        <div class="row justify-content-center mt-3">
            <div class="col-12 col-md-7 text-center">
                <div class="card">
                    <div class="card-header fw-bold fs-3 bg-dark text-light" id="userFullName"></div>
                    <div class="card-body">
                        <div class="row justify-content-center mt-3">
                            <div class="col-12 col-md-5 text-center text-md-end"><b>Nombre de usuario</b></div>
                            <div class="col-12 col-md-7 text-center text-md-start" id="userName"></div>
                        </div>

                        <div class="row justify-content-center mt-3">
                            <div class="col-12 col-md-5 text-center text-md-end"><b>Correo electrónico</b></div>
                            <div class="col-12 col-md-7 text-center text-md-start" id="userEmail"></div>
                        </div>

                        <div class="row justify-content-center mt-3">
                            <div class="col-12 col-md-5 text-center text-md-end"><b>Escuela</b></div>
                            <div class="col-12 col-md-7 text-center text-md-start" id="userSchool"></div>
                        </div>

                        <div class="row justify-content-center mt-3">
                            <div class="col-12 col-md-5 text-center text-md-end"><b>Total registros</b></div>
                            <div class="col-12 col-md-7 text-center text-md-start" id="userRegisters"></div>
                        </div>

                        <div class="row justify-content-center mt-4">
                            <div class="col-auto text-center">
                                <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#desactivarCuenta">Desactivar mi cuenta</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="desactivarCuenta" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-sm modal-dialog-centered">
            <div class="modal-content">

                <div class="modal-body p-1">
                    <div class="row justify-content-center mt-3">
                        <input type="hidden" name="idUsuario" id="idUsuario" value="<?php echo $_SESSION["id"]; ?>">
                        <div class="col-12 text-center fw-bold my-5">
                            ¿Esta seguro de desactivar su cuenta?
                        </div>
                        <div class="col-auto text-center">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        </div>
                        <div class="col-auto text-center">
                            <button type="button" class="btn btn-danger" id="btnEliminar">Aceptar</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!--Scripts-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-ygbV9kiqUc6oa4msXn9868pTtWMgiQaeYH7/t7LECLbyPA2x65Kgf80OJFdroafW" crossorigin="anonymous"></script>

    <script>
        (function() {
            var userId = <?php echo $_SESSION["id"]; ?>;
            GetData(userId);
        }());
        
        function GetData(userId) {
            url = "app/app-users.php";
            fetch(url, {
                    method: "post",
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded'
                    },
                    body: "userId=" + userId
                })
                .then(response => response.json())
                .then(data => {
                    // console.log(data);
                    document.getElementById("userFullName").textContent = data.user.name;
                    document.getElementById("userName").textContent = data.user.username;
                    document.getElementById("userEmail").textContent = data.user.email;
                    document.getElementById("userSchool").textContent = data.user.school;
                    document.getElementById("userRegisters").textContent = data.registros;
                })
        }

        var btnEliminar = document.getElementById("btnEliminar");
        btnEliminar.addEventListener("click",()=>{
            var idUsuario = document.getElementById("idUsuario").value;
            url = "app/app-users.php";
            fetch(url,{
                method:"post",
                headers:{
                    'Content-Type': 'application/x-www-form-urlencoded'
                },
                body: "userDelete="+idUsuario
            })
            .then(response => response.text())
            .then(response=>{
                console.log(response);
                if(response == "success"){
                    window.location.href = 'logout.php';
                }
            })
        })
    </script>
</body>

</html>