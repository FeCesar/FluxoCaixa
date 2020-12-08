<?php

    $valor_inicial = $_POST['valor'];
    $data = new DateTime();
    $data_formato = $data->format('Y/m/d');
    
    try{
        $conn = new PDO("mysql:host=localhost;dbname=estacionamentodb", 'root', '');
        $stmt = $conn->prepare("INSERT INTO configs(configs_valor, configs_dia) VALUES(:configs_value, :configs_dia)");

        $stmt->execute(array(
            'configs_value' => $valor_inicial,
            'configs_dia' => $data_formato
        ));

        header('location:../index.php');

    } catch(PDOException $e){
        echo "Error: " . $e->getMessage();
    }

?>