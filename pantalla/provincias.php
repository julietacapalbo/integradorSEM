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
    if($_POST['provincia']!="" && $_POST['pais']!="")
    {
        mysqli_query($con,"insert into provincias (nombre_provincia, id_pais) values ('".$_POST['provincia']."',".$_POST['pais'].")");

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
    if($_POST['provincia']!="")
    {
        mysqli_query($con,"update provincias set nombre_provincia='".$_POST['provincia']."', id_pais=".$_POST['pais']." where id_provincia=".$_POST['idprovincia']);
        
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
    mysqli_query($con,"delete from provincias where id_provincia=".$_GET['del']);

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
        $datos=mysqli_query($con,"select * from provincias r where r.id_provincia=".$_GET['ver']);
        if(mysqli_num_rows($datos)!=0)
        {
            $rm=mysqli_fetch_array($datos);
        }
        $url="provincias.php?modificar=ok"; 
    } else
        {
            $url="provincias.php?guardar=ok";
        }
    ?>
    <form action="<?php echo $url; ?>" method="POST">
        <p><input type="hidden" id="idprovincia" name="idprovincia" value="<?php echo $rm['id_provincia']; ?>" ></p>
        <p><label>Provincia: </label><input type="text" id="provincia" name="provincia" value="<?php if (isset($rm)){echo $rm['nombre_provincia'];} ?>" ></p>
        <p><label>País:</label>
            <select id="pais" name="pais">
                <option value="0">Seleccione...</option>
                <?php
                    $sql_pais=mysqli_query($con,"select * from paises");
                    if(mysqli_num_rows($sql_pais) > 0)
                    {
                        while($pais=mysqli_fetch_array($sql_pais))
                        {?>
                            <option value="<?php if(isset($pais)){echo $pais['id_pais'];}?>" <?php if(isset($pais) && isset($rm) && ($pais['id_pais']==$rm['id_pais'])){?> selected <?php } ?> ><?php if(isset($pais)){echo $pais['nombre'];} ?></option>
                        
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
    <h3>Provincias</h3>
    <div id="datos">
        <?php
            $consulta=mysqli_query($con,"SELECT r.`id_provincia`, r.`nombre_provincia`, p.`nombre` FROM provincias r, paises p WHERE r.`id_pais`=p.`id_pais` ORDER BY r.`nombre_provincia` ASC");
            //$consulta=mysqli_query($con,"select * from provincias r order by r.nombre_provincia ASC");

            if((isset($consulta)) && (mysqli_num_rows($consulta) > 0)){
            ?>
            <table class="table">
                <thead class="table-dark">
                <tr>
                    <td>Item</td>
                    <td>Provincia</td>
                    <td>Pais</td>
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
                    <td><?php echo $r['nombre_provincia']; ?></td>
                    <td><?php echo $r['nombre']; ?></td>
                    <td>
                        <p><a href="provincias.php?ver=<?php echo $r['id_provincia']; ?>">Editar</a></p>
                        <p><a href="provincias.php?del=<?php echo $r['id_provincia']; ?>">Eliminar</a></p>
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
<script src="sweetalert2.all.min.js"></script>
<script type="text/javascript">

function ver(valor)
{
    if(valor==1)
    {
        document.getElementById("formulario").style.display='block';
    }
}
</script>