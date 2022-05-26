<style>
    table{border-collapse: separate;}
    td{border:solid 1px;
    text-align: center;
    width: 15%;}
</style>
<?php
include("../includes/conexion.php");
conectar();
include('../includes/header.php');

if(isset($_GET['guardar']) && ($_GET['guardar']=="ok"))
{
    if($_POST['rol']!="")
    {
        mysqli_query($con,"insert into roles (nombre_rol) values ('".$_POST['rol']."')");

        if(!mysqli_error($con))
        {
            echo "<script>mensaje('Registro insertado correctamente.', 'success', 'Ok');</script>";
        } else
            {
                echo "<script>mensaje('ERROR se no pudo insertar el registro.', 'error', 'Aceptar');</script>";
            }
    } else
        {
            echo "<script>mensaje('No deje campos vacios.', 'info', 'Aceptar');</script>";
        }
}

if(isset($_GET['modificar']) && ($_GET['modificar']=="ok"))
{
    if($_POST['rol']!="")
    {
        mysqli_query($con,"update roles set nombre_rol='".$_POST['rol']."' where id_rol=".$_POST['idrol']);

        if(!mysqli_error($con))
        {
            echo "<script>mensaje('Registro modificado correctamente.', 'success', 'Ok');</script>";
        } else
            {
                echo "<script>mensaje('ERROR se no pudo modificar el registro.', 'error', 'Aceptar');</script>";
            }
    } else
        {
            echo "<script>mensaje('No deje campos vacios.', 'info', 'Aceptar');</script>";
        }
}

if(isset($_GET['del']) && ($_GET['del']!=0))
{
    mysqli_query($con,"delete from roles where id_rol=".$_GET['del']);

    if(!mysqli_error($con))
    {
        echo "<script>mensaje('Registro eliminado correctamente.', 'warning', 'Aceptar');</script>";
    } else
        {
            echo "<script>mensaje('ERROR se no pudo eliminar el registro.', 'error', 'Aceptar');</script>";
        }
}

?>
<div class="main">
<button onclick="ver(1)" class="btn btn-light">Nuevo</button>
<div id="formulario" <?php if(isset($_GET['ver']) && ($_GET['ver']!=0)){?> style="display: block;" <?php } else {?> style="display: none;" <?php } ?> > 
    <?php
    if(isset($_GET['ver']) && ($_GET['ver']!=0))
    {
        $datos=mysqli_query($con,"select * from roles r where r.id_rol=".$_GET['ver']);
        if(mysqli_num_rows($datos)!=0)
        {
            $rm=mysqli_fetch_array($datos);
        }
        $url="roles.php?modificar=ok"; 
    } else
        {
            $url="roles.php?guardar=ok";
        }
    ?>
    <form action="<?php echo $url; ?>" method="POST">
        <p><input type="hidden" id="idrol" name="idrol" value="<?php echo $rm['id_rol']; ?>" ></p>
        <p><label>Rol: </label><input type="text" id="rol" name="rol" value="<?php if (isset($rm)){echo $rm['nombre_rol'];} ?>" ></p>
        <p><input type="submit" value="Guardar" class="btn btn-light"></p>
    </form>
</div>

<div id="listado">
    <h3>Roles</h3>
    <div id="datos">
        <?php
            $consulta=mysqli_query($con,"select * from roles r order by r.nombre_rol ASC");

            if(mysqli_num_rows($consulta) > 0)
            { ?>
                <table class="table">
                    <thead class="table-dark">
                        <tr>
                            <td>Item</td>
                            <td>Rol</td>
                            <td>Opciones</td>
                        </tr>
                    </thead>
                    <?php
                        $cont=1;
                        while($r=mysqli_fetch_array($consulta))
                        {
                            ?>
                                <tr>
                                    <td><?php echo $cont; ?></td>
                                    <td><?php echo $r['nombre_rol']; ?></td>
                                    <td>
                                        <p><a href="roles.php?ver=<?php echo $r['id_rol']; ?>">Editar</a></p>
                                        <p><a href="roles.php?del=<?php echo $r['id_rol']; ?>">Eliminar</a></p>
                                    </td>
                                </tr>
                            <?php
                            $cont++;
                        }
                    ?>
                </table>
            <?php
            } else
                {
                    echo "<p style='color:#ff0000'>Sin Datos</p>";
                }
        ?>
    </div>
</div>
</div>
<script type="text/javascript">

function ver(valor)
{
    if(valor==1)
    {
        document.getElementById("formulario").style.display='block';
    }
}
</script>