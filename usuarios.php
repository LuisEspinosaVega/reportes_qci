<?php
session_start();
if (!isset($_SESSION["name"])) {
    header('Location: login.php?url=' . basename($_SERVER['PHP_SELF']));
}
if (($_SESSION["isAdmin"]) == false) {
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

    <title>Lista usuarios</title>
</head>

<body>
    <?php
    include_once('app/nav.php');
    ?>

    <div class="container">
        <h1 class="h1 text-center">Usuarios registrados en la aplicación</h1>
        <div class="table-responsive mt-5">
            <table class="table table-sm table-bordered table-striped">
                <thead class="bg-dark text-white">
                    <tr>
                        <th class="p-1 text-center align-middle">Nombre completo</th>
                        <th class="p-1 text-center align-middle d-none d-sm-none d-md-table-cell">Correo</th>
                        <th class="p-1 text-center align-middle d-none d-sm-none d-md-table-cell">Escuela</th>
                        <th class="p-1 text-center align-middle">Estatus</th>
                    </tr>
                </thead>
                <tbody id="tableBody">
                    <!-- <div id="tableBody"></div> -->
                </tbody>
            </table>
        </div>
    </div>

    <!--Scripts-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-ygbV9kiqUc6oa4msXn9868pTtWMgiQaeYH7/t7LECLbyPA2x65Kgf80OJFdroafW" crossorigin="anonymous"></script>

    <script>
        (function() {
            All(1);

        })();

        function All(pagina) {
            let tableBody = document.getElementById("tableBody");
            let url = "app/app-users.php";

            fetch(url, {
                    method: 'post',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded'
                    },
                    body: 'getUsers=true'
                })
                .then(response => response.json())
                .then(function(json) {
                    json.map(item =>
                        tableBody.innerHTML += (`
                        <tr>
                        <td class='p-1 text-center align-middle'>${item.name}</td>
                        <td class='p-1 text-center align-middle d-none d-sm-none d-md-table-cell'>${item.email}</td>
                        <td class='p-1 text-center align-middle d-none d-sm-none d-md-table-cell'>${item.school}</td>
                        <td class='p-1 text-center align-middle'>${item.status == 1? "Activo":"Inactivo"}</td>
                        </tr>
                        `)
                    )
                })
                .catch(error => {
                    console.error('Error:', error);
                });
        }
    </script>
</body>

</html>