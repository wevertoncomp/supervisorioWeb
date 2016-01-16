<?php $conn -> open($connStr); 

$mostrarResumido = "1";

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

	echo "<td><button type='button' class='btn btn-$corBotao btn-xs'>$evento</button></td>";
}

?>

<div class='well'>
	<h4>Lendo arquivo do Logger</h4>
<?php

// Exemplo de scrip para exibir os nomes obtidos no arquivo CSV de exemplo

$delimitador = ';';
$cerca = '"';

// Abrir arquivo para leitura
$f = fopen('arquivos/Dados_prado.csv', 'r');
echo "<br/>Ultima atualização do arquivo: " .date("d/m/Y H:i:s", filemtime("arquivos/Dados_prado.csv")). "<br/>";
if ($f) {

	// Ler cabecalho do arquivo
	$cabecalho = fgetcsv($f, 0, $delimitador, $cerca);
	
	$line_count = 0;
	// Enquanto nao terminar o arquivo
	while (!feof($f)) {

		// Ler uma linha do arquivo
		$linha = fgetcsv($f, 0, $delimitador, $cerca);

		$line_count += count ($f);

		// Montar registro com valores indexados pelo cabecalho
		$registro = array_combine($cabecalho, $linha);

	}
	fclose($f);
	
}

$f = fopen('arquivos/Dados_prado.csv', 'r');
if ($f) {

	// Ler cabecalho do arquivo
	$cabecalho = fgetcsv($f, 0, $delimitador, $cerca);

	$line_count2 = 0;
	echo "<table class='table'>";
	
	echo "<tr>";
	echo "<th>Data</th>";
	echo "<th>Inj01</th>";
	echo "<th>Inj02</th>";
	echo "<th>Inj03</th>";
	echo "<th>Inj04</th>";
	echo "<th>Inj05</th>";
	echo "<th>Inj06</th>";
	echo "<th>Inj07</th>";
	echo "<th>Inj08</th>";
	echo "<th>Inj09</th>";
	echo "<th>Inj10</th>";
	echo "<th>Inj11</th>";
	echo "<th>Inj12</th>";
	echo "<th>Inj13</th>";
	echo "<th>Inj14</th>";
	echo "<th>Inj15</th>";
	echo "<th>Inj16</th>";
	echo "<th>Inj17</th>";
	echo "<th>Inj18</th>";
	echo "<th>Inj19</th>";
	echo "<th>Inj20</th>";
	echo "<th>Inj21</th>";
	echo "<th>Inj22</th>";
	echo "<th>Inj23</th>";
	echo "<th>Inj24</th>";
	echo "</tr>";
	// Enquanto nao terminar o arquivo
	while (!feof($f)) {

		// Ler uma linha do arquivo
		$linha = fgetcsv($f, 0, $delimitador, $cerca);

		$line_count2 += count ($f);

		// Montar registro com valores indexados pelo cabecalho
		$registro = array_combine($cabecalho, $linha);
		
		if (($line_count2 > ($line_count - 13)) && ($line_count2 < ($line_count))) {
		

echo "<tr>";

$data = $registro['DATE'];
$hora = $registro['TIME'];

// Obtendo o nome
echo "<td>$data<br/>$hora</td>";
//echo "<td>$hora</td>";

for ($i=1; $i<=24; $i++ ) {
if ($i < 10){
$injetoraBit0 = "INJET0".$i."_0";
$injetoraBit1 = "INJET0".$i."_1";
} else {
$injetoraBit0 = "INJET".$i."_0";
$injetoraBit1 = "INJET".$i."_1";
}
//echo $injetora;
$evento1 = $registro[$injetoraBit0];
$evento2 = $registro[$injetoraBit1];

//echo "<td><button type='button' class='btn btn-$corBotao1 btn-xs'>$bit0Inj1 $bit1Inj1 $evento1</button></td>";
//echo "<td><button type='button' class='btn btn-$corBotao2 btn-xs'>$bit0Inj2 $bit1Inj2 $evento2</button></td>";
retornaEvento($evento1, $evento2);
}

echo "</tr>";



		}

	}


	fclose($f);
}
echo "</table>";


$conn -> Close();
$conn = null;

echo "</div>";
?>