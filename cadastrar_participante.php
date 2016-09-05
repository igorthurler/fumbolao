<?php
include 'connection.php';

$bolao = addslashes($_POST['bolao']);
$nome = addslashes($_POST['nome']);
$email = addslashes($_POST['email']);
$time = addslashes($_POST['time']);

if ($nome == '') {
	echo utf8_decode('Informe o nome.');
	echo "<br/><a href=\"cadastro\">Voltar</a>";	
	exit;
}

if ($email == '') {
	echo utf8_decode('Informe o email.');
	echo "<br/><a href=\"cadastro\">Voltar</a>";	
	exit;
}

if ($time == '') {
	echo utf8_decode('Informe o time.');
	echo "<br/><a href=\"cadastro\">Voltar</a>";	
	exit;
}

try {
	// Verificar se já existe participante cadastrado com o email informado
	$queryParticipante = $con->prepare("select id from Participante where email = :email");
	$queryParticipante->bindParam( ':email', $email, PDO::PARAM_STR );
	$queryParticipante->execute();

	$dadosParticipante = $queryParticipante->fetch(PDO::FETCH_ASSOC);

	if ($dadosParticipante != null) {
		echo utf8_decode('Participante já cadastrado');
		echo "<br/><a href=\"cadastro\">Voltar</a>";	
		exit;
	} 
	// ---------------------------------------------------

	// Cadastra os dados do participante
	$queryCadastra = $con->prepare("insert into Participante(nome,email,torcedor_time)values(:nome,:email,:time)");
	$queryCadastra->bindParam( ':nome', $nome, PDO::PARAM_STR );
	$queryCadastra->bindParam( ':email', $email, PDO::PARAM_STR );
	$queryCadastra->bindParam( ':time', $time, PDO::PARAM_STR );
	$queryCadastra->execute();
	// ---------------------------------

	$queryBolao = $con->prepare("select descricao from Bolao where id = :bolao");
	$queryBolao->bindParam( ':bolao', $bolao, PDO::PARAM_INT );
	$queryBolao->execute();
	$dadosBolao = $queryBolao->fetch(PDO::FETCH_ASSOC);	
	
	// Envia email confirmando o cadastro do participante.	
	$header = "MIME-Version: 1.0\r\n";
	$header .= "Content-Type: text/html; charset=iso-8859-1\r\n";
	$header .= "From:fumbolao <contato@fumblecast.com.br>";

	$msg = "<h2>{$dadosBolao['descricao']} </h2><br/>
	Parabéns mulambo(a), você acabou de se cadastrar na competição mais relevante do mundo.<br/>
	Seu time é {$time}.<br/>
	Aguarde o início da temporada.";

	mail($email, "Cadastro {$dadosBolao['descricao']}", $msg, $header);
	// ---------------------------------------------------
	
	
	echo utf8_decode("Cadastro realizado com sucesso. <br/>
	                  Enviamos uma confirmação para o email cadastrado({$email}). <br/>
	                  <a href=\"index\">Principal</a>");	
} catch(Exception $e) {
	echo $e->getMessage();
}