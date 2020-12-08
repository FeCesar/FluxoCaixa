<?php

    date_default_timezone_set('America/Sao_Paulo');
    $saida = $_POST['saida'];
    $entrada = $_POST['entrada'];
    $id_carro = $_POST['id'];

    $data = new DateTime();
    $data_formato = $data->format('Y/m/d');
    $horario = $data->format('H:i:s');

    try{

        $conn = new PDO('mysql:host=localhost;dbname=estacionamentodb', 'root', '');
        $stmt = $conn->query("SELECT configs_valor FROM configs WHERE configs_dia = '$data_formato'");

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
           $valor_global = $row['configs_valor'];
        }

        $valor_global = ($valor_global + $entrada) - $saida;

        $stmt = $conn->prepare("UPDATE configs SET configs_valor = $valor_global WHERE configs_dia = '$data_formato'");
        $stmt->execute();

        $stmt = $conn->prepare("UPDATE carros SET carro_placa = null WHERE carro_id = '$id_carro'");
        $stmt->execute();

        $stmt = $conn->prepare("UPDATE carros SET carro_horario_saida = '$horario' WHERE carro_id = '$id_carro'");
        $stmt->execute();

        header("Location:../index.php");

    } catch (PDOException $e){
        echo "Error: " . $e->getMessage();
    }

?>