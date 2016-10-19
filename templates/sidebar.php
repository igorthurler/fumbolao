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
foreach($queryRanking->fetchAll( PDO::FETCH_ASSOC ) as $ranking) {
					  if ($ranking['total'] <> 0) 
						echo "<li><label>{$ranking['nome_participante']} ({$ranking['total']} pts)</label></li>";
					}
				}
			?>     				
			
		</ul>
		<a href="ranking">ver tudo</a>	
	</div>	
		

	<div id="themify-feature-posts-3" class="widget feature-posts">
		<h4 class="widgettitle">Desonestos</h4>
		<ul class="feature-posts-list">
		
			<?php	
				// Retornar dados dos desonestos
				$queryDesonestos = $con->prepare("select rrp.nome_participante, rrp.rodada 
				                                    from vw_resultados_rodada_participante rrp 
												   where rrp.bolao = :bolao
												     and rrp.desonesto = 'S'
and rrp.rodada < :rodada 
												   order by rrp.nome_participante");
                $queryDesonestos->bindParam( ':bolao', $bolao );
                $queryDesonestos->bindParam( ':rodada', $rodada );
				$queryDesonestos->execute();			
			
				if ($queryDesonestos != null) {
					foreach($queryDesonestos->fetchAll( PDO::FETCH_ASSOC ) as $desonesto) {
						echo "<li><label>{$desonesto['nome_participante']} (Rodada {$desonesto['rodada']})</label></li>";
					}
				}
			?>     				
			
		</ul>
	</div>	
	
</aside>
<!-- /#sidebar -->