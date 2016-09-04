<?php

include 'connection.php';

$bolao = $GET['bolao'];

//Buscar dados da rodadas atual a partir das partidas
$queryRodadas = $con->query("select distinct rodada
                        from Partida
                       where bolao = {$bolao}
                       order by rodada desc");                     

if (isset($_POST['email']) && isset($_POST['rodada'])) {
	$email = $_POST['email'];
	$rodada = $_POST['rodada'];
	
	// Buscar Palpites.
	$sql = "select *
              from vw_resultados_rodada_participante
             where bolao = {$bolao}
               and rodada = {$rodada}
               and email_participante = '{$email}'";

	$queryPalpites = $con->query($sql);
}
                       
?>
<!DOCTYPE html>
<html>
    <?php include 'templates/header.php'; ?>
    <body>
        <div id="BoxForm">
                <h1><?php echo $dados['descricao'] ?></h1>
                <form action="#" method="post" id="frmConsulta">
                  
                    <p>
                        <b>
                        Informe seu email, selecione uma rodada para consultar seus palpites:
                        </b>
                    </p>                  
                  
                      <label for="email">Email *</label>
                      <input type="text" name="email" id="email" class="txt_grande"/>
					  <label for="rodada">Rodada</label>
					  <select name="rodada">
						<?php
							while ($rodada = $queryRodadas->fetch_array()) {
								$r = $rodada['rodada'];
									echo "<option value=\"$r\">$r</option>";
							}
						?>
					  </select> 
					  <input type="submit" id="enviar" value="Consultar"/>
                </form>
				<?php
					if (isset($_POST['email']) && isset($_POST['rodada'])) {
						echo "<h3>Palpites da rodada $rodada</h3><br/>";
						while ($palpite = $queryPalpites->fetch_array()) {
							$bonus = ($palpite['bonus'] != null) ? ' ('.$palpite['bonus'].')'  : '';
							echo $palpite['aposta_participante'] . $bonus . '<br/>';
						}
					}				
				?>
        </div>

    </body>
</html>	