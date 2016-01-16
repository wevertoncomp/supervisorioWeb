<?php $conn -> open($connStr); 

$mostrarResumido = "1";

?>

<div class='well'>
	<h4>Lendo arquivo do Logger</h4>
	<hr>
<?php


function retornaEvento($evento1, $evento2) {
	if ($evento1 == "-1" && $evento2 == "-1") {
		$evento = "DES";
		$corBotao = "danger";
	} else if ($evento1 == "0" && $evento2 == "1") {
		$evento = "CicF";
		$corBotao = "success";
	} else if ($evento1 == "1" && $evento2 == "0") {
		$evento = "CicA";
		$corBotao = "default";
	} else if ($evento1 == "0" && $evento2 == "0") {
		$evento = "STOP";
		$corBotao = "danger";
	} else if ($evento1 == "1" && $evento2 == "1") {
		$evento = "SETUP";
		$corBotao = "primary";
	}

	echo "<td><button type='button' class='btn btn-$corBotao btn-xs'>$evento1 $evento2 $evento</button></td>";
}


// Exemplo de scrip para exibir os nomes obtidos no arquivo CSV de exemplo

$delimitador = ';';
$cerca = '"';

// Abrir arquivo para leitura
$f = fopen('arquivos/Dados_prado.csv', 'r');
$s = file( "arquivos/Dados_prado.csv" );
$linhas  = count($f);

echo $f [10] . "<br>";

for($i = $linhas - 1; $i < $linhas; $i ++){
	echo $s [$i] . "<br>";
}


echo "<br/>Ultima atualização do arquivo: " .date("d/m/Y H:i:s", filemtime("arquivos/Dados_prado.csv"));
if ($f) {

	// Ler cabecalho do arquivo
	$cabecalho = fgetcsv($f, 0, $delimitador, $cerca);

	
	echo "<table class='table'>";

	// Enquanto nao terminar o arquivo
//	while (!feof($f)) {


		// Ler uma linha do arquivo
		$linha = fgetcsv($f, 0, $delimitador, $cerca);


		// Montar registro com valores indexados pelo cabecalho
		$registro = array_combine($cabecalho, $linha);

		echo "<tr>";
		
		$data = $registro['DATE'];
		$hora = $registro['TIME'];
	
		$bit0Inj2 = $registro['INJET03_0'];
		$bit1Inj2 = $registro['INJET03_1'];


		// Obtendo o nome
		echo "<td>$data</td>";
		echo "<td>$hora</td>";
				
		//echo "<td><button type='button' class='btn btn-$corBotao1 btn-xs'>$bit0Inj1 $bit1Inj1 $evento1</button></td>";
//		echo "<td><button type='button' class='btn btn-$corBotao2 btn-xs'>$bit0Inj2 $bit1Inj2 $evento2</button></td>";
		retornaEvento($bit0Inj2, $bit1Inj2);
		
		echo "</tr>";

		
//	}
	
//	echo end( file( "arquivos/Dados_prado.csv" ) );
	
	echo "</table>";
	
	fclose($f);
}


$conn -> Close();
$conn = null;

echo "</div>";
?>