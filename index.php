

<!doctype html>
<html lang="pt_br">
  <head>
    <title>Fluxo de Caixa</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    
    <!-- Links css -->
    <link rel="stylesheet" href="styles/index.css">
    
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
  </head>
  <body>
      

    <header class="container-fluid">

        <div class="container">
            <div class="box">
                <form action="functions/guarda-valor-inicial.php" method="post">
                    <input type="number" placeholder="Valor do Caixa Inicial" name="valor" required />
                    <input type="submit" value="Definir Caixa">
                </form>
            </div>

            <div class="box" style="float: right; margin-top: 2%;">
                <?php 
                    
                    $data_atual = new DateTime();
                    $data = $data_atual->format("Y-m-d");

                    try{
                        $conn = new PDO('mysql:host=localhost;dbname=estacionamentodb', 'root', '');
                        $stmt = $conn->query("SELECT * FROM configs WHERE configs_dia = '$data'");
                        $stmtRows = $conn->query("SELECT * FROM configs WHERE configs_dia = '$data'")->fetchAll();
                        $count = count($stmtRows);

                        if($count > 0){
                            while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
                                echo "<h6>Caixa Atual: R$ " . $row['configs_valor'] . "</h6>";
                            }
                        } else{
                            echo "<h6>Caixa Atual: Não Definido</h6>";
                        }
                        


                    } catch (PDOException $e){
                        echo "Error: " . $e->getMessage();
                    }

                ?>
            </div>
        </div>
    </header>

    <main class="container">

        <form action="functions/entrada-cliente.php" method="post">
        <h4>Formulário De Entrada</h4>
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="inputEmail4">Carro</label>
                    <input type="text" class="form-control" id="inputEmail4" placeholder="Ex.: Pálio" name="carro">
                </div>
                <div class="form-group col-md-6">
                    <label for="inputPassword4">Placa</label>
                    <input type="text" class="form-control" id="inputPassword4" placeholder="Ex.: ABC1234" name="placa" maxlength="7">
                </div>
                <div class="form-group col-md-3">
                    <label for="inputPassword4">Valor/Hora</label>
                    <input type="number" step="0.1" class="form-control" id="inputPassword4" placeholder="Ex.: 14" name="valor">
                </div>
            </div>
            <button type="submit" class="btn btn-primary">Confirmar</button>
        </form>

        <form action="screens/dados-carros.php" method="post">
        <h4 style="margin-bottom: 2%;">Formulário De Saida</h4>
            <label for="inputPlaca">Placa do Carro: </label>
            <input type="text" placeholder="Ex.: ABC1234" id="inputPlaca" maxlength="7" name="placa">
            <input type="submit" value="Buscar">
        </form>
        


    </main>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
  </body>
</html>