<?php 

$delimitador = ';';
$cerca = '"';

// Abrir arquivo para leitura
$f = fopen('arquivos/Dados_prado.csv', 'r');
echo "<br/>Ultima atualização do arquivo: " .date("d/m/Y H:i:s", filemtime("arquivos/Dados_prado.csv"));
if ($f) {

	// Ler cabecalho do arquivo
	$cabecalho = fgetcsv($f, 0, $delimitador, $cerca);

	echo "<table class='table'>";

	$tempoAcumulado = 0;;

	// Enquanto nao terminar o arquivo
	while (!feof($f)) {

		// Ler uma linha do arquivo
		$linha = fgetcsv($f, 0, $delimitador, $cerca);
		if (!$linha) {
			continue;
		}

		// Montar registro com valores indexados pelo cabecalho
		$registro = array_combine($cabecalho, $linha);

		echo "<tr>";

		$data = $registro['DATE'];
		$hora = $registro['TIME'];

		/*if (isset($hora2)) {
		 $tempoAcumulado += ($hora2 - $hora);
		}*/

		$bit0Inj1 = $registro['INJET01_0'];
		$bit1Inj1 = $registro['INJET01_1'];

		if ($bit0Inj1 == "-1" && $bit1Inj1 == "-1") {
			$evento1 = "DES";
			$corBotao1 = "danger";
		} else if ($bit0Inj1 == "0" && $bit1Inj1 == "1") {
			$evento1 = "CicA";
			$corBotao1 = "default";
		} else if ($bit0Inj1 == "1" && $bit1Inj1 == "0") {
			$evento1 = "CicF";
			$corBotao1 = "success";
		} else if ($bit0Inj1 == "0" && $bit1Inj1 == "0") {
			$evento1 = "STOP";
			$corBotao1 = "danger";
		} else if ($bit0Inj1 == "1" && $bit1Inj1 == "1") {
			$evento1 = "SETUP";
			$corBotao1 = "primary";
		}

		$bit0Inj2 = $registro['INJET03_0'];
		$bit1Inj2 = $registro['INJET03_1'];

		if ($bit0Inj2 == "-1" && $bit1Inj2 == "-1") {
			$evento2 = "DES";
			$corBotao2 = "danger";
		} else if ($bit0Inj2 == "0" && $bit1Inj2 == "1") {
			$evento2 = "CicF";
			$corBotao2 = "success";
		} else if ($bit0Inj2 == "1" && $bit1Inj2 == "0") {
			$evento2 = "CicA";
			$corBotao2 = "default";
		} else if ($bit0Inj2 == "0" && $bit1Inj2 == "0") {
			$evento2 = "STOP";
			$corBotao2 = "danger";
		} else if ($bit0Inj2 == "1" && $bit1Inj2 == "1") {
			$evento2 = "SETUP";
			$corBotao2 = "primary";
		}



		// Obtendo o nome
		echo "<td>$data</td>";
		echo "<td>$hora</td>";

		$data = str_replace('/', '-', $data);
		$dataFormatada = substr($data, 6, 4)."-".substr($data, 3, 2)."-".substr($data, 0, 2);

		if (isset($hora2)) {

			$data1 = "$dataFormatada $hora2";
			$data2 = "$dataFormatada $hora";

			$unix_data1 = strtotime($data1);
			$unix_data2 = strtotime($data2);

			$nHoras   = ($unix_data2 - $unix_data1) / 3600;
			$nMinutos = (($unix_data2 - $unix_data1) % 3600) / 60;
			$nSegundos = ($unix_data2 - $unix_data1);
		}

		//echo "<td>$dataFormatada  $nHoras  $nMinutos $nSegundos</td>";
		$tempoAcumulado += $nSegundos;
		echo "<td>$nSegundos</td>";

		if ($eventoTEMP != $evento2) {
			$tempoAcumulado = 0;
		}

		$hora2 = $hora;
		$eventoTEMP = $evento2;

		//echo "<td><button type='button' class='btn btn-$corBotao1 btn-xs'>$bit0Inj1 $bit1Inj1 $evento1</button></td>";
		echo "<td><button type='button' class='btn btn-$corBotao2 btn-xs'>$bit0Inj2 $bit1Inj2 $evento2</button></td>";

		echo "<td>$tempoAcumulado</td>";




		echo "</tr>";

	}

	echo "</table>";

	fclose($f);
}



?>



<html>
  <head>
    <script type="text/javascript" src="https://www.google.com/jsapi"></script>
    <script type="text/javascript">
      google.load("visualization", "1", {packages:["corechart"]});
      google.setOnLoadCallback(drawChart);
      function drawChart() {
        var data = google.visualization.arrayToDataTable([
          ['Director (Year)',  'Rotten Tomatoes', 'IMDB'],
          ['Alfred Hitchcock (1935)', 8.4,         7.9],
          ['Ralph Thomas (1959)',     6.9,         6.5],
          ['Don Sharp (1978)',        6.5,         6.4],
          ['James Hawes (2008)',      4.4,         6.2]
        ]);

        var options = {
          title: 'The decline of \'The 39 Steps\'',
          vAxis: {title: 'Accumulated Rating'},
          isStacked: true
        };

        var chart = new google.visualization.SteppedAreaChart(document.getElementById('chart_div'));

        chart.draw(data, options);
      }
    </script>
  </head>
  <body>
    <div id="chart_div" style="width: 900px; height: 500px;"></div>
  </body>
</html>