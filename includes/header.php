<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Seminario de Lenguajes II - TP Integrador</title>
    <!-- BOOTSTRAP -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css" integrity="sha384-zCbKRCUGaJDkqS1kPbPd7TveP5iyJE0EjAuZQTgFLD2ylzuqKfdKlfG/eSrtxUkn" crossorigin="anonymous">
    <link href="../css/estilos.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="../plugins/dist/sweetalert2.min.css">
</head>
<body>
  <header>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
      <div class="container-fluid">
        <a class="navbar-brand" href="../home.php">Inicio</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="true" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
          <ul class="navbar-nav">
            <li class="nav-item">
              <a class="nav-link" href='../pantalla/roles.php' style="cursor: hand;">Roles</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href='../pantalla/usuarios.php' style="cursor: hand;">Usuarios</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href='../pantalla/paises.php' style="cursor: hand;">Países</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href='../pantalla/provincias.php' style="cursor: hand;">Provincias</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href='../pantalla/localidades.php' style="cursor: hand;">Ciudades</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href='../pantalla/personas.php' style="cursor: hand;">Personas</a>
            </li>
          </ul>
        </div>
      </div>
    </nav>
  </header>
  <script src="../plugins/dist/sweetalert2.all.min.js"></script>
<script>
  function mensaje(titulo, icono, boton){
    Swal.fire({
    title: titulo,
    icon: icono,
    confirmButtonText: boton
    })
  }
</script>