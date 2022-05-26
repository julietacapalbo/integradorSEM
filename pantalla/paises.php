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
    if($_POST['pais']!="" && $_POST['codigo']!="")
    {
        mysqli_query($con,"insert into paises (nombre, codigo) values ('".$_POST['pais']."','".$_POST['codigo']."')");

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
    if($_POST['pais']!="")
    {
        mysqli_query($con,"update paises set nombre='".$_POST['pais']."', codigo='".$_POST['codigo']."' where id_pais=".$_POST['idpais']);

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
    mysqli_query($con,"delete from paises where id_pais=".$_GET['del']);

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
        $datos=mysqli_query($con,"select * from paises r where r.id_pais=".$_GET['ver']);
        if(mysqli_num_rows($datos)!=0)
        {
            $rm=mysqli_fetch_array($datos);
        }
        $url="paises.php?modificar=ok"; 
    } else
        {
            $url="paises.php?guardar=ok";
        }
    ?>
    <form action="<?php echo $url; ?>" method="POST">
        <p><input type="hidden" id="idpais" name="idpais" value="<?php echo $rm['id_pais']; ?>" ></p>
        <p><label>País: </label><input type="text" id="pais" name="pais" value="<?php if (isset($rm)){echo $rm['nombre'];} ?>" ></p>
        <p><label>Código: </label><input type="text" id="codigo" name="codigo" value="<?php if (isset($rm)){echo $rm['codigo'];} ?>" ></p>
        <p><input type="submit" value="Guardar" class="btn btn-light"></p>
    </form>
</div>

<div id="listado">
    <h3>Países</h3>
    <div id="datos">
        <?php
            $consulta=mysqli_query($con,"select * from paises r order by r.nombre ASC");

            if(mysqli_num_rows($consulta) > 0){
            ?>
            <table class="table">
                <thead class="table-dark">
                <tr>
                    <td>Item</td>
                    <td>País</td>
                    <td>Código</td>
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
                    <td><?php echo $r['nombre']; ?></td>
                    <td><?php echo $r['codigo']; ?></td>
                    <td>
                        <p><a href="paises.php?ver=<?php echo $r['id_pais']; ?>">Editar</a></p>
                        <p><a href="paises.php?del=<?php echo $r['id_pais']; ?>">Eliminar</a></p>
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