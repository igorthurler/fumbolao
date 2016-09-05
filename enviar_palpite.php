<?php
date_default_timezone_set('America/Sao_Paulo');

include 'connection.php';

$rodada = $_GET['rodada'];
$bolao = $_GET['bolao'];
$emailParticipante = $_POST['emailParticipante'];

// Verificar se o email informado é de um participante
// ---------------------------------------------------
$queryParticipante = $con->prepare("select id, nome, email from Participante where email = :email");
$queryParticipante->bindParam( ':email', $emailParticipante, PDO::PARAM_STR );
$queryParticipante->execute();

$dadosParticipante = $queryParticipante->fetch(PDO::FETCH_ASSOC);

if ($dadosParticipante == null) {
	echo 'Participante não cadastrado <br/>';
    echo "<a href=\"index\">Principal</a>";	
	exit;
} 
// ---------------------------------------------------

// Verificar se o participante já deu palpites;
$idParticipante = $dadosParticipante['id'];

$queryPalpiteUsuario = $con->prepare("select count(pp.id) as quant_palpite
                                     from Palpite pp
									 join Partida p on p.id = pp.partida
									where p.bolao = :bolao
                                      and pp.participante = :participante
                                      and p.rodada = :rodada");
									  
$queryPalpiteUsuario->bindParam( ':bolao', $bolao, PDO::PARAM_INT );
$queryPalpiteUsuario->bindParam( ':participante', $idParticipante, PDO::PARAM_INT );
$queryPalpiteUsuario->bindParam( ':rodada', $rodada, PDO::PARAM_INT );									  
$queryPalpiteUsuario->execute();
									  
$dadosPalpiteUsuario = $queryPalpiteUsuario->fetch(PDO::FETCH_ASSOC);

if ($dadosPalpiteUsuario['quant_palpite'] > 0) {
	echo "O participante informado já deu seus palpites para a rodada {$rodada} <br/>";
    echo "<a href=\"index\">Voltar</a>";	
	exit;	
}
// ---------------------------------------------------

// Buscar os dados das partidas da rodada
$queryPartidas = $con->prepare("select *
                        from Partida
                       where bolao = :bolao
                         and rodada = :rodada
						 order by id");					  
						 
$queryPartidas->bindParam( ':bolao', $bolao, PDO::PARAM_INT );
$queryPartidas->bindParam( ':rodada', $rodada, PDO::PARAM_INT );									  
$queryPartidas->execute();						 

$partidas = $queryPartidas->fetchAll( PDO::FETCH_ASSOC );
// ---------------------------------------------------
	
$data = date("Y-m-d H:i:s");	
				
$palpitesMsg = '';
				
// Cadastrar o palpite
foreach ($partidas as $partida) {
	$idPartida = $partida['id'];
	$timePalpite = isset($_POST['partida_'.$idPartida]) && $_POST['partida_'.$idPartida] != '' ? $_POST['partida_'.$idPartida] : null;
	// TODO: Utilizar função para colocar aspas em uma string
	$bonus = isset($_POST['bonus_partida_'.$idPartida]) && $_POST['bonus_partida_'.$idPartida] != '' ? $_POST['bonus_partida_'.$idPartida] : null;
	
	$queryCadastra = $con->prepare("insert into 	Palpite(data_hora,participante,partida,time_palpite,bonus)values(:data,:participante,:partida,:palpite,:bonus)");
	$queryCadastra->bindParam( ':data', $data );
	$queryCadastra->bindParam( ':participante', $idParticipante, PDO::PARAM_INT );
	$queryCadastra->bindParam( ':partida', $idPartida, PDO::PARAM_INT  );
	$queryCadastra->bindParam( ':palpite', $timePalpite, PDO::PARAM_STR  );
	$queryCadastra->bindParam( ':bonus', $bonus, PDO::PARAM_STR );
	$queryCadastra->execute();
    
    $palpitesMsg .= "<b>{$timePalpite} {$bonus} <b/><br/>";
}
// -------------------	


// Envia email confirmando o palpite para o participante.

$queryBolao = $con->prepare("select descricao from Bolao where id = :bolao");
$queryBolao->bindParam( ':bolao', $bolao, PDO::PARAM_INT );

$dadosBolao = $queryBolao->fetchAll( PDO::FETCH_ASSOC );

$header = "MIME-Version: 1.0\r\n";
$header .= "Content-Type: text/html; charset=iso-8859-1\r\n";
$header .= "From:fumbolao <contato@fumblecast.com.br>";

$msg = "<h2>Fumbolão 2015/2016 </h2><br/>
Prezado(a) {$dadosParticipante['nome']}, seus palpites para a rodada {$rodada} foram: <br/>
{$palpitesMsg}";

mail($emailParticipante, "{$dadosBolao['descricao']} rodada {$rodada}", $msg, $header);
// --------------------------------------------------------------------------------------


echo "Palpites cadastrado com sucesso. <br/>";
echo "Seus palpites foram enviados para o email cadastrado({$emailParticipante}). <br/>";
echo "<a href=\"index\">Principal</a>";	