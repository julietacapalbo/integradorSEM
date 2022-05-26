<?php

function roles($dato)
{
    global $con;
    
    $consulta=mysqli_query($con,"select nombre_rol from roles where id_rol=".$dato);
    if(mysqli_num_rows($consulta) > 0)
    {
        $r=mysqli_fetch_array($consulta);
        return $r['nombre_rol'];
    } else
        {
            return "Sin Datos";
        }
}

?>