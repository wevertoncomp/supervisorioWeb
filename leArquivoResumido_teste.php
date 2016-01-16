<?php $conn -> open($connStr); 

$mostrarResumido = "1";

function retornaEvento($evento1, $evento2) {
	if ($evento1 == "-1" && $evento2 == "-1") {
		$evento = "DES";
		$corBotao = "danger";
	} else if ($evento1 == "0" && $evento2 == "1") {
		$evento = "RUN";
		$corBotao = "success";
	} else if ($evento1 == "1" && $evento2 == "0") {
		$evento = "RUN";
		$corBotao = "success";
	} else if ($evento1 == "0" && $evento2 == "0") {
		$evento = "STOP";
		$corBotao = "danger";
	} else if ($evento1 == "1" && $evento2 == "1") {
		$evento = "SETUP";
		$corBotao = "primary";
	}
	//echo "<td><button type='button' class='btn btn-$corBotao btn-xs'>$evento</button></td>";
	return $evento;
}
?>

<div class='well'>
	<h4>Lendo arquivo do Logger</h4>
	<hr>
<?php

// Exemplo de scrip para exibir os nomes obtidos no arquivo CSV de exemplo

$delimitador = ';';
$cerca = '"';
$tempoAcumulado = 0;
$tempoStop = 0;
$tempoSetup = 0;
$tempoRun = 0;
$tempoDesligado = 0;

// Abrir arquivo para leitura
$f = fopen('arquivos/Dados_prado.csv', 'r');

 	
if ($f) {
	
	// Especificando o intervalo do arquivo. Primeira e ultima atualização
	$cabecalho = fgetcsv ( $f, 0, $delimitador, $cerca );
	$primeiraLinha = fgetcsv ( $f, 0, $delimitador, $cerca );
	$primeiroRegistro = array_combine ( $cabecalho, $primeiraLinha );
	$primeiraData = $primeiroRegistro ['DATE'];
	$primeiraHora = $primeiroRegistro ['TIME'];
	echo "<br/>Primeira atualização do arquivo: " . $primeiraData . " " . $primeiraHora;
	echo "<br/>Ultima atualização do arquivo: " . date ( "d/m/Y H:i:s", filemtime ( "arquivos/Dados_prado.csv" ) );
	
	echo "<table class='table'>";
	
	echo "<tr>";
	echo "<th>INJET01</th>";
	echo "<th>INJET02</th>";
	echo "<th>INJET03</th>";
	echo "<th>INJET04</th>";
	echo "<th>INJET05</th>";
	echo "<th>INJET06</th>";
	echo "<th>INJET07</th>";
	echo "<th>INJET08</th>";
	echo "<th>INJET09</th>";
	echo "<th>INJET10</th>";
	echo "<th>INJET11</th>";
	echo "<th>INJET12</th>";
	echo "<th>INJET13</th>";
	echo "<th>INJET14</th>";
	echo "<th>INJET15</th>";
	echo "<th>INJET16</th>";
	echo "<th>INJET17</th>";
	echo "<th>INJET18</th>";
	echo "<th>INJET19</th>";
	echo "<th>INJET20</th>";
	echo "<th>INJET21</th>";
	echo "<th>INJET22</th>";
	echo "<th>INJET23</th>";
	echo "<th>INJET24</th>";
	echo "</tr>";
	
	// Enquanto nao terminar o arquivo
	while ( ! feof ( $f ) ) {
		
		// Ler uma linha do arquivo
		$linha = fgetcsv ( $f, 0, $delimitador, $cerca );
		if (! $linha) {
			continue;
		}
		
		// Montar registro com valores indexados pelo cabecalho
		$registro = array_combine ( $cabecalho, $linha );
		
		echo "<tr>";
		
		for($i = 1; $i <= 24; $i ++) {
			
			if ($i < 10) {
				$injetoraBit0 = "INJET0" . $i . "_0";
				$injetoraBit1 = "INJET0" . $i . "_1";
			} else {
				$injetoraBit0 = "INJET" . $i . "_0";
				$injetoraBit1 = "INJET" . $i . "_1";
			}

			$data = str_replace ( '/', '-', $data );
			$dataFormatada = substr ( $data, 6, 4 ) . "-" . substr ( $data, 3, 2 ) . "-" . substr ( $data, 0, 2 );
				
			$data1 = "$dataFormatada $hora2";
			$data2 = "$dataFormatada $hora";
				
			$unix_data1 = strtotime ( $data1 );
			$unix_data2 = strtotime ( $data2 );
				
			$nHoras = ($unix_data2 - $unix_data1) / 3600;
			$nMinutos = (($unix_data2 - $unix_data1) % 3600) / 60;
			$nSegundos = ($unix_data2 - $unix_data1);
			
			$tempoAcumulado += $nSegundos;

			$evento1 = $registro [$injetoraBit0];
			$evento2 = $registro [$injetoraBit1];		
			$evento = retornaEvento ( $evento1, $evento2 );
				
			if ($evento != $eventoTEMP || empty ( $eventoTEMP )) {
				if ($evento == "DES") {
					$tempoDesligado = $tempoDesligado + $tempoAcumulado;
					$tempoAcumulado =0;
				} else if ($evento == "RUN") {
					$tempoRun = $tempoRun + $tempoAcumulado;
					$tempoAcumulado =0;
				} else if ($evento == "STOP") {
					$tempoStop = $tempoStop + $tempoAcumulado;
					$tempoAcumulado =0;
				} else if ($evento == "SETUP") {
					$tempoSetup = $tempoSetup + $tempoAcumulado;
					$tempoAcumulado =0;
				}
			}
			echo "<td>";
			echo $evento;
			echo "</td>";
			$hora2 = $hora;
			$eventoTEMP = $evento2;
		}
		echo "<td>";
		
		//echo "Tempo Desligado: ".$tempoDesligado;
		//echo $tempoRun;
		//echo $tempoSetup;
		//echo $tempoStop;
		
		echo "/<td>";	
		echo "</tr>";
	}
	echo "</table>";
	fclose ( $f );
}

$conn -> Close();
$conn = null;

echo "</div>";
?>