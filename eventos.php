

<div class="row-fluid">
	<div class="span12">
		<div class="navbar">
			<div class="navbar-inner">
				<div class="span12">
					<div class="container">
					<br />					
						<?php

$sql_consulta_injetoras = mysql_query("	SELECT

										E.idEvento,
										E.descricaoInjetora,
										E.evento,
										E.horaInicial,
										E.horaFinal,
										E.tempoEvento
										
										FROM Evento E
										
										ORDER BY idEvento DESC
										
										LIMIT 10000");


/*echo "<table class='table table-striped'>";
echo "<tr>";
echo "<th>Injetora</th>";
echo "<th>Evento</th>";
echo "<th>Hora Inicial</th>";
echo "<th>Hora Final</th>";
echo "<th>Tempo evento</th>";
echo "</tr>";*/

echo "<table id='example' class='display' cellspacing='0' width='100%'>";
echo "<thead>";
echo "<tr>";
echo "<th>Injetora</th>";
echo "<th>Evento</th>";
echo "<th>Hora Inicial</th>";
echo "<th>Hora Final</th>";
echo "<th>Tempo evento</th>";
echo "</tr>";
echo "</thead>";

echo "<tfoot>";
echo "<tr>";
echo "<th>Injetora</th>";
echo "<th>Evento</th>";
echo "<th>Hora Inicial</th>";
echo "<th>Hora Final</th>";
echo "<th>Tempo evento</th>";
echo "</tr>";
echo "</tfoot>";

echo "<tbody>";

while ($dados = mysql_fetch_array($sql_consulta_injetoras)) {

	$injetora = $dados["descricaoInjetora"];
	$evento = $dados["evento"];
	$horaInicial = $dados["horaInicial"];
	$horaFinal = $dados["horaFinal"];
	$tempoEvento = $dados["tempoEvento"];


	echo "<tr>";
	echo "<td>$injetora</td>";
	echo "<td>$evento</td>";
	echo "<td>$horaInicial</td>";
	echo "<td>$horaFinal</td>";
	echo "<td>$tempoEvento seg</td>";
	echo "</tr>";
}

echo "</tbody>";

echo "</table>";

?>
						
						
					</div>
				</div>
			</div>
		</div>
	</div>
</div>