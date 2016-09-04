<?php
include 'connection.php';

$queryBolao = $con->query("select id, descricao from Bolao where ativo = true");
$dadosBolao = $queryBolao->fetchAll( PDO::FETCH_ASSOC );

$bolao = isset($dadosBolao['id']) && ($dadosBolao['id'] != '') ? $dadosBolao['id'] : 0;
$title = isset($dadosBolao['descricao']) && ($dadosBolao['descricao'] != '') ? utf8_decode($dadosBolao['descricao']) : 'Fumbolão';
        		
?>
<!DOCTYPE html>
<html>

<head>

	<title>Fumbolão</title>

	<meta http-equiv="content-type" content="text/html; charset=iso-8859-1">		

	<!-- header -->
	<link rel="stylesheet" id="themify-styles-css" href="css/style.css" type="text/css" media="all">
	<link rel="stylesheet" id="themify-media-queries-css" href="css/media-queries.css" type="text/css" media="all">

	<!-- media-queries.js -->
	<!--[if lt IE 9]>
		<script src="http://css3-mediaqueries-js.googlecode.com/svn/trunk/css3-mediaqueries.js"></script>
	<![endif]-->

	<!-- html5.js -->
	<!--[if lt IE 9]>
		<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
	<![endif]-->
	<meta name="viewport" content="width=100%, initial-scale=1, maximum-scale=1, minimum-scale=1, user-scalable=no">	
	<style type="text/css">.recentcomments a{display:inline !important;padding:0 !important;margin:0 !important;}</style>

	<script src="js/fumbolao.js" type="text/javascript"></script>
	
</head>
	
<body class="home blog">

	<div id="pagewrap">
		
		<?php include 'templates/top.php'; ?>

		<div id="body" class="clearfix"> 
			
			<!-- layout -->
			<div id="layout" class="pagewidth clearfix sidebar1">	
				
				<div id="content">				
<p>
<h2>Inscrição</h2>

Os participante deverão se inscrever até um dia antes de começar a temporada regular.
</p>
<p>
<h2>Aposta</h2>

A cada rodada, os participantes devem apostar no time que vai PERDER.
No momento da aposta, o participante poderá escolher o bônus da partida RR, AH ou OJ.
O participante deve apostar obrigatoriamente no seu time. Se não apostar no seu time, vai perder 5 pontos independente do resultado da partida.
</p>
<p>
<h2>Pontuação as partidas</h2>

O participante ganha 1 ponto se o time que ele apostou perder.
O participante perde 1 ponto se o time que ele apostou ganhar.
O participante perde 5 pontos se não apostar no seu time (independente do resultado).
O participante que não apostar, perde 1 ponto por partida não apostada.

As apostas poderão ser efetuadas rodada a rodada, até uma hora antes do início de cada partida.
</p>
<p>
<h2>Bônus</h2>

<h6>Ray Rice "RR"</h6>
Se o time que o participante apostou perder de uma diferença de 20 a 29 pontos, o participante ganha 3 pontos.
Se o time que o participante apostou ganhar de uma diferença de 20 a 29 pontos, o participante perde 3 pontos.

<h6>Aaron Hernandez "AH"</h6>
Se o time que o participante apostou perder de uma diferença de 30 a 39 pontos, o participante ganha 5 pontos.
Se o time que o participante apostou ganhar de uma diferença de 30 a 39 pontos, o participante perde 5 pontos.

<h6>O. J. Simpson "OJ"</h6>
Se o time que o participante apostou perder de uma diferença de 40 pontos ou mais, o participante ganha 7 pontos.
Se o time que o participante apostou ganhar de uma diferença de 40 pontos ou mais, o participante perde 7 pontos.
</p>
<p>
<h2>Ranking e vencedor</h2>

Os participantes serão ranqueados e ganha aquele que ao final da temporada regular tiver mais pontos.
</p>				
									
				</div>
				<!-- /#content -->			
				
			</div>
			<!-- /#layout -->		
			
		</div>
		<!-- /body -->	
		
		<?php include 'templates/footer.php'; ?>
		
	</div>
    <!-- /#pagewrap -->
	
</body>
<!-- /body -->		

</html>	