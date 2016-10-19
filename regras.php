<?php
include 'connection.php';

$queryBolao = $con->prepare("select id, descricao from Bolao where ativo = true");
$queryBolao->execute();   
$dadosBolao = $queryBolao->fetch(PDO::FETCH_ASSOC);

$bolao = isset($dadosBolao['id']) && ($dadosBolao['id'] != '') ? $dadosBolao['id'] : 0;
$title = isset($dadosBolao['descricao']) && ($dadosBolao['descricao'] != '') ? $dadosBolao['descricao'] : utf8_decode('Fumbol�o');
        		
?>
<!DOCTYPE html>
<html>

<?php include 'templates/header.php'; ?>
	
<body class="home blog">

	<div id="pagewrap">
		
		<?php include 'templates/top.php'; ?>

		<div id="body" class="clearfix"> 
			
			<!-- layout -->
			<div id="layout" class="pagewidth clearfix sidebar1">	
				
				<div id="content">				
<p>
<h2>Inscri��o</h2>

Os participante dever�o se inscrever at� um dia antes de come�ar a temporada regular.
</p>
<p>
<h2>Aposta</h2>

A cada rodada, os participantes devem apostar no time que vai PERDER.
No momento da aposta, o participante poder� escolher o b�nus da partida RR, AH ou OJ.
O participante deve apostar obrigatoriamente no seu time. Se n�o apostar no seu time, vai perder 5 pontos independente do resultado da partida.
</p>
<p>
<h2>Pontua��o as partidas</h2>

O participante ganha 1 ponto se o time que ele apostou perder.
O participante perde 1 ponto se o time que ele apostou ganhar.
O participante perde 5 pontos se n�o apostar no seu time (independente do resultado).
O participante que n�o apostar, perde 1 ponto por partida n�o apostada.

As apostas poder�o ser efetuadas rodada a rodada, at� uma hora antes do in�cio de cada partida.
</p>
<p>
<h2>B�nus</h2>

<h6>Ray Rice "RR"</h6>
Se o time que o participante apostou perder de uma diferen�a de 20 a 29 pontos, o participante ganha 3 pontos.
Se o time que o participante apostou ganhar de uma diferen�a de 20 a 29 pontos, o participante perde 3 pontos.

<h6>Aaron Hernandez "AH"</h6>
Se o time que o participante apostou perder de uma diferen�a de 30 a 39 pontos, o participante ganha 5 pontos.
Se o time que o participante apostou ganhar de uma diferen�a de 30 a 39 pontos, o participante perde 5 pontos.

<h6>O. J. Simpson "OJ"</h6>
Se o time que o participante apostou perder de uma diferen�a de 40 pontos ou mais, o participante ganha 7 pontos.
Se o time que o participante apostou ganhar de uma diferen�a de 40 pontos ou mais, o participante perde 7 pontos.
</p>
<p>
<h2>Ranking e vencedor</h2>

Os participantes ser�o ranqueados e ganha aquele que ao final da temporada regular tiver mais pontos.
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