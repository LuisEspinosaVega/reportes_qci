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

    <!-- Mapa -->
    <script src="https://polyfill.io/v3/polyfill.min.js?features=default"></script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBCmzC6C_4dR9jtlCMAFhyK7rpBu0pTgoE&callback=initMap&libraries=&v=weekly" defer></script>

    <title>Registro de reportes</title>

    <style>
        #map {
            height: 100%;
        }

        #setMap {
            width: auto;
            height: 800px;
        }
    </style>
</head>

<body>
    <?php
    include_once('app/nav.php');
    ?>

    <div class="container mt-3">
        <h1 class="h1 text-center">Mapa de reportes capturados</h1>

        <div class="row mt-3" id="setMap">
            <div class="col-12" id="map"></div>
        </div>
    </div>

    <!--Scripts-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-ygbV9kiqUc6oa4msXn9868pTtWMgiQaeYH7/t7LECLbyPA2x65Kgf80OJFdroafW" crossorigin="anonymous"></script>


    <script>
        (function() {
            GetData();
        }());

        let map;

        function initMap() {

            map = new google.maps.Map(document.getElementById("map"), {
                center: setLatLng(),
                zoom: 12,
            });
        }

        function setLatLng() {
            let myLatlng = {
                lat: 20.659539,
                lng: -103.324288
            };

            return myLatlng;
        }

        function setMarks(lat, lng) {
            console.log(lat + "  " + lng);
        }

        function GetData() {
            fetch('app/app-registros.php', {
                    method: 'post',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded'
                    },
                    body: 'getMarks=getMarks'
                })
                .then(response => response.json())
                .then(data => {
                    data.forEach(d => {
                        let myLatlng = {
                            lat: parseFloat(d.latitud),
                            lng: parseFloat(d.longitud)
                        };
                        let descripcion = d.descripcion
                        return new google.maps.Marker({
                            position: myLatlng,
                            map: map,
                            title: descripcion
                        })
                        setMarks(d.latitud, d.longitud);
                    })

                })
        }
    </script>
</body>

</html>