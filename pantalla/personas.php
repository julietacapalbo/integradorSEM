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
    if($_POST['apellido']!="" && $_POST['nombre']!="" && $_POST['apodo']!="" && $_POST['rol']!="" && $_POST['localidad']!="")
    {
        mysqli_query($con,"insert into personas (apellido, nombre, apodo, id_rol, id_localidad) values ('".$_POST['apellido']."', '".$_POST['nombre']."', '".$_POST['apodo']."', ".$_POST['rol'].", ".$_POST['localidad'].")");

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
    if($_POST['apellido']!="" && $_POST['nombre']!="" && $_POST['apodo']!="" && $_POST['rol']!="" && $_POST['localidad']!="")
    {
        mysqli_query($con,"update personas set apellido='".$_POST['apellido']."', nombre='".$_POST['nombre']."', apodo='".$_POST['apodo']."', id_rol='".$_POST['rol']."', id_localidad=".$_POST['localidad']." where id_persona=".$_POST['idpersona']);
        
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
    mysqli_query($con,"delete from personas where id_persona=".$_GET['del']);

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
        $datos=mysqli_query($con,"select * from personas r where r.id_persona=".$_GET['ver']);
        if(mysqli_num_rows($datos)!=0)
        {
            $rm=mysqli_fetch_array($datos);
        }
        $url="personas.php?modificar=ok"; 
    } else
        {
            $url="personas.php?guardar=ok";
        }
    ?>
    <form action="<?php echo $url; ?>" method="POST">
        <p><input type="hidden" id="idpersona" name="idpersona" value="<?php echo $rm['id_persona']; ?>" ></p>
        <p><label>Apellido: </label><input type="text" id="apellido" name="apellido" value="<?php if (isset($rm)){echo $rm['apellido'];} ?>" ></p>
        <p><label>Nombre: </label><input type="text" id="nombre" name="nombre" value="<?php if (isset($rm)){echo $rm['nombre'];} ?>" ></p>
        <p><label>Apodo: </label><input type="text" id="apodo" name="apodo" value="<?php if (isset($rm)){echo $rm['apodo'];} ?>" ></p>
        <p><label>Rol:</label>
            <select id="rol" name="rol">
                <option value="0">Seleccione...</option>
                <?php
                    $sql_rol=mysqli_query($con,"select * from roles");
                    if(mysqli_num_rows($sql_rol) > 0)
                    {
                        while($rol=mysqli_fetch_array($sql_rol))
                        {?>
                            <option value="<?php if(isset($rol)){echo $rol['id_rol'];}?>" <?php if(isset($rol) && isset($rm) && ($rol['id_rol']==$rm['id_rol'])){?> selected <?php } ?> ><?php if(isset($rol)){echo $rol['nombre_rol'];} ?></option>
                        
                        <?php
                        }
                    }
                ?>
            </select>
        </p>
        <p><label>Localidad:</label>
            <select id="localidad" name="localidad">
                <option value="0">Seleccione...</option>
                <?php
                    $sql_localidad=mysqli_query($con,"select * from localidades");
                    if(mysqli_num_rows($sql_localidad) > 0)
                    {
                        while($localidad=mysqli_fetch_array($sql_localidad))
                        {?>
                            <option value="<?php if(isset($localidad)){echo $localidad['id_localidad'];}?>" <?php if(isset($localidad) && isset($rm) && ($localidad['id_localidad']==$rm['id_localidad'])){?> selected <?php } ?> ><?php if(isset($localidad)){echo $localidad['nombre_ciudad'];} ?></option>
                        
                        <?php
                        }
                    }
                ?>
            </select>
        </p>
        <p><input type="submit" value="Guardar" class="btn btn-light"></p>
    </form>
</div>

<div id="listado">
    <h3>Personas</h3>
    <div id="datos">
        <?php
            $consulta=mysqli_query($con,"SELECT r.`id_persona`, r.`apellido`, r.`nombre`, r.`apodo`, u.`nombre_rol`, l.`nombre_ciudad` FROM personas r, roles u, localidades l WHERE r.`id_rol`=u.`id_rol` and r.`id_localidad`=l.`id_localidad` ORDER BY r.`apellido` ASC");

            if((isset($consulta)) && (mysqli_num_rows($consulta) > 0)){
            ?>
            <table class="table">
                <thead class="table-dark">
                <tr>
                    <td>Item</td>
                    <td>Apellido</td>
                    <td>Nombre</td>
                    <td>Apodo</td>
                    <td>Rol</td>
                    <td>Localidad</td>
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
                    <td><?php echo $r['apellido']; ?></td>
                    <td><?php echo $r['nombre']; ?></td>
                    <td><?php echo $r['apodo']; ?></td>
                    <td><?php echo $r['nombre_rol']; ?></td>
                    <td><?php echo $r['nombre_ciudad']; ?></td>
                    <td>
                        <p><a href="personas.php?ver=<?php echo $r['id_persona']; ?>">Editar</a></p>
                        <p><a href="personas.php?del=<?php echo $r['id_persona']; ?>">Eliminar</a></p>
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