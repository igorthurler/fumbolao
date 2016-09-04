<?php
include 'connection.php';

$bolao = $GET['bolao'];

$query = $con->query("select descricao from Bolao where id = {$bolao}");

$dados = $query->fetch_array();
            
// Retornar dados do ranking 
$queryRanking = $con->query("select * from vw_ranking
where bolao = {$bolao}
order by total desc,bonus desc, nome_participante");
                              
?>
<!DOCTYPE html>
<html>
    <?php include 'templates/header.php'; ?>
    <body>
        <div id="BoxForm">
                <h1><?php echo $dados['descricao'] ?></h1>
		  <fieldset>
			<legend><span>Ranking</span></legend>
			<ul>
			  <?php
				if ($queryRanking != null) {
					while ($ranking = $queryRanking->fetch_array()) {
						echo "<li><label>{$ranking['nome_participante']} ({$ranking['total']} pts)</label></li>";
					}
				}
			  ?>      
			</ul>
		  </fieldset>
        </div>

    </body>
</html>	