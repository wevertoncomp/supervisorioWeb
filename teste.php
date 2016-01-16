<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8"/>
    <title>Exemplo de gráfico</title>

    <script type="text/javascript" src="https://www.google.com/jsapi"></script>
    <script type="text/javascript" src="js/jquery.min.js"></script>

    <script type="text/javascript">
      google.load('visualization', '1.0', {'packages':['corechart']});
      google.setOnLoadCallback(function(){
        var json_text = $.ajax({url: "getDadosGrafico.php", dataType:"json", async: false}).responseText;
        var json = eval("(" + json_text + ")");
        var dados = new google.visualization.DataTable(json.dados);

        var chart = new google.visualization.PieChart(document.getElementById('area_grafico'));
        chart.draw(dados, json.config);
      });
    </script>
  </head>

  <body>
    <div id="area_grafico"></div>
  </body>
</html>