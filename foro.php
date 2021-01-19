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

    <title>Foro</title>

    <style>
        .bg-modal-light {
            background: rgb(2, 0, 36);
            background: linear-gradient(90deg, rgba(2, 0, 36, 1) 0%, rgba(48, 48, 64, 0.14049369747899154) 51%, rgba(193, 121, 79, 1) 100%);
        }

        .custom-border {
            border: 5px solid black;
            border-radius: 15px;
            background: rgb(2, 0, 36) !important;
            background: linear-gradient(177deg, rgba(2, 0, 36, .2) 0%, rgba(48, 48, 64, 0.14049369747899154) 51%, rgba(193, 121, 79, .2) 100%) !important;
        }

        .custom-border-post {
            border: 2px solid rgb(73,61,67);
            background: rgb(2, 0, 36) !important;
            background: linear-gradient(177deg, rgba(2, 0, 36, .2) 0%, rgba(48, 48, 64, 0.14049369747899154) 51%, rgba(193, 121, 79, .2) 100%) !important;
        }

        .btn-detail:hover {
            background-color: rgb(165, 42, 42, .5);
            cursor: zoom-in;
            color: wheat;
        }

        .iconito {
            overflow: visible;
            font-size: 18px;
            transition: font-size .5s, transform 1s;

        }

        .iconito:hover {
            cursor: cell;
            font-size: 25px;
            transform: rotate(360deg);
        }

        .div-comment {
            border: 2px solid lightgray;
            background: rgb(237, 237, 240);
            background: linear-gradient(0deg, rgba(237, 237, 240, 0.9864320728291317) 0%, rgba(48, 48, 64, 0.14049369747899154) 51%, rgba(231, 175, 249, 0.6278886554621849) 100%);
        }
    </style>
</head>

<body>
    <?php
    include_once('app/nav.php');
    ?>

    <div class="container mt-1">
        <h1 class="h1 text-center">Post de usuarios</h1>
        <?php if (isset($_SESSION["id"])) : ?>
            <div class="row justify-content-center justify-content-md-end mt-2">
                <div class="col-auto">
                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#newPostModal">Crear post ⁜</button>
                </div>
            </div>
        <?php else : ?>
            <div class="col-auto text-center text-md-end">
                Para hacer un post o comentar <a href="register.php" class="fw-bold">Registrate</a> ó <a class="fw-bold" href="login.php">Inicia sesión</a>
            </div>
        <?php endif ?>

        <div class="row justify-content-center mt-2">
            <div class="col-12 col-md-8 text-center alert alert-success d-none" role="alert" id="postAlert">
                A simple primary alert—check it out!
            </div>
        </div>

        <div class="row justify-content-center mt-3" id="postView">
            <!-- Aqui se renderizan los post -->
        </div>
    </div>

    <!-- Modal nuevo post -->
    <div class="modal fade" id="newPostModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content bg-modal-light">
                <div class="modal-body">
                    <form action="" method="post" id="newForm">
                        <input type="hidden" name="newPost" id="newPost">
                        <div class="row justify-content-center mt-3">
                            <label for="titulo" class="col-12 col-md-4 text-center text-md-end text-white fs-5 fw-bold">Titulo del post</label>
                            <div class="col-12 col-md-7 text-center">
                                <input type="text" name="titulo" id="titulo" class="form-control" placeholder="Titulo de tu post" required>
                            </div>
                        </div>

                        <div class="row justify-content-center mt-3">
                            <label for="contenido" class="col-12 text-center text-white fs-5 fw-bold">Contenido del post</label>
                            <div class="col-12 text-center">
                                <textarea name="contenido" id="contenido" rows="5" class="form-control" required placeholder="Escribe el contenido de tu post"></textarea>
                            </div>
                        </div>

                        <div class="row justify-content-center mt-3 p-1">
                            <div class="col-auto text-center">
                                <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Cancelar</button>
                            </div>
                            <div class="col-auto text-center">
                                <button type="submit" class="btn btn-primary btn-sm">Aceptar</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal detalles de post -->
    <div class="modal fade" id="detailsModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-scrollable">
            <div class="modal-content bg-modal-detail">
                <div class="modal-body">
                    <div class="row justify-content-center">
                        <div class='col-12 text-center custom-border-post mt-2' style='min-height:100px;'>
                            <div class='row justify-content-between'>
                                <div class='text-center fs-5 fw-bold col-auto' id="tituloDetail"></div>
                            </div>
                            <div class='row justify-content-end'>
                                <div class='col-auto text-center' style='font-size: 12px;'><span class='fw-bold'>Autor: </span><span id="creadorDetail" class="text-danger"></span><span class='fw-bold'> Fecha del post:</span> <span id="fechaDetail" class="text-danger"></span></div>
                                <div class='col-12 mt-2 text-start' style='max-height:200px; overflow-y:auto' id="contenidoDetail"></div>
                                <?php if (isset($_SESSION["id"])) : ?>
                                    <div class='col-auto'>
                                        <div class='col-auto' id='reaccionesDetail' style="height: 35px;">
                                            <div class='mx-1 mx-md-2' style='display: inline-block;' title='Me gusta'><button onclick="reaction('meGusta')" class="iconito p-0 btn btn-sm btn-outline-success" type='button'>👍</button></div>
                                            <div class='mx-1 mx-md-2' style='display: inline-block;' title='No me gusta'><button onclick="reaction('noMeGusta')" class="iconito p-0 btn btn-sm btn-outline-danger" type='button'>👎</button></div>
                                            <div class='mx-1 mx-md-2' style='display: inline-block;' title='Me divierte'><button onclick="reaction('meDivierte')" class="iconito p-0 btn btn-sm btn-outline-primary" type='button'>🤣</button></div>
                                            <div class='mx-1 mx-md-2' style='display: inline-block;' title='Me encanta'><button onclick="reaction('meEncanta')" class="iconito p-0 btn btn-sm btn-outline-info" type='button'>😍</button></div>
                                            <div class='mx-1 mx-md-2' style='display: inline-block;' title='Me enoja'><button onclick="reaction('meEnoja')" class="iconito p-0 btn btn-sm btn-outline-dark" type='button'>🤬</button></div>
                                            <div class='mx-1 mx-md-2' style='display: inline-block;' title='No entiendo'><button onclick="reaction('noEntiendo')" class="iconito p-0 btn btn-sm btn-outline-warning" type='button'>😩</button></div>
                                        </div>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>

                        <!-- mostrar los comentarios -->
                        <div class="col-12 mt-2 mt-md-3">
                            <div class="row justify-content-end" id="showComments">

                            </div>
                        </div>

                        <!-- dejar un comentario -->
                        <?php if (isset($_SESSION["id"])) : ?>
                            <div class="col-12 mt-2 mt-md-3">
                                <form action="app/app-comments.php" method="post" id="formComment">
                                    <div class="row justify-content-center">
                                        <input type="hidden" name="idDetail" id="idDetail">

                                        <label for="commentContent" class="col-12 col-md-4 text-center text-md-end fw-bold align-self-center">Dejar un comentario:</label>
                                        <div class="col-12 col-md-6">
                                            <textarea name="commentContent" id="commentContent" rows="3" class="form-control" required></textarea>
                                        </div>
                                        <div class="col-12 col-md-2 text-center mt-1 align-self-center">
                                            <button type="submit" class="btn btn-sm btn-primary">Comentar</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        <?php else : ?>
                            <form action="" method="post" id="formComment">
                                <input type="hidden" name="idDetail" id="idDetail">
                                <input type="hidden" name="commentContent" id="commentContent">
                            </form>
                        <?php endif; ?>
                        <div class="col-auto text-center mt-2 mt-md-3">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
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
            GetData();
        }());
        //Declarar el id del post que se estara manupulando
        var idPost = 0;
        //Validar si existe la session
        const isSessionActive = <?php if (isset($_SESSION["id"])) {
                                    echo "true";
                                } else {
                                    echo "false";
                                } ?>;

        function GetData() {
            var postView = document.getElementById("postView");

            fetch("app/app-posts.php", {
                    method: "post",
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded'
                    },
                    body: 'getAllPost=true'
                })
                .then(response => response.json())
                .then(data => {

                    postView.innerHTML = "";
                    data.map(post => {
                        let idpost = post.idPost;
                        postView.innerHTML += `
                        <div class='col-12 text-center custom-border mt-2' style='min-height:100px;'>
                            <div class='row justify-content-between'>
                                <div class='text-center fs-5 fw-bold col-auto'>${post.titulo}</div>
                                <div class='text-end fs-5 fw-bold col-auto btn-detail'>
                                    <div class='fw-bold fs-6' data-idpost='${post.idPost}' data-bs-toggle='modal' data-bs-target='#detailsModal'>Ver conversación »</div>
                                </div>  
                            </div>
                            <div class='row justify-content-end'>
                                <div class='col-auto text-center' style='font-size: 12px;'><span class='fw-bold'>Autor:</span> ${post.username} <span class='fw-bold'>Fecha del post:</span> ${post.fecha_creacion}</div>
                                <div class='col-12 mt-2 text-start' style='max-height:200px; overflow-y:auto'>${post.contenido}</div>
                                <div class='col-12' id='reacciones'>
                                    <div class='me-5 me-md-5' style='display: inline-block; width: 40px; height: 20px;' title='Respuestas al post'>Respuestas<span class='badge bg-dark text-light' id='res-${post.idPost}'></span></div>
                                    <div class='mx-1 mx-md-2' style='display: inline-block; width: 40px; height: 20px;' title='Me gusta'>👍<span class='badge bg-dark text-light' id='mg-${post.idPost}'></span></div>
                                    <div class='mx-1 mx-md-2' style='display: inline-block; width: 40px; height: 20px;' title='No me gusta'>👎<span class='badge bg-dark text-light' id='nmg-${post.idPost}'></span></div>
                                    <div class='mx-1 mx-md-2' style='display: inline-block; width: 40px; height: 20px;' title='Me divierte'>🤣<span class='badge bg-dark text-light' id='md-${post.idPost}'></span></div>
                                    <div class='mx-1 mx-md-2' style='display: inline-block; width: 40px; height: 20px;' title='Me encanta'>😍<span class='badge bg-dark text-light' id='me-${post.idPost}'></span></div>
                                    <div class='mx-1 mx-md-2' style='display: inline-block; width: 40px; height: 20px;' title='Me enoja'>🤬<span class='badge bg-dark text-light' id='men-${post.idPost}'></span></div>
                                    <div class='me-5 me-md-2' style='display: inline-block; width: 40px; height: 20px;' title='No entiendo'>😩<span class='badge bg-dark text-light' id='ne-${post.idPost}'></span></div>
                                </div>
                            </div>
                        </div>
                        `;
                        //Asignar el valor de los mg etc al bloque creado ಥ_ಥ
                        fetch('app/app-posts.php', {
                                method: 'post',
                                headers: {
                                    'Content-Type': 'application/x-www-form-urlencoded'
                                },
                                body: 'getReactions=' + post.idPost
                            })
                            .then(response => response.json())
                            .then(data => {
                                //console.log(data);
                                document.getElementById("res-" + post.idPost).textContent = data.respuestas;
                                document.getElementById("mg-" + post.idPost).textContent = data.reacciones.me_gusta;
                                document.getElementById("nmg-" + post.idPost).textContent = data.reacciones.no_me_gusta;
                                document.getElementById("md-" + post.idPost).textContent = data.reacciones.me_divierte;
                                document.getElementById("me-" + post.idPost).textContent = data.reacciones.me_encanta;
                                document.getElementById("men-" + post.idPost).textContent = data.reacciones.me_enoja;
                                document.getElementById("ne-" + post.idPost).textContent = data.reacciones.no_entiendo;
                            })
                    })
                })
        }

        //limpiar campos al abrir el modal
        var newPostModal = document.getElementById('newPostModal')

        newPostModal.addEventListener('shown.bs.modal', function() {
            document.getElementById("titulo").value = "";
            document.getElementById("contenido").value = "";
        })

        var myModal = new bootstrap.Modal(document.getElementById('newPostModal'), {
            keyboard: false,
            backdrop: 'static'
        })

        //Cargar data del post en especifico XD
        var detailsModal = document.getElementById('detailsModal');


        detailsModal.addEventListener('show.bs.modal', function(event) {
            // Button that triggered the modal
            var button = event.relatedTarget;
            idPost = button.getAttribute('data-idpost');

            //Hacer la consulta
            fetch("app/app-posts.php", {
                    method: "post",
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded'
                    },
                    body: 'getAllPostByPost=' + idPost
                })
                .then(response => response.json())
                .then(data => {
                    document.getElementById("idDetail").value = data.idPost;
                    document.getElementById("commentContent").value = "";
                    document.getElementById("tituloDetail").textContent = data.titulo;
                    document.getElementById("creadorDetail").textContent = data.username;
                    document.getElementById("fechaDetail").textContent = data.fecha_creacion;
                    document.getElementById("contenidoDetail").textContent = data.contenido;
                    getAllCommentsByPost()
                })


        })

        var myModalDetail = new bootstrap.Modal(document.getElementById('detailsModal'), {
            keyboard: false,
            backdrop: 'static'
        })

        //Hacer el post en submit
        var newForm = document.getElementById("newForm");
        newForm.addEventListener("submit", function(evt) {
            evt.preventDefault();
            let formData = new FormData(newForm);
            let url = "app/app-posts.php"

            fetch(url, {
                    method: 'post',
                    body: formData
                })
                .then(response => response.text())
                .then(function(text) {
                    let postAlert = document.getElementById("postAlert");
                    if (text == "success") {
                        GetData();
                        postAlert.innerHTML = "Post creado";
                        postAlert.classList.add('alert-success');
                        postAlert.classList.remove('alert-danger', 'd-none');
                        myModal.hide();
                        setTimeout(function() {
                            postAlert.classList.add('d-none');
                        }, 2000);

                    } else {

                        postAlert.innerHTML = 'Ha ocurrido un error, reportalo con el administrador.';
                        postAlert.classList.add('alert-danger');
                        postAlert.classList.remove('alert-success', 'd-none');
                        myModal.hide();
                        setTimeout(function() {
                            postAlert.classList.add('d-none');
                        }, 2000);
                        console.log(text);
                    }
                })
        });

        //Hacer el comentario en submit
        var formComment = document.getElementById("formComment");
        formComment.addEventListener("submit", function(evt) {
            evt.preventDefault();
            let formData = new FormData(formComment);
            let url = "app/app-comments.php"

            fetch(url, {
                    method: 'post',
                    body: formData
                })
                .then(response => response.text())
                .then(function(text) {
                    document.getElementById("commentContent").value = "";
                    getAllCommentsByPost();
                    GetData();
                })
        });

        //Cargar los comentarios del post
        function getAllCommentsByPost() {
            let id_post = document.getElementById("idDetail").value;
            // El id donde se renderizaran los comentarios
            let showComments = document.getElementById("showComments");
            showComments.innerHTML = "";
            fetch("app/app-comments.php", {
                    method: "post",
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded'
                    },
                    body: 'getPostByPostId=' + id_post
                })
                .then(response => response.json())
                .then((data) => {
                    // console.log(data);
                    data.map(comment => {
                        showComments.innerHTML += `
                            <div class='col-10 col-md-8 mt-2 div-comment'>
                                <div class='row justify-content-end mt-1'>
                                    <div class='col-auto text-center fw-bold'><small>Autor: <span class='text-danger'>${comment.name}</span> - Fecha: <span class='text-danger'>${comment.fecha_creacion}</span></small></div>
                                    <div class='col-12 mt-1'>${comment.contenido}</div>
                                </div>
                            </div>
                        `
                    })
                })
        }

        //Verificar si existe la sesion
        if (isSessionActive) {
            //Guardar las reacciones al hacer click en un iconito
            // var iconito = document.querySelectorAll(".iconito");
            // iconito.addEventListener("click", function() {

            //     console.log(this.getAttribute('data-tipo'))
            // });
        }

        function reaction(tipo) {
            // crear un formdata y llenarlo
            var formData = new FormData();
            formData.append('changeReactions', 'true');
            formData.append('tipoReaction', tipo);
            formData.append('idPostReactions', idPost);
            // console.log(tipo + "el id de este post es: " + idPost);
            //hacer fetc con el tipo de reaccion y el id del post

            fetch('app/app-posts.php', {
                    method: 'post',
                    body: formData
                })
                .then(response => response.text())
                .then(data => {
                    console.log(data);
                    GetData();
                })
        }
    </script>
</body>

</html>