<?php
session_start();

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!--CSS-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">

    <title>Registro de reportes</title>

    <!-- <style>
        body {
            background: rgb(2, 0, 36);
            background: linear-gradient(270deg, rgba(2, 0, 36, 1) 0%, rgba(48, 48, 64, 0.4738270308123249) 44%, rgba(193, 121, 79, 1) 100%);
        }
    </style> -->
</head>

<body>
    <?php
    include_once('app/nav.php');
    ?>

    <div class="container mt-3">
        <h1 class="h1 text-center">Listado de reportes QCI</h1>

        <div class="row justify-content-center justify-content-md-end mt-3">
            <div class="col-12 mt-3">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped">
                        <thead class="bg-dark text-light text-center">
                            <tr>
                                <div><th class="p-1 align-middle d-none d-sm-none d-md-table-cell">ID reporte</th></div>
                                <th class="p-1 align-middle">Estatus reporte</th>
                                <th class="p-1 align-middle">Tipo reporte</th>
                                <th class="p-1 align-middle">Descripción</th>
                                <th class="p-1 align-middle d-none d-sm-none d-md-table-cell">Fecha del percance</th>
                                <th class="p-1 align-middle d-none d-sm-none d-md-table-cell">Hora del percance</th>
                                <th class="p-1 align-middle d-none d-sm-none d-md-table-cell">Fecha de creación</th>
                            </tr>
                        </thead>
                        <tbody id="tableContent">

                        </tbody>
                    </table>
                </div>
            </div>
        </div>


    </div>

    <!--Scripts-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-ygbV9kiqUc6oa4msXn9868pTtWMgiQaeYH7/t7LECLbyPA2x65Kgf80OJFdroafW" crossorigin="anonymous"></script>


    <script>
        (function() {
            GetData();
        }());

        function GetData() {
            let url = "app/app-registros.php";
            var tableContent = document.getElementById("tableContent");
            tableContent.innerHTML = "";

            fetch(url, {
                    method: "post",
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded'
                    },
                    body: "getAll=getAll"
                })
                .then(response => response.json())
                .then(reportes => {
                    reportes.map(item =>
                        tableContent.innerHTML += (`
                        <tr class="fw-bold">
                        <td class='p-1 text-center align-middle d-none d-sm-none d-md-table-cell'>${item.id}</td>
                        <td class='p-1 text-center align-middle'>${item.status}</td>
                        <td class='p-1 text-center align-middle'>${item.tipo_reporte}</td>
                        <td class='p-1 text-center align-middle'>${item.descripcion}</td>
                        <td class='p-1 text-center align-middle d-none d-sm-none d-md-table-cell'>${item.fecha_atercado}</td>
                        <td class='p-1 text-center align-middle d-none d-sm-none d-md-table-cell'>${item.hora_atercado}</td>
                        <td class='p-1 text-center align-middle d-none d-sm-none d-md-table-cell'>${item.fecha_post}</td>
                        </tr>
                        `)
                    )
                })

        }
    </script>
</body>

</html>