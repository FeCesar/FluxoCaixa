<?php
  error_reporting(0);
  ini_set(“display_errors”, 0 );
?>
<!doctype html>
<html lang="pt_br">
  <head>
    <title>Dados Carros</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
  </head>
  <body>
      
    <main class="container">
    <?php
        date_default_timezone_set('America/Sao_Paulo');
        $placa = $_POST['placa'];

        try{

            $conn = new PDO('mysql:host=localhost;dbname=estacionamentodb', 'root', '');
            $stmt = $conn->query("SELECT * FROM carros WHERE carro_placa = '$placa'");
            $stmt2 = $conn->query("SELECT * FROM carros WHERE carro_placa = '$placa'")->fetchAll();
            $count = count($stmt2);

            if($count < 1){
              header("Location: ../index.php");
            }

            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){

              $id_carro = $row['carro_id'];

              $horario_inicio = $row['carro_horario_entrada'];
              $horario_saida = date('H:i:s');

              $horario_inicio = DateTime::createFromFormat('H:i:s', $horario_inicio);
              $horario_saida = DateTime::createFromFormat('H:i:s', $horario_saida);

              $intervalo = $horario_inicio->diff($horario_saida);
              $permanencia = $intervalo->format('%H:%I:%S');

              $valor_hora_dia = number_format($row['carro_valor_dia'], 2, '.', '');

                echo "<h5 style='margin-top: 5%;'>Carro Id: " . $row['carro_id'] . "</h5>";
                echo "<h5>Modelo Carro: " . $row['carro_modelo'] . "</h5>";
                echo "<h5>Placa Carro: " . $row['carro_placa'] . "</h5>";
                echo "<h5>Horário Entrada: " . $row['carro_horario_entrada'] . "</h5>";
                echo "<h5>Dia Entrada: " . $row['carro_dia_entrada'] . "</h5>";
                echo "<h5>Valor/Hora: R$" . $valor_hora_dia . "</h5>";
                echo "<br>";
                echo "<h5>Tempo Presente no Estacionamento: " . $permanencia . "</h5>";
                
                $partes = explode(":", $permanencia);
                
                if($partes[0] == '00'){
                  $valor = $row['carro_valor_dia'] / 60;
                  $valor_pagar = $partes[1] * $valor;
                  $valor_pagar = number_format($valor_pagar, 2, '.', '');
                  echo "<h5>Valor A Pagar: R$" . $valor_pagar . "</h5>";
                } else{
                  $valor_hora = $row['carro_valor_dia'] * $partes[0];
                  $valor_minutos = ($row['carro_valor_dia'] / 60) * $partes[1];
                  $valor_total = $valor_hora + $valor_minutos;
                  $valor_total = number_format($valor_total, 2, '.', '');
                  echo "<h5>Valor A Pagar: R$" . $valor_total . "</h5>";
                }
                echo "<br>";

            }

        } catch (PDOException $e){
            echo "Error: " . $e->getMessage();
        }

    ?>

        <form action="<?php $_SERVER['PHP_SELF'] ?>?a=pagamento" method="post">
            <input type="hidden" name="placa" value="<?php echo $placa?>">
            <input type="number" step="0.05" name="pagamento">
            <input type="checkbox" name="ticket" style="margin-right: 5px; margin-left: 5px;" value="cupom" id="inputTicket">Ticket<br>
            <input type="submit" value="Receber" style="margin-top: 10px;">
        </form>

    <?php

        $pagamento = $_POST['pagamento'];
        $ticket = $_POST['ticket'];

        if($ticket == 'cupom'){
          if($partes[0] == '00'){
            $pagamento = $pagamento - ($valor_hora_dia/60);
          } else{
            $pagamento = $pagamento - $valor_hora_dia;
          }
        }
          
          if(!empty($pagamento)){
          if($partes[0] == '00'){
            $troco = $pagamento - $valor_pagar;
            $troco = number_format($troco, 2, '.', '');
            if($troco >= 0){
              echo "<h5>Troco: R$" . $troco;
            } else{
              echo "<h5> Por conta da Casa! </h5>";
            }
          }

           else{
            $troco = $pagamento - $valor_total;
            $troco = number_format($troco, 2, '.', '');
            if($troco >= 0){
              echo "<h5>Troco: R$" . $troco;
            } else{
              echo "<h5> Por conta da Casa! </h5>";
            }
            
          }
        }

    ?>

    <form action="../functions/saida-cliente.php" method="post">
        <input type="hidden" step="0.1" name="entrada" value="<?php echo $pagamento; ?>">
        <input type="hidden" step="0.1" name="saida" value="<?php echo $troco ?>">
        <input type="hidden" name="id" value="<?php echo $id_carro; ?>">
        <br>
        <input type="submit" value="Confirmar">

    </form>

    </main>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
  </body>
</html>