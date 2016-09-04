<aside id="sidebar">
	<div id="themify-feature-posts-3" class="widget feature-posts">
		<h4 class="widgettitle">Ranking</h4>
		<ul class="feature-posts-list">
		
			<?php		
				// Retornar dados do ranking 		
				$queryRanking = $con->prepare("select * from vw_ranking
												where bolao = :bolao
												limit 5");
				$queryRanking->bindParam( ':bolao', $bolao );
				$queryRanking->execute();			
			
				if ($queryRanking != null) {
					while ($ranking = $queryRanking->fetchAll( PDO::FETCH_ASSOC )) {
					  if ($ranking['total'] <> 0) 
						echo "<li><label>{$ranking['nome_participante']} ({$ranking['total']} pts)</label></li>";
					}
				}
			?>     				
			
		</ul>
		<a href="ranking.php">ver tudo</a>	
	</div>				
</aside>
<!-- /#sidebar -->