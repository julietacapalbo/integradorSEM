<style>
    table{border-collapse: separate;}
    td{border:solid 1px;
    text-align: center;
    width: 15%;}
</style>
<?php
include("../includes/conexion.php");
conectar();
include("../includes/funciones.php");
include('../includes/header.php');

if(isset($_GET['guardar']) && ($_GET['guardar']=="ok"))
{
    if($_POST['user']!="" && $_POST['pass']!="")
    {
        if($_POST['rol']==0)
        {
            $sql="insert into usuarios (nombre_usuario, clave) values ('".$_POST['user']."','".$_POST['pass']."')";
        } else
            {
                $sql="insert into usuarios (nombre_usuario, clave, id_rol) values ('".$_POST['user']."','".$_POST['pass']."',".$_POST['rol'].")";  
            }
        mysqli_query($con,$sql);
        
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
    if($_POST['user']!="" && $_POST['pass']!="")
    {
        if($_POST['rol']==0)
        {
            $sql="update usuarios set nombre_usuario='".$_POST['user']."', clave='".$_POST['pass']."' where id_usuario=".$_POST['idusuario'];
        } else
            {
                $sql="update usuarios set nombre_usuario='".$_POST['user']."', clave='".$_POST['pass']."', id_rol=".$_POST['rol']." where id_usuario=".$_POST['idusuario'];
            }
        mysqli_query($con,$sql);
        
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
    mysqli_query($con,"update usuarios set activo=0 where id_usuario=".$_GET['del']);

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
        $datos=mysqli_query($con,"select * from usuarios r where r.id_usuario=".$_GET['ver']);
        if(mysqli_num_rows($datos)!=0)
        {
            $rm=mysqli_fetch_array($datos);
        }
        $url="usuarios.php?modificar=ok"; 
    } else
        {
            $url="usuarios.php?guardar=ok";
        }
    ?>
    <form action="<?php echo $url; ?>" method="POST">
        <p><input type="hidden" id="idusuario" name="idusuario" value="<?php echo $rm['id_usuario']; ?>" ></p>
        <p><label>Usuario:</label><input type="text" id="user" name="user" value="<?php if(isset($rm)){echo $rm['nombre_usuario'];} ?>" ></p>
        <p><label>Clave:</label><input type="pass" id="pass" name="pass" value="<?php if(isset($rm)){echo $rm['clave'];} ?>" ></p>
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
        <p><input type="submit" value="Guardar" class="btn btn-light"></p>
    </form>
</div>

<div id="listado">
    <h3>Usuarios</h3>
    <div id="datos">
        <?php
            //Solo Tabla usuarios
            //$consulta=mysqli_query($con,"select * from usuarios r where r.activo=1 order by r.nombre_usuario ASC");
            
            //Usuarios join roles
            $consulta=mysqli_query($con,"SELECT u.`id_usuario`, u.`nombre_usuario`, u.`clave`, r.`nombre_rol` FROM usuarios u, roles r WHERE u.`id_rol`=r.`id_rol` AND u.`activo`=1 ORDER BY u.`nombre_usuario` ASC");
            
            if(mysqli_num_rows($consulta) > 0)
            { ?>
                <table class="table">
                    <thead class="table-dark">
                        <tr>
                            <td>Item</td>
                            <td>Usuario</td>
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
                                    <td><?php echo $r['nombre_usuario'];?></td>
                                    <td><?php echo ($r['nombre_rol']); ?></td>
                                    <td>
                                        <p><a href="usuarios.php?ver=<?php echo $r['id_usuario']; ?>">Editar</a></p>
                                        <p><a href="usuarios.php?del=<?php echo $r['id_usuario']; ?>">Eliminar</a></p>
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