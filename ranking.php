<?php
include 'connection.php';

$queryBolao = $con->prepare("select id, descricao from Bolao where ativo = true");
$queryBolao->execute();   
$dadosBolao = $queryBolao->fetch(PDO::FETCH_ASSOC);

$bolao = isset($dadosBolao['id']) && ($dadosBolao['id'] != '') ? $dadosBolao['id'] : 0;
$title = isset($dadosBolao['descricao']) && ($dadosBolao['descricao'] != '') ? $dadosBolao['descricao'] : 'Fumbol達o';

$query = $con->prepare("select descricao from Bolao where id = :bolao");
$query->bindParam( ':bolao', $bolao, PDO::PARAM_INT );
$query->execute();

$dados = $query->fetch(PDO::FETCH_ASSOC);
            
// Retornar dados do ranking 
$queryRanking = $con->prepare("select * from vw_ranking
where bolao = :bolao
order by total desc,bonus desc, nome_participante");
$queryRanking->bindParam( ':bolao', $bolao, PDO::PARAM_INT );
$queryRanking->execute();

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
					<!-- 
						Conteúdo aqui
					-->				
			  <?php
				if ($queryRanking != null) {
foreach($queryRanking->fetchAll( PDO::FETCH_ASSOC ) as $ranking) {
						echo "<li><label>{$ranking['nome_participante']} ({$ranking['total']} pts)</label></li>";
					}
				}
			  ?>  				
				</div>
				<!-- /#content -->			
				<?php /*include 'templates/sidebar.php';*/ ?>
				
				
			</div>
			<!-- /#layout -->		
			
		</div>
		<!-- /body -->	
		
		<?php include 'templates/footer.php'; ?>
		
	</div>
    <!-- /#pagewrap -->
	
</body>
</html>	
