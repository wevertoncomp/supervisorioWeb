

<div class="row-fluid">
	<div class="span12">
		<div class="navbar">
			<div class="navbar-inner">
				<div class="span12">
					<div class="container">
					<br />					
						<?php

$sql_consulta_injetoras = mysql_query("		SELECT

										E.descricaoInjetora,
										SUM(E.tempoEvento) AS tempoEvento
										
										FROM Evento E
										
										WHERE E.ts BETWEEN '2015-09-30 00:00:00' AND '2015-09-30 23:59:59'

										GROUP BY E.descricaoInjetora

										ORDER BY E.descricaoInjetora");

while ($dados = mysql_fetch_array($sql_consulta_injetoras)) {

	$injetora = $dados["descricaoInjetora"];
	$tempoEventoTotal = $dados["tempoEvento"];


	//echo "<tr>";
	echo "<h4>$injetora</h4>";
	//echo "<td>$tempoEventoTotal seg</td>";
	//echo "</tr>";


$sql_consulta_eventos = mysql_query("SELECT

							       	E.evento,
							 		SUM(E.tempoEvento) AS tempoEvento,
							       (SUM(E.tempoEvento)/(SELECT SUM(E1.tempoEvento) FROM Evento E1 WHERE E1.descricaoInjetora = '$injetora'AND E1.ts BETWEEN '2015-09-30 00:00:00' AND '2015-09-30 23:59:59')) AS porcentagem
							
							
							 			FROM Evento E
							
							 			WHERE E.descricaoInjetora = '$injetora'
							 			AND E.ts BETWEEN '2015-09-30 00:00:00' AND '2015-09-30 23:59:59'
							
							 			GROUP BY E.evento
							
							 			ORDER BY E.evento");

echo "<table class='table'>";
echo "<thead>";
echo "<tr>";
echo "<th>Injetora</th>";
echo "<th>Tempo evento</th>";
echo "<th>Porcentagem</th>";
echo "</tr>";
echo "</thead>";

echo "<tbody>";
$dados2 = NULL;
while ($dados2 = mysql_fetch_array($sql_consulta_eventos)) {

	$evento = $dados2["evento"];
	$tempoEvento = $dados2["tempoEvento"];
	$porcentagem = $dados2["porcentagem"];


	echo "<tr>";
	echo "<td>$evento</td>";
	echo "<td>$tempoEvento seg</td>";
	echo "<td>$porcentagem %</td>";
	//echo "<td>".($tempoEvento/$tempoEventoTotal)." %</td>";
	echo "</tr>";
}
echo "</tbody>";

echo "</table>";
}

?>
						
					</div>
				</div>
			</div>
		</div>
	</div>
</div>