<?php
$data = file_get_contents("http://localhost/Simec/ws/Usuario/getOne&id=7");
$tupla = json_decode($data, true);
foreach ($tupla as $registro) {
    echo '<pre>';
    //print_r($registro);
    echo $registro['documento'];
    echo '<br>';   
    echo $registro['nombre'];
    echo '<br>';
    echo $registro['email'];
    echo '</pre>';  
}
?>