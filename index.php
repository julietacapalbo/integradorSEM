<?php
include("includes/conexion.php");
conectar();

if(isset($_GET['ingresar']) && ($_GET['ingresar']=="ok"))
{
    if($_POST['usuario']!="" && $_POST['clave']!="")
    {
        $sql=mysqli_query($con,"select * from usuarios u where u.activo=1 and u.nombre_usuario='".$_POST['usuario']."' and u.clave='".$_POST['clave']."'");
        if(mysqli_num_rows($sql)!=0)
        {
            echo "<script>alert('Usuario Logueado');</script>";
            echo "<script>window.location='http://localhost/integradorSEM/home.php';</script>";
        } else
            {
                echo "<script>alert('Usuario o clave incorrecta');</script>";
            }
    } else
        {
            echo "<script>alert('Algunos datos son vacios');</script>";
        }
}

?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="css/estilos.css" rel="stylesheet" type="text/css">
        <title>Seminario de Lenguajes II - TP Integrador</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300&display=swap" rel="stylesheet">

    </head>

    <body>
        <div id="contenedor">
            <div id="principal">
                <div id="fondo_login">
                    <div id="login">
                        <form class="inicio" action="index.php?ingresar=ok" method="post">
                            <p><label>Usuario:</label><input type="text" class="dos" id="user" name="usuario"></p>
                            <p><label>Password:</label><input type="password" id="clave" name="clave"></p>
                            <p><button type="submit"></button></p>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </body>

    </html>