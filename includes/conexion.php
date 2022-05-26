<?php

function conectar()
{
    global $con;
    $ret=false;

    $con=mysqli_connect("localhost","root","");

    if($con != false)
    {
        mysqli_select_db($con,"tpi_semii");
        $ret=true;
    }

    return $ret;
}

function desconectar()
{
    global $con;

    mysqli_close($con);
}
?>