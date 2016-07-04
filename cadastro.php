<?php

include 'connection.php';
$query = $con->query("select id, descricao from Bolao where ativo = true");

$dados = $query->fetch_array();

$bolao = $dados['id'];
                      
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
					<form action="cadastrar_participante.php?" method="post" id="frmCadastro">				
						  <input type="hidden" name="bolao" id="bolao" class="txt_grande" value="<?php echo $bolao ?>"/>
						  
						  <label for="email">Email *</label>
						  <input type="text" name="email" id="email" class="txt_grande"/>
						  
						  <label for="nome">Nome *</label>
						  <input type="text" name="nome" id="nome" class="txt_grande"/>					  
						  
						  <label for="time">Time *</label>
						  <select name="rodada">
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
						  </select> 
						  <input type="submit" id="enviar" value="Consultar"/>
					</form>
				
				</div>
				<!-- /#content -->			
				
				<?php include 'templates/sidebar.php'; ?>
				
			</div>
			<!-- /#layout -->		
			
		</div>
		<!-- /body -->	
		
		<?php include 'templates/footer.php'; ?>
		
	</div>
    <!-- /#pagewrap -->
	
</body>
</html>	