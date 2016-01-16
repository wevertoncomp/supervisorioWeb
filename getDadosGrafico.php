<?php

// Estrutura basica do grafico
$grafico = array(
    'dados' => array(
        'cols' => array(
            array('type' => 'string', 'label' => 'Evento'),
            array('type' => 'number', 'label' => 'Tempo')
        ),  
        'rows' => array()
    ),
    'config' => array(
        'title' => 'Eventos',
        'width' => 400,
        'height' => 300
    )
);

// Consultar dados no BD
$pdo = new PDO('mysql:host=192.168.117.137;dbname=supervisorio', 'root', '123456');
$sql = "SELECT
										E.evento,
										SUM(E.tempoEvento) AS tempoEvento
										
										FROM Evento E
										
										WHERE E.descricaoInjetora = 'INJETORA03'
										AND E.ts > '2015-01-01 00:00:00'
										AND E.ts BETWEEN '2015-09-22 00:00:00' AND '2015-09-22 23:59:59'
										
										GROUP BY E.evento";
$stmt = $pdo->query($sql);
while ($obj = $stmt->fetchObject()) {
    $grafico['dados']['rows'][] = array('c' => array(
        array('v' => $obj->evento),
        array('v' => (int)$obj->tempoEvento)
    ));
    echo "$obj->evento";
}

// Enviar dados na forma de JSON
header('Content-Type: application/json; charset=UTF-8');
echo json_encode($grafico);
exit(0);

?>