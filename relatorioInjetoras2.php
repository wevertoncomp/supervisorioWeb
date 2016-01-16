<?php


$porcentagemTotal = '100';
$delimitador = ';';
$cerca = '"';
$quantInjetoras = '3';


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
	return $evento;
}

// funcao para imprimir os eventos e seus respectivos tempos
function imprimeEventos($numInjetora, $tempoDesligado, $tempoRun, $tempoRun, $tempoSetup, $tempoStop, $porcentagemDesligado, $porcentagemSetup, $porcentagemStop, $porcentagemRun, $tempoTotal, $porcentagemTotal) {

	echo "<tr>";
	if($numInjetora<10)
		echo "<td>Injetora 0$numInjetora</td>";
	else 
		echo "<td>Injetora $numInjetora</td>";
	echo '<td>' . transformaTempo ( $tempoRun ) . '</td>';
	echo '<td>' . transformaTempo ( $tempoSetup ) . '</td>';
	echo '<td>' . transformaTempo ( $tempoStop ) . '</td>';
	echo '<td>' . transformaTempo ( $tempoDesligado ) . '</td>';
	echo "<td>$porcentagemRun %</td>";
	echo "<td>$porcentagemSetup %</td>";
	echo "<td>$porcentagemStop %</td>";
	echo "<td>$porcentagemDesligado %</td>";
	echo '<td>' . transformaTempo ( $tempoTotal ) . '</td>';
	echo "<td> $porcentagemTotal %</td>";
	echo "</tr>";
}

// funcao para transformar tempo em segundos para HH:mm:ss
// Obs: funcao tem um limite maximo de 1 dia (86400 segundos)
function transformaTempo($tempo) {
	return gmdate ( "H:i:s", $tempo );
}

function calculaTempo($primeiraData, $primeiraHora, $ultimaData, $ultimaHora) {
	$primeiraData = str_replace ( '/', '-', $primeiraData );
	$ultimaData = str_replace ( '/', '-', $ultimaData );

	$dataFormatadaP = substr ( $primeiraData, 6, 4 ) . "-" . substr ( $primeiraData, 3, 2 ) . "-" . substr ( $primeiraData, 0, 2 );
	$dataFormatadaU = substr ( $ultimaData, 6, 4 ) . "-" . substr ( $ultimaData, 3, 2 ) . "-" . substr ( $ultimaData, 0, 2 );

	$dataP = "$dataFormatadaP $primeiraHora";
	$dataU = "$dataFormatadaU $ultimaHora";

	$unix_dataP = strtotime ( $dataP );
	$unix_dataU = strtotime ( $dataU );

	$nSegundos = ($unix_dataU - $unix_dataP);

	return $nSegundos;
}

function calculaPorcentagem($tempoEvento, $tempoTotal) {
	$porcentagem = round ( ($tempoEvento / $tempoTotal), 4 );
	$porcentagem = $porcentagem * 100;
	return $porcentagem;
}

function intervaloTotalArquivo(){
	$f = fopen ( 'arquivos/Dados_prado.csv', 'r' );
	if ($f) {
		$cabecalho = fgetcsv ( $f, 0, $delimitador, $cerca );
		$primeiraLinha = fgetcsv ( $f, 0, $delimitador, $cerca );
		$primeiroRegistro = array_combine ( $cabecalho, $primeiraLinha );
		$primeiraData = $primeiroRegistro ['DATE'];
		$primeiraHora = $primeiroRegistro ['TIME'];
		echo "<br/>Primeira atualização do arquivo: " . $primeiraData . " " . $primeiraHora;
	
		while ( ! feof ( $f ) ) {
			$ultimaData = $ultimoRegistro ['DATE'];
			$ultimaHora = $ultimoRegistro ['TIME'];
			$ultimaLinha = fgetcsv ( $f, 0, $delimitador, $cerca );
			$ultimoRegistro = array_combine ( $cabecalho, $ultimaLinha );
		}
		echo "<br/>Ultima&nbsp&nbsp atualização&nbsp do&nbsp arquivo: " . $ultimaData . ' ' . $ultimaHora;
		$tempoTotal = calculaTempo ( $primeiraData, $primeiraHora, $ultimaData, $ultimaHora );
	}
	fclose ( $f );
	return $tempoTotal;
}

function imprimeCabecalho(){
	echo "<table class='table'>";
	echo "<tr>";
	echo "<th>INJETORA</th>";
	echo "<th>Tempo Run</th>";
	echo "<th>Tempo Setup</th>";
	echo "<th>Tempo Stop</th>";
	echo "<th>Tempo Desligado</th>";
	echo "<th>% Run</th>";
	echo "<th>% Setup</th>";
	echo "<th>% Stop</th>";
	echo "<th>% Desligado</th>";
	echo "<th>Tempo Total</th>";
	echo "<th>% Total</th>";
	echo "</tr>";
}

function diferencatempo($data,$hora,$hora2){

	$data = str_replace ( '/', '-', $data );
	$dataFormatada = substr ( $data, 6, 4 ) . "-" . substr ( $data, 3, 2 ) . "-" . substr ( $data, 0, 2 );
	if (isset ( $hora2 )) {
	
		$data1 = "$dataFormatada $hora2";
		$data2 = "$dataFormatada $hora";
	
		$unix_data1 = strtotime ( $data1 );
		$unix_data2 = strtotime ( $data2 );
	
		$nSegundos = ($unix_data2 - $unix_data1);
	}
	$tempoAcumulado += $nSegundos;
	return $tempoAcumulado;
}

$f = fopen ( 'arquivos/Dados_prado.csv', 'r' );
if ($f) {
	$cabecalho = fgetcsv ( $f, 0, $delimitador, $cerca );
	$primeiraLinha = fgetcsv ( $f, 0, $delimitador, $cerca );
	$primeiroRegistro = array_combine ( $cabecalho, $primeiraLinha );
	$primeiraData = $primeiroRegistro ['DATE'];
	$primeiraHora = $primeiroRegistro ['TIME'];
	echo "<br/>Primeira atualização do arquivo: " . $primeiraData . " " . $primeiraHora;
	
	while ( ! feof ( $f ) ) {
		$ultimaData = $ultimoRegistro ['DATE'];
		$ultimaHora = $ultimoRegistro ['TIME'];
		$ultimaLinha = fgetcsv ( $f, 0, $delimitador, $cerca );
		$ultimoRegistro = array_combine ( $cabecalho, $ultimaLinha );
	}
	echo "<br/>Ultima&nbsp&nbsp atualização&nbsp do&nbsp arquivo: " . $ultimaData . ' ' . $ultimaHora;
	$tempoTotal = calculaTempo ( $primeiraData, $primeiraHora, $ultimaData, $ultimaHora );
}


imprimeCabecalho();

$f = fopen ( 'arquivos/Dados_prado.csv', 'r' );
if ($f) {
	
	$cabecalho = fgetcsv ( $f, 0, $delimitador, $cerca );
	
	while ( ! feof ( $f ) ) {
		
		$linha = fgetcsv ( $f, 0, $delimitador, $cerca );
		$registro = array_combine ( $cabecalho, $linha );
		
		for($i = 1; $i <= $quantInjetoras; $i ++) {
			if ($i < 10) {
				$numInjetora = '0' . $i;
			} else {
				$numInjetora = $i;
			}
			// Recebe data e hora de cada linha
			$data = $registro ['DATE'];
			$hora = $registro ['TIME'];
				
			// Recebe os valores dos 2 bits de cada injetora
			$bit0Inj2 = $registro ['INJET' . $numInjetora . '_0'];
			$bit1Inj2 = $registro ['INJET' . $numInjetora . '_1'];
			
			$eventoAnt[$i] = $evento[$i];
			$evento[$i] = retornaEvento ( $bit0Inj2, $bit1Inj2 );
			
			$tempoAcumulado = diferencatempo($data,$hora,$hora2);
					
			if ($eventoAnt[$i] == "DES") {
				$tempoDesligado[$i] += $tempoAcumulado;
				$tempoAcumulado = 0;
			} else if ($eventoAnt[$i] == "SETUP") {
				$tempoSetup[$i] += $tempoAcumulado;
				$tempoAcumulado = 0;
			} else if ($eventoAnt[$i] == "STOP") {
				$tempoStop[$i] += $tempoAcumulado;
				$tempoAcumulado = 0;
			} else if ($eventoAnt[$i] == "RUN") {
				$tempoRun[$i] += $tempoAcumulado;
				$tempoAcumulado = 0;
			}	
					
		}

		$hora2 = $hora;
	}
	for($j = 1; $j <= $quantInjetoras; $j ++) {
		
		$runAcumulado += $tempoRun[$j];
		$setupAcumulado += $tempoSetup[$j];
		$stopAcumulado += $tempoStop[$j];
		$desligadoAcumulado += $tempoDesligado[$j];
		
		$porcentagemDesligado[$j] = calculaPorcentagem ( $tempoDesligado[$j], $tempoTotal );
		$porcentagemSetup[$j] = calculaPorcentagem ( $tempoSetup[$j], $tempoTotal );
		$porcentagemStop[$j] = calculaPorcentagem ( $tempoStop[$j], $tempoTotal );
		$porcentagemRun[$j] = calculaPorcentagem ( $tempoRun[$j], $tempoTotal );
		
		$porDesAcumulado += $porcentagemDesligado[$j];
		$porRunAcumulado += $porcentagemRun[$j];
		$porStopAcumulado += $porcentagemStop[$j];
		$porSetupAcumulado += $porcentagemSetup[$j];
		
		$tempoTotalAcumulado += $tempoTotal;
		$porTotalAcumulado += $porcentagemTotal;
		
		imprimeEventos ( $j, $tempoDesligado[$j], $tempoRun[$j], $tempoRun[$j], $tempoSetup[$j], $tempoStop[$j], $porcentagemDesligado[$j], $porcentagemSetup[$j], $porcentagemStop[$j], $porcentagemRun[$j], $tempoTotal, $porcentagemTotal );
	}
	fclose ( $f );
}

echo "<tr>";
echo "<th>TOTAL</th>";
echo '<th>' . transformaTempo ( $runAcumulado ) . '</th>';
echo '<th>' . transformaTempo ( $setupAcumulado ) . '</th>';
echo '<th>' . transformaTempo ( $stopAcumulado ) . '</th>';
echo '<th>' . transformaTempo ( $desligadoAcumulado ) . '</th>';
echo "<th>$porRunAcumulado %</th>";
echo "<th>$porSetupAcumulado %</th>";
echo "<th>$porStopAcumulado %</th>";
echo "<th>$porDesAcumulado %</th>";
echo '<th>' . transformaTempo ( $tempoTotalAcumulado ) . '</th>';
echo "<th>$porTotalAcumulado %</th>";
echo "</tr>";

echo "</table>";

echo "<table class='table'>";
echo "<tr><td>Tempo total de Produção: " . transformaTempo ( $runAcumulado );
echo "<br>% Total de Produção: " . calculaPorcentagem ( $porRunAcumulado, $porTotalAcumulado ) . "%</td>";
echo "<td>Tempo total de Setup: " . transformaTempo ( $setupAcumulado );
echo "<br>% Total de Setup: " . calculaPorcentagem ( $porSetupAcumulado, $porTotalAcumulado ) . "%</td>";
echo "<td>Tempo total de Stop: " . transformaTempo ( $stopAcumulado );
echo "<br>% Total de Stop: " . calculaPorcentagem ( $porStopAcumulado, $porTotalAcumulado ) . "%</td>";
echo "<td>Tempo total Desligado: " . transformaTempo ( $desligadoAcumulado );
echo "<br>% Total Desligado: " . calculaPorcentagem ( $porDesAcumulado, $porTotalAcumulado ) . "%</tr></td>";
echo "</table>";

echo "</div>";

?>