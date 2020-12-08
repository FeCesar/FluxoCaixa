<?php

    $carro = $_POST['carro'];
    $placa = $_POST['placa'];
    $valor = $_POST['valor'];
    $data = new DateTime();
    $dia_entrada = $data->format('Y-m-d');
    $horario_entrada = $data->format('H:i:s');

    try{

        $conn = new PDO('mysql:host=localhost;dbname=estacionamentodb', 'root', '');
        $stmt = $conn->prepare("INSERT INTO carros(carro_placa, carro_horario_entrada, carro_modelo, carro_valor_dia, carro_dia_entrada) VALUES(:placa, :horario_entrada, :modelo, :valor_dia, :dia_entrada)");
        $stmt->execute(array(
            'placa' => $placa,
            'horario_entrada' => $horario_entrada,
            'modelo' => $carro,
            'valor_dia' => $valor,
            'dia_entrada' => $dia_entrada
        ));

        header('Location: ../index.php');
        

    } catch (PDOException $e){
        echo "Error: " . $e->getMessage();
    }

?>