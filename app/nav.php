<style>
    .dropdown-item:hover {
        color: gray !important;
    }

    #full-nav,
    .dropdown-item {
        background: rgb(2, 0, 36) !important;
        background: linear-gradient(177deg, rgba(2, 0, 36, 1) 0%, rgba(48, 48, 64, 1) 51%, rgba(193, 121, 79, 1) 100%) !important;

    }

    * {
        font-family: 'Times New Roman', serif;
    }
</style>
<nav class="navbar navbar-expand-lg navbar-dark fw-bold sticky-top" id="full-nav">
    <div class="container-fluid">
        <a class="navbar-brand" href="index.php">Reportes QCI</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarTogglerDemo02" aria-controls="navbarTogglerDemo02" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarTogglerDemo02">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link" href="mapa.php">Mapa </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="foro.php">Foro </a>
                </li>
                <?php
                if (isset($_SESSION["name"])) {
                ?>
                    <li class="nav-item">
                        <a class="nav-link" href="reportes.php">Mis reportes</a>
                    </li>
                <?php
                }
                ?>
            </ul>
            <?php
            if (isset($_SESSION["name"])) {
            ?>
                <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <?php echo $_SESSION["name"]; ?>
                        </a>
                        <div class="dropdown-menu bg-dark py-0" aria-labelledby="userDropdown">
                            <?php
                            if ($_SESSION["isAdmin"]) {
                            ?>
                                <a class="dropdown-item text-light" href="usuarios.php">Usuarios</a>
                            <?php
                            }
                            ?>
                            <a class="dropdown-item text-light" href="cuenta.php">Mi cuenta</a>
                            <a class="dropdown-item text-light" href="logout.php">Salir</a>
                        </div>
                    </li>
                </ul>
            <?php
            } else {
            ?>
                <ul class="navbar-nav mb-2 mb-lg-0 ml-auto">
                    <li class="nav-item">
                        <a href="login.php" class="nav-link">Login</a>
                    </li>
                    <li class="nav-item">
                        <a href="register.php" class="nav-link">Registrarse</a>
                    </li>
                </ul>
            <?php
            }
            ?>
        </div>
    </div>
</nav>