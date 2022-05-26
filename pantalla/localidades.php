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
    if($_POST['ciudad']!="" && $_POST['provincia']!="" && $_POST['codigo']!=""){
    mysqli_query($con,"insert into localidades (nombre_ciudad, codigo_postal, id_provincia) values ('".$_POST['ciudad']."', '".$_POST['codigo']."', ".$_POST['provincia'].")");

        if(!mysqli_error($con)){
            echo "<script>mensaje('Registro insertado correctamente.', 'success', 'Ok');</script>";
        } else{
            echo "<script>mensaje('ERROR se no pudo insertar el registro.', 'error', 'Aceptar');</script>";
        }
    } else{
        echo "<script>mensaje('No deje campos vacios.', 'info', 'Aceptar');</script>";
        }
}

if(isset($_GET['modificar']) && ($_GET['modificar']=="ok"))
{ 
    if($_POST['ciudad']!="" && $_POST['provincia']!="" && $_POST['codigo']!=""){
        mysqli_query($con,"update localidades set nombre_ciudad='".$_POST['ciudad']."', codigo_postal='".$_POST['codigo']."', id_provincia=".$_POST['provincia']." where id_localidad=".$_POST['idlocalidad']);

        if(!mysqli_error($con)){
            echo "<script>mensaje('Registro modificado correctamente.', 'success', 'Ok');</script>";
        } else{
            echo "<script>mensaje('ERROR se no pudo modificar el registro.', 'error', 'Aceptar');</script>";
        }
    }else
        {
            echo "<script>mensaje('No deje campos vacios.', 'info', 'Aceptar');</script>";
        }
}

if(isset($_GET['del']) && ($_GET['del']!=0))
{
    mysqli_query($con,"delete from localidades where id_localidad=".$_GET['del']);

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
        $datos=mysqli_query($con,"select * from localidades r where r.id_localidad=".$_GET['ver']);
        if(mysqli_num_rows($datos)!=0)
        {
            $rm=mysqli_fetch_array($datos);
        }
        $url="localidades.php?modificar=ok"; 
    } else
        {
            $url="localidades.php?guardar=ok";
        }
    ?>
    <form action="<?php echo $url; ?>" method="POST">
        <p><input type="hidden" id="idlocalidad" name="idlocalidad" value="<?php echo $rm['id_localidad']; ?>" ></p>
        <p><label>Ciudad: </label><input type="text" id="ciudad" name="ciudad" value="<?php if (isset($rm)){echo $rm['nombre_ciudad'];} ?>" ></p>
        <p><label>Código postal: </label><input type="text" id="codigo" name="codigo" value="<?php if (isset($rm)){echo $rm['codigo_postal'];} ?>" ></p>
        <p><label>Provincia:</label>
            <select id="provincia" name="provincia">
                <option value="0">Seleccione...</option>
                <?php
                    $sql_provincia=mysqli_query($con,"select * from provincias");
                    if(mysqli_num_rows($sql_provincia) > 0)
                    {
                        while($provincia=mysqli_fetch_array($sql_provincia))
                        {?>
                            <option value="<?php if(isset($provincia)){echo $provincia['id_provincia'];}?>" <?php if(isset($provincia) && isset($rm) && ($provincia['id_provincia']==$rm['id_provincia'])){?> selected <?php } ?> ><?php if(isset($provincia)){echo $provincia['nombre_provincia'];} ?></option>
                        
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
    <h3>Ciudades</h3>
    <div id="datos">
        <?php
            $consulta=mysqli_query($con,"SELECT r.`id_localidad`, r.`nombre_ciudad`, r.`codigo_postal`, p.`nombre_provincia` FROM localidades r, provincias p WHERE r.`id_provincia`=p.`id_provincia` ORDER BY r.`nombre_ciudad` ASC");
            //$consulta=mysqli_query($con,"select * from ciudades r order by r.nombre_ciudad ASC");

            if((isset($consulta)) && (mysqli_num_rows($consulta) > 0)){
            ?>
            <table class="table">
                <thead class="table-dark">
                <tr>
                    <td>Item</td>
                    <td>Ciudad</td>
                    <td>Código postal</td>
                    <td>Provincia</td>
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
                    <td><?php echo $r['nombre_ciudad']; ?></td>
                    <td><?php echo $r['codigo_postal']; ?></td>
                    <td><?php echo $r['nombre_provincia']; ?></td>
                    <td>
                        <p><a href="localidades.php?ver=<?php echo $r['id_localidad']; ?>">Editar</a></p>
                        <p><a href="localidades.php?del=<?php echo $r['id_localidad']; ?>">Eliminar</a></p>
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