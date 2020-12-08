<?php

    date_default_timezone_set('America/Sao_Paulo');
    $dia_requerido = new DateTime($_POST['data']);
    $dia_requerido_us = $dia_requerido->format('Y-m-d');
    $dia_requerido_br = $dia_requerido->format('d/m/Y');

?>
<!doctype html>
<html lang="pt_br">
  <head>
    <title>Lista de Dados</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- CSS -->
    <link rel="stylesheet" href="../styles/lista-dados.css">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
  </head>
  <body>
      
    <main class="container">
        <h3 style="margin-top: 3%;">Lista de Registros de <?php echo $dia_requerido_br; ?></h3>

        <table>

            <tr>
                <td>Modelo Veículo</td>
                <td>Horário Entrada</td>
                <td>Horário Saída</td>
            </tr>

        <?php

            try{

                $conn = new PDO('mysql:host=localhost;dbname=estacionamentodb', 'root', '');
                $stmt = $conn->query("SELECT * FROM carros WHERE carro_dia_entrada = '$dia_requerido_us'");

                while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
                    echo "<tr>";
                        echo "<td>" . $row['carro_modelo'] . "</td>";
                        echo "<td>" . $row['carro_horario_entrada'] . "</td>";
                        echo "<td>" . $row['carro_horario_saida'] . "</td>";
                    echo "</tr>";
                }

            } catch(Exception $e){
                echo "Error: " . $e->getMessage();
            }

        ?>
        </table>

    </main>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
  </body>
</html>