<link rel="stylesheet" href="css/style.css" type="text/css">
<?php
require 'config.php';
require 'classes/carros.php';
require 'classes/reservas.php';

$reservas = new Reservas($pdo);
$carros = new Carros($pdo);

if(!empty($_POST['carro'])){
    $carro = addslashes($_POST['carro']);
    $data_inicio = explode('/',addslashes($_POST['data_inicio']));
    $data_fim = explode('/',addslashes($_POST['data_fim']));
    $pessoa = addslashes($_POST['pessoa']);

    $data_inicio = $data_inicio[2].'-'.$data_inicio[1].'-'.$data_inicio[0];
    $data_fim = $data_fim[2].'-'.$data_fim[1].'-'.$data_fim[0];

    if($reservas->verificarDisponibilidade($carro, $data_inicio,$data_fim)){
        $reservas->reservar($carro,$data_inicio, $data_fim,$pessoa);
        
        header("Location:index.php");
        exit;
    }else{
        echo "Este carro já está reservado neste periodo";
    }

}

?>
<h1 class="title">Adicionar Reserva</h1>

<form method="POST">
	Carros disponiveis:<br/>
	<select class="carro" name="carro">
		<?php
		$lista = $carros->getCarros();

		foreach($lista as $carro):
			?>
			<option value="<?php echo $carro['id']; ?>"><?php echo $carro['nome']; ?></option>
			<?php
		endforeach;
		?>
	</select><br/><br/>

	<br/>
	<input id="data" class="input" type="text" name="data_inicio" placeholder="Data de Inicio" /><br/><br/>

	<br/>
	<input id="data_fim" class="input" type="text" name="data_fim" placeholder="Data de fim" /><br/><br/>

	<br/>
	<input class="input" type="text" name="pessoa" placeholder="Seu nome"/><br/><br/>

	<input class="btn-reservar" type="submit" value="Reservar" />
</form>

<script src="https://unpkg.com/imask"></script>

    <script>
        IMask(
            document.getElementById('data'),
            {
                mask:'00/00/0000'
            }
        );

		IMask(
            document.getElementById('data_fim'),
            {
                mask:'00/00/0000'
            }
        );

    </script>