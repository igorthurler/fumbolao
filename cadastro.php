<?php

echo utf8_decode('Inscrição encerrada!!!');
exit;

include 'connection.php';

$queryBolao = $con->prepare("select id, descricao from Bolao where ativo = true");
$queryBolao->execute();   
$dadosBolao = $queryBolao->fetch(PDO::FETCH_ASSOC);

$bolao = isset($dadosBolao['id']) && ($dadosBolao['id'] != '') ? $dadosBolao['id'] : 0;
$title = isset($dadosBolao['descricao']) && ($dadosBolao['descricao'] != '') ? $dadosBolao['descricao'] : utf8_decode('Fumbolão');
                     
?>
<!DOCTYPE html>
<html>

<?php include 'templates/header.php'; ?>
		
<body class="home blog">

	<div id="pagewrap">
		
		<?php include 'templates/top.php'; ?>

		<script>
		/*
		$(document).ready(function () {
		$("#enviar").click(function(){
			  alert("Hello, World.");
			});
		});	
		*/
		$(document).ready(function () {
			$("#frmCadastro").validate({
				rules:{            
					nome:"required",				
					email:{
						required: true,
						email: true
					},
					time:"required"
				},        
				show: {when: {event: 'none'}, ready: true},
				hide: {when: {event: 'keydown'}},
				messages:{
					nome: "Campo obrigatório",				
					email:{
						required: "Campo obrigatório",
						email: "Informe um e-mail válido"
					},
					time: "Campo obrigatório"
				}
			});
		});
		</script>
		
		<div id="body" class="clearfix"> 
			
			<!-- layout -->
			<div id="layout" class="pagewidth clearfix sidebar1">	
				
				<div id="content">				
					<!-- 
						Conteúdo aqui
					-->				
					<form action="cadastrar_participante.php" method="post" id="frmCadastro">							  
						<input type="hidden" name="bolao" id="bolao" value="<?php echo $bolao ?>"/>
						<ul>
							<li>
								<label for="nome">Nome *</label>
								<input type="text" name="nome" id="nome" maxlength="100"/>					  
							</li>
							<li>
								<label for="email">Email *</label>
								<input type="text" name="email" id="email" maxlength="100"/>
			  				</li>
							<li>
								<label for="time" >Time *</label>
								<select name="time" id="time">
									<option value="ARI">ARI</option>
									<option value="ATL">ATL</option>
									<option value="BAL">BAL</option>
									<option value="BUC">BUC</option>
									<option value="BUF">BUF</option>
									<option value="DEN">DEN</option>
									<option value="CAR">CAR</option>							
									<option value="CHI">CHI</option>
									<option value="CLE">CLE</option>
									<option value="DAL">DAL</option>
									<option value="DET">DET</option>							
									<option value="GB">GB</option>
									<option value="HOU">HOU</option>
									<option value="IND">IND</option>
									<option value="JAX">JAX</option>
									<option value="KC">KC</option>
									<option value="MIA">MIA</option>
									<option value="MIN">MIN</option>
									<option value="NE">NE</option>
									<option value="NO">NO</option>
									<option value="NYG">NYG</option>
									<option value="NYJ">NYJ</option>
									<option value="OAK">OAK</option>
									<option value="PHI">PHI</option>							
									<option value="PIT">PIT</option>
									<option value="SD">SD</option>
									<option value="SEA">SEA</option>
									<option value="SF">SF</option>
									<option value="STL">STL</option>																																																																					
									<option value="TEN">TEN</option>
									<option value="WAS">WAS</option>														
									<option value="LA">LA</option>				
								  </select> 
							</li>
							<input type="submit" id="enviar" value="Cadastrar"/>
						</ul>  
					</form>
				
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
</html>	