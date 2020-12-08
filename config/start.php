<?php

    try{
        $conn = new PDO('mysql:host=localhost', 'root', '');
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "create database if not exists estacionamentodb";
        $conn->exec($sql);
        $sql = "use estacionamentodb";
        $conn->exec($sql);
        $sql = "create table if not exists configs(
            configs_id int primary key auto_increment,
            configs_dia date,
            configs_valor float
        )";
        $conn->exec($sql);
        $sql = "create table if not exists carros(
            carro_id int primary key auto_increment,
            carro_placa varchar(7),
            carro_horario_entrada time,
            carro_horario_saida time,
            carro_dia_entrada date
        )";
        $conn->exec($sql);
        header('location: ../index.php');
    } catch (PDOException $e){
        echo $sql . "<br>" . $e->getMessage();
    }

?>