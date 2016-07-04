<aside id="sidebar">
	<div id="themify-feature-posts-3" class="widget feature-posts">
		<h4 class="widgettitle">Ranking</h4>
		<ul class="feature-posts-list">
		
			<?php		
				// Retornar dados do ranking 
				$queryRanking = $con->query("select * from vw_ranking
											  where bolao = {$bolao}
											  order by total desc,bonus desc, nome_participante
											  limit 5");			
			
				if ($queryRanking != null) {
					while ($ranking = $queryRanking->fetch_array()) {
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