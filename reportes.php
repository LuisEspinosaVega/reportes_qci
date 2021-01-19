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

    <!-- Mapa -->
    <script src="https://polyfill.io/v3/polyfill.min.js?features=default"></script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBCmzC6C_4dR9jtlCMAFhyK7rpBu0pTgoE&callback=initMap&libraries=&v=weekly" defer></script>

    <title>Mis reportes</title>

    <style>
        .bg-modal-light {
            background: rgb(2, 0, 36);
            background: linear-gradient(90deg, rgba(2, 0, 36, 1) 0%, rgba(48, 48, 64, 0.14049369747899154) 51%, rgba(193, 121, 79, 1) 100%);
        }

        #map {
            height: 100%;
        }

        #divMap {
            width: auto;
            height: 500px;
        }
    </style>
</head>

<body>
    <?php
    include_once('app/nav.php');
    ?>

    <div class="container mt-3">
        <h1 class="h1 text-center">Mis registros</h1>

        <div class="row justify-content-center mt-3">
            <div class="col-12 col-md-8 text-center alert alert-success d-none" role="alert" id="reporteAlert">
                A simple primary alert—check it out!
            </div>
        </div>

        <div class="row justify-content-center justify-content-md-end mt-3">
            <div class="col-auto">
                <button class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#newReporte">Crear reporte</button>
            </div>
            <div class="col-12 mt-3">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped">
                        <thead class="bg-dark text-light text-center">
                            <tr>
                                <th class="p-1 align-middle d-none d-sm-none d-md-table-cell">ID reporte</th>
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

        <!-- <div class="row justify-content-center">
            <div class="col-auto text-center mt-1">
                <nav aria-label="...">
                    <ul class="pagination">
                        <li class="page-item disabled">
                            <a class="page-link" href="#" tabindex="-1" aria-disabled="true"> Previo </a>
                        </li>
                        <li class="page-item"><a class="page-link" href="#">1</a></li>
                        <li class="page-item active" aria-current="page">
                            <a class="page-link" href="#">2</a>
                        </li>
                        <li class="page-item"><a class="page-link" href="#">3</a></li>
                        <li class="page-item">
                            <a class="page-link" href="#">Siguiente</a>
                        </li>
                    </ul>
                </nav>
            </div>
        </div> -->
    </div>

    <!-- Modal -->
    <div class="modal fade" id="newReporte" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered">
            <div class="modal-content bg-modal-light">
                <div class="modal-body">
                    <form action="" method="post" id="newForm">
                        <input type="hidden" name="newPost" id="newPost">
                        <input type="hidden" name="long" id="long">
                        <input type="hidden" name="lat" id="lat">
                        <input type="hidden" name="usuarioId" id="usuarioId" value="<?php echo $_SESSION['id']; ?>">

                        <div class="row justify-content-center mt-3">
                            <label for="tipoReporte" class="col-12 col-md-5 text-center text-md-end fw-bold fs-5 text-white">Tipo de reporte</label>
                            <div class="col-12 col-md-7">
                                <select name="tipoReporte" id="tipoReporte" class="form-select" required>
                                    <option value="">Elige una opción...</option>
                                    <option value="Agresion verbal">Agreción verbal</option>
                                    <option value="Agresion fisica">Agreción fisica</option>
                                    <option value="Asalto">Asalto</option>
                                    <option value="Otro">Otro (Espesificar en descripción)</option>
                                </select>
                            </div>
                        </div>

                        <div class="row justify-content-center mt-3">
                            <label for="status" class="col-12 col-md-5 text-center text-md-end fw-bold fs-5 text-white">Estatus del reporte</label>
                            <div class="col-12 col-md-7">
                                <select name="status" id="status" class="form-select" required>
                                    <option value="">Elige una opción...</option>
                                    <option value="Reportado">Reportado a la autoridad</option>
                                    <option value="Platicado">Se lo comenté a un conocido (amigos, familiares)</option>
                                    <option value="Nadie sabe">Nadie lo sabe</option>
                                </select>
                            </div>
                        </div>

                        <div class="row justify-content-center mt-3">
                            <label for="description" class="col-12 col-md-5 text-center text-md-end fw-bold fs-5 text-white">Descripción</label>
                            <div class="col-12 col-md-7">
                                <textarea name="description" id="description" rows="3" class="form-control" requireds></textarea>
                            </div>
                        </div>

                        <div class="row justify-content-center">
                            <div class="col-12 col-md-6">
                                <div class="row justify-content-center mt-3">
                                    <label for="fechaAtercado" class="col-12 col-lg-5 text-center text-lg-end fw-bold fs-5 text-white">Fecha del atercado</label>
                                    <div class="col-12 col-lg-7">
                                        <input type="date" name="fechaAtercado" id="fechaAtercado" class="form-control" required>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-md-6">
                                <div class="row justify-content-center mt-3">
                                    <label for="horaAtercado" class="col-12 col-lg-5 text-center text-lg-end fw-bold fs-5 text-white">Hora del atercado</label>
                                    <div class="col-12 col-lg-7">
                                        <input type="time" name="horaAtercado" id="horaAtercado" class="form-control" required>
                                    </div>
                                </div>
                            </div>
                        </div>




                        <div class="row mt-3" id="divMap">
                            <div class="col-12" id="map"></div>
                        </div>

                        <div class="row justify-content-center mt-3">
                            <div class="col-auto text-center">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                            </div>
                            <div class="col-auto text-center">
                                <button type="submit" class="btn btn-primary">Aceptar</button>
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
        // Controlar el cargar los datos al iniciar
        (function() {
            GetData();
        }());

        let map;

        function initMap() {

            map = new google.maps.Map(document.getElementById("map"), {
                center: setLatLng(),
                zoom: 14,
            });

            var marker = new google.maps.Marker({
                position: setLatLng(),
                map: map,
                title: "Click para cambiar de la locación del reporte",
                draggable: false
            });

            map.addListener("click", (event) => {
                marker.setPosition(event.latLng);
                let dataString = event.latLng.toString();
                let dataArray = dataString.split(", ");

                let longitud = dataArray[1].substring(0, dataArray[1].length - 1);
                let latitud = dataArray[0].substring(1)

                document.getElementById("lat").value = latitud;
                document.getElementById("long").value = longitud;
                //console.log(dataArray);
            });
        }

        function setLatLng() {
            let myLatlng = {
                lat: 20.659539,
                lng: -103.324288
            };

            return myLatlng;
        }

        // Acciones para siempre que se abra el modal tener todo limpio
        var newReporte = document.getElementById('newReporte');

        newReporte.addEventListener('shown.bs.modal', function() {

            document.getElementById("lat").value = 20.659539; //regresar los valores al lugar de default
            document.getElementById("long").value = -103.324288; // lo mismo que arriba

            document.getElementById("tipoReporte").value = "";
            document.getElementById("description").value = "";
            document.getElementById("status").value = "";
            document.getElementById("fechaAtercado").value = "";
            document.getElementById("horaAtercado").value = "";
        });

        // Manejar el formulario al hacer POST
        var newForm = document.getElementById("newForm");

        // Crear un objeto para el modal
        var myModal = new bootstrap.Modal(document.getElementById('newReporte'), {
            keyboard: false,
            backdrop: 'static'
        })

        newForm.addEventListener("submit", function(evt) {
            evt.preventDefault();
            let formData = new FormData(newForm);
            let url = "app/app-registros.php";

            fetch(url, {
                    method: 'post',
                    body: formData
                })
                .then(response => response.text())
                .then(function(text) {
                    let reporteAlert = document.getElementById("reporteAlert");
                    myModal.hide();
                    if (text == "success") {
                        //Si se crea el reporte cargar la tabla
                        GetData()
                        reporteAlert.innerHTML = "Reporte creado";
                        reporteAlert.classList.add('alert-danger');
                        reporteAlert.classList.remove('d-none', 'alert-danger');

                        setTimeout(function() {
                            window.location.replace("reportes.php");
                            reporteAlert.classList.add('d-none');
                        }, 1000);
                    } else {

                        reporteAlert.innerHTML = "Ocurrio un error, reportalo con el administrador (Nombre->Reportar un error).";
                        reporteAlert.classList.add('alert-danger');
                        reporteAlert.classList.remove('d-none', 'alert-success');
                        setTimeout(function() {
                            reporteAlert.classList.add('d-none');
                        }, 2000);
                        //console.log(text);
                    }
                })
        });

        function GetData() {
            let idUser = <?php echo $_SESSION["id"]; ?>;
            let url = "app/app-registros.php";
            var tableContent = document.getElementById("tableContent");
            tableContent.innerHTML = "";

            fetch(url, {
                    method: "post",
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded'
                    },
                    body: "getAllByUser=" + idUser
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