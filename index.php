<?php
date_default_timezone_set('America/Sao_Paulo');

include 'connection.php';

$queryBolao = $con->prepare("select id, descricao from Bolao where ativo = true");
$queryBolao->execute();   
$dadosBolao = $queryBolao->fetch(PDO::FETCH_ASSOC);

$bolao = isset($dadosBolao['id']) && ($dadosBolao['id'] != '') ? $dadosBolao['id'] : 0;
$title = isset($dadosBolao['descricao']) && ($dadosBolao['descricao'] != '') ? $dadosBolao['descricao'] : 'Fumbolão';

//Buscar dados da rodada atual a partir das partidas  					   			   			   

$queryRodada = $con->prepare("select distinct rodada
                        from Partida
                       where bolao = :bolao
                         and finalizada = false
                       order by rodada
                       limit 1");
$queryRodada->bindParam( ':bolao', $bolao, PDO::PARAM_INT );
$queryRodada->execute();                      
$dadosRodada = $queryRodada->fetch(PDO::FETCH_ASSOC);

//--------------------------------------------------

//Retornar as partidas da rodada
	 
$queryPartidas = $con->prepare("select *, TIMESTAMPDIFF(minute,now(),data_limite_aposta) as diff_datas
                         from Partida
                        where bolao = :bolao
                          and rodada = :rodada
                        order by id");
$queryPartidas->bindParam( ':bolao', $bolao );
$queryPartidas->bindParam( ':rodada', $dadosRodada['rodada'] );
$queryPartidas->execute();       
              	
$partidas = $queryPartidas->fetchAll( PDO::FETCH_ASSOC );

//---------------------------------

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
					<form action="enviar_palpite.php?bolao=<?php echo $bolao?>&rodada=<?php echo $dadosRodada['rodada']?>" method="post" id="frmPalpite">

						<fieldset>
							<legend><span>Rodada <?php echo $dadosRodada['rodada'] ?></span></legend>          

							<ul>                                      
								
								<?php 
									if (count($partidas)){
										echo "<li>";
										echo "<label for=\"emailParticipante\">Email *</label>";
										echo "<input type=\"text\" name=\"emailParticipante\" id=\"emailParticipante\" class=\"txt_grande\"/>";
										echo "</li>";
									}
								?>   
								
								<div id="partidas">
									<?php 
										$desabilita = '';
									
										if (count($partidas)){ 
											foreach ($partidas as $partida) {
												//$desabilita  = ($partida['diff_datas'] <= '10') ? 'disabled' : '';	
												$desabilita  = '';
						
												echo "<li>{$partida['time_visitante']}
															<input type=\"radio\" name=\"partida_{$partida['id']}\" id=\"partida_{$partida['id']}\" value=\"{$partida['time_visitante']}\" {$desabilita}/> @ 
															<input type=\"radio\" name=\"partida_{$partida['id']}\" id=\"partida_{$partida['id']}\" value=\"{$partida['time_casa']}\" {$desabilita}/> {$partida['time_casa']}                            
													
															<select name=\"bonus_partida_{$partida['id']}\" id=\"bonus_partida_{$partida['id']}\" {$desabilita}>
																<option value=\"\" selected></option> 
																<option value=\"RR\">RR</option> 
																<option value=\"AH\">AH</option>
																<option value=\"OJ\">OJ</option>
															</select>													
														<!--
															<input type=\"text\" name=\"bonus_partida_{$partida['id']}\" id=\"bonus_partida_{$partida['id']}\" class=\"txt_pequeno\" {$desabilita}/>
														-->
													</li>";
											
											}
										} else {
											echo 'Aguarde a publicação das partidas da próxima rodada.<br/><br/>';
										}                    
									?>
								</div>
								<br/>
								<?php
									if (count($partidas)){
										echo "<input type=\"submit\" id=\"enviar\" value=\"Enviar\" {$desabilita}/>";
									}		
								?>
							</ul>							
							
						</fieldset>

					</form>				
				
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