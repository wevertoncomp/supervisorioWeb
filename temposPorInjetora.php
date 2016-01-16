<html>
<form action='?pg=temposPorInjetora' method="POST">

	<span><b>Informe qual INJETORA deseja visualizar:</b></span><br /> <select
		name='estado'>

		<option value='00'></option>
		<option value='01'>Injetora 01</option>
		<option value='02'>Injetora 02</option>
		<option value='03'>Injetora 03</option>
		<option value='04'>Injetora 04</option>
		<option value='05'>Injetora 05</option>
		<option value='06'>Injetora 06</option>
		<option value='07'>Injetora 07</option>
		<option value='08'>Injetora 08</option>
		<option value='09'>Injetora 09</option>
		<option value='10'>Injetora 10</option>
		<option value='11'>Injetora 11</option>
		<option value='12'>Injetora 12</option>
		<option value='13'>Injetora 13</option>
		<option value='14'>Injetora 14</option>
		<option value='15'>Injetora 15</option>
		<option value='16'>Injetora 16</option>
		<option value='17'>Injetora 17</option>
		<option value='18'>Injetora 18</option>
		<option value='19'>Injetora 19</option>
		<option value='20'>Injetora 20</option>
		<option value='21'>Injetora 21</option>
		<option value='22'>Injetora 22</option>
		<option value='23'>Injetora 23</option>
		<option value='24'>Injetora 24</option>

	</select><br /> <input type='submit' name='buscar' value='Buscar'>
</form>
</html>

<?php
$conn->open ( $connStr );

// Recebe o numero da Injetora passado pela pagina principal
$numInjetora = $_POST ['estado'];
// $tempoDesligado = 0;
// $tempoRun = 0;
// $tempoSetup = 0;
// $tempoStop = 0;
// $numInjetora = '01';

// funcao para retornar o evento de acordo com os 2 bits recebidos
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
function imprimeEventos($tempoDesligado, $tempoRun, $tempoRun, $tempoSetup, $tempoStop, $porcentagemDesligado,$porcentagemSetup,$porcentagemStop,$porcentagemRun,$quantCiclos) {
	if (isset ( $tempoDesligado )) {
		echo "<tr><td><button type='button' class='btn btn-danger btn-xs'>Deslig: </button></td>";
		echo "<td>$tempoDesligado segundos</td>";
		echo '<td>' . transformaTempo ( $tempoDesligado ) . '</td>';
		echo "<td>-</td>";
		echo "<td>$porcentagemDesligado %</td></tr>";
	} else {
		echo "<tr><td><button type='button' class='btn btn-danger btn-xs'>Deslig: </button></td>";
		echo "<td>-</td>";
		echo "<td>-</td>";
		echo "<td>-</td>";
		echo "<td> 0.00% </td></tr>";
	}
	
	if (isset ( $tempoSetup )) {
		echo "<tr><td><button type='button' class='btn btn-primary btn-xs'>Setup: </button></td>";
		echo "<td>$tempoSetup segundos</td>";
		echo '<td>' . transformaTempo ( $tempoSetup ) . '</td>';
		echo "<td>-</td>";
		echo "<td>$porcentagemSetup %</td></tr>";
	} else {
		echo "<tr><td><button type='button' class='btn btn-primary btn-xs'>Setup: </button></td>";
		echo "<td>-</td>";
		echo "<td>-</td>";
		echo "<td>-</td>";
		echo "<td> 0.00% </td></tr>";
	}
	
	if (isset ( $tempoStop )) {
		echo "<tr><td><button type='button' class='btn btn-warning btn-xs'>Stop:   </button></td>";
		echo "<td>$tempoStop segundos</td>";
		echo '<td>' . transformaTempo ( $tempoStop ) . '</td>';
		echo "<td>-</td>";
		echo "<td>$porcentagemStop %</td></tr>";
	} else {
		echo "<tr><td><button type='button' class='btn btn-warning btn-xs'>Stop: </button></td>";
		echo "<td>-</td>";
		echo "<td>-</td>";
		echo "<td>-</td>";
		echo "<td> 0.00% </td></tr>";
	}
	
	if (isset ( $tempoRun )) {
		echo "<tr><td><button type='button' class='btn btn-success btn-xs'>Run:    </button></td>";
		echo "<td>$tempoRun segundos</td>";
		echo '<td>' . transformaTempo ( $tempoRun ) . '</td>';
		echo "<td>$quantCiclos Ciclos</td>";
		echo "<td>$porcentagemRun %</td></tr>";
	} else {
		echo "<tr><td><button type='button' class='btn btn-success btn-xs'>Run: </button></td>";
		echo "<td>-</td>";
		echo "<td>-</td>";
		echo "<td>-</td>";
		echo "<td> 0.00% </td></tr>";
	}
}

// funcao para transformar tempo em segundos para HH:mm:ss
// Obs: funcao tem um limite maximo de 1 dia (86400 segundos)
function transformaTempo($tempo) {
	return gmdate ( "H:i:s", $tempo );
}

function calculaTempo($primeiraData, $primeiraHora, $ultimaData, $ultimaHora){
	
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

function calculaPorcentagem($tempoEvento,$tempoTotal){
	$porcentagem = round(($tempoEvento/$tempoTotal),4);
	$porcentagem = $porcentagem * 100;
	return $porcentagem;
}

function contaCiclos($bit0EventoAnt, $bit1EventoAnt, $bit0Inj2, $bit1Inj2, $quantCiclos){
	
	//fazer funcao para contar os ciclos
	if(($bit0EventoAnt == "0" && $bit1EventoAnt == "1") && ($bit0Inj2 == "1" && $bit1Inj2=="0") || ($bit0EventoAnt == "1" && $bit1EventoAnt == "0") && ($bit0Inj2=="0" && $bit1Inj2=="1"))
		$quantCiclos += 1;
	return $quantCiclos;	
	
}



if ($numInjetora == '00')
	break;


if (isset ( $_POST ['buscar'] )) {
	
	// Exemplo de scrip para exibir os nomes obtidos no arquivo CSV de exemplo
	$delimitador = ';';
	$cerca = '"';
	
	// Abrir arquivo para obter a data e hora do primeiro e ultimo dado
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
		$tempoTotal = calculaTempo($primeiraData, $primeiraHora, $ultimaData, $ultimaHora);
		echo "<br><b><u>Tempo total do arquivo</u>: </b>". $tempoTotal. " segundos  / " . transformaTempo($tempoTotal);
	}
	fclose ( $f );
	
	// Parte principal
	$f = fopen ( 'arquivos/Dados_prado.csv', 'r' );
	if ($f) {
		
		// Escreve o cabecalho
		echo "<table class='table'>";
		echo "<h4> INJETORA $numInjetora </h4>";
		echo "<tr>";
		echo "<th>Status</th>";
		echo "<th>Tempo Evento (s)</th>";
		echo "<th>Tempo Evento (HH:mm:ss)</th>";
		echo "<th>Número de Ciclos</th>";
		echo "<th>Porcentagem</th>";
		echo "</tr>";
		
		$cabecalho = fgetcsv ( $f, 0, $delimitador, $cerca );
		
		// Enquanto nao terminar o arquivo
		while ( ! feof ( $f ) ) {
			
			// Ler uma linha do arquivo
			$linha = fgetcsv ( $f, 0, $delimitador, $cerca );
			
			// Montar registro com valores indexados pelo cabecalho
			$registro = array_combine ( $cabecalho, $linha );
			
			echo "<tr>";
			
			// Recebe data e hora de cada linha
			$data = $registro ['DATE'];
			$hora = $registro ['TIME'];
			
			$bit0EventoAnt = $bit0Inj2;
			$bit1EventoAnt = $bit1Inj2;
			
			
			// Recebe os valores dos 2 bits de cada injetora
			$bit0Inj2 = $registro ['INJET' . $numInjetora . '_0'];
			$bit1Inj2 = $registro ['INJET' . $numInjetora . '_1'];		
				
			$quantCiclos = contaCiclos($bit0EventoAnt, $bit1EventoAnt, $bit0Inj2, $bit1Inj2, $quantCiclos);
			
			// Evento Anterior recebe o evento atual
			$eventoAnt = $evento;
			$evento = retornaEvento ( $bit0Inj2, $bit1Inj2 );
			
			// Funcao para obter a diferenca entre o tempo da linha atual e da anterior
			$data = str_replace ( '/', '-', $data );
			$dataFormatada = substr ( $data, 6, 4 ) . "-" . substr ( $data, 3, 2 ) . "-" . substr ( $data, 0, 2 );
			if (isset ( $hora2 )) {
				
				$data1 = "$dataFormatada $hora2";
				$data2 = "$dataFormatada $hora";
				
				$unix_data1 = strtotime ( $data1 );
				$unix_data2 = strtotime ( $data2 );
				
				$nHoras = ($unix_data2 - $unix_data1) / 3600;
				$nMinutos = (($unix_data2 - $unix_data1) % 3600) / 60;
				$nSegundos = ($unix_data2 - $unix_data1);
			}
			$tempoAcumulado += $nSegundos;
			
			// Armazena a diferenca do tempo no respectivo estado
			if ($eventoAnt == "DES") {
				$tempoDesligado += $tempoAcumulado;
				$tempoAcumulado = 0;
			} else if ($eventoAnt == "SETUP") {
				$tempoSetup += $tempoAcumulado;
				$tempoAcumulado = 0;
			} else if ($eventoAnt == "STOP") {
				$tempoStop += $tempoAcumulado;
				$tempoAcumulado = 0;
			} else if ($eventoAnt == "RUN") {
				$tempoRun += $tempoAcumulado;
				$tempoAcumulado = 0;
			}
			
			$hora2 = $hora;
			echo "</tr>";
		}
	}
	
	$porcentagemDesligado = calculaPorcentagem($tempoDesligado, $tempoTotal);
	$porcentagemSetup = calculaPorcentagem($tempoSetup, $tempoTotal);
	$porcentagemStop = calculaPorcentagem($tempoStop, $tempoTotal);
	$porcentagemRun = calculaPorcentagem($tempoRun, $tempoTotal);	
	
	$quantCiclos = floor($quantCiclos/2);
	
	imprimeEventos ( $tempoDesligado, $tempoRun, $tempoRun, $tempoSetup, $tempoStop,$porcentagemDesligado,$porcentagemSetup,$porcentagemStop,$porcentagemRun,$quantCiclos);

	echo "</table>";
	fclose ( $f );
	
	$conn->Close ();
$conn = null;

echo "</div>";
}
?>