<?php
date_default_timezone_set('America/Sao_Paulo');

include 'connection.php';

$query = $con->query("select id, descricao from Bolao where ativo = true");

$dados = $query->fetch_array();

$bolao = isset($dados['id']) && ($dados['id'] != '') ? $dados['id'] : 0;
$title = isset($dados['descricao']) && ($dados['descricao'] != '') ? utf8_decode($dados['descricao']) : 'Fumbolão';
        		
?>
<!DOCTYPE html>
<html>

<head>

	<title>Fumbolão</title>

	<meta http-equiv="content-type" content="text/html; charset=iso-8859-1">		

	<!-- header -->
	<link rel="stylesheet" id="themify-styles-css" href="css/style.css" type="text/css" media="all">
	<link rel="stylesheet" id="themify-media-queries-css" href="css/media-queries.css" type="text/css" media="all">

	<!-- media-queries.js -->
	<!--[if lt IE 9]>
		<script src="http://css3-mediaqueries-js.googlecode.com/svn/trunk/css3-mediaqueries.js"></script>
	<![endif]-->

	<!-- html5.js -->
	<!--[if lt IE 9]>
		<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
	<![endif]-->
	<meta name="viewport" content="width=100%, initial-scale=1, maximum-scale=1, minimum-scale=1, user-scalable=no">	
	<style type="text/css">.recentcomments a{display:inline !important;padding:0 !important;margin:0 !important;}</style>

	<script src="js/fumbolao.js" type="text/javascript"></script>
	
</head>
	
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
                    <p>
                        <b>
                        Informe seu email, selecione um vencedor de cada partida e informe o resultado extra ao lado da partida:<br/><br/>
                        </b>
                        RR(Ray Rice - 3 pts) - Diferença no placar entre 20 e 29 pontos.<br/>
                        AH(Aaron Hernandez - 5 pts) - Diferença no placar entre 30 e 39 pontos. <br/>
                        OJ(O.J Simpson - 7 pts) - Diferença no placar for igual ou maior que 40 pontos.
                    </p>                  
					<p><h3>Os palpites só poderão ser feitos até uma hora antes do início da primeira partida.</h3></p>					
									
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
<!-- /body -->		

</html>	