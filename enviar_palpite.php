<?php
date_default_timezone_set('America/Sao_Paulo');

include 'connection.php';

$rodada = $_GET['rodada'];
$bolao = $_GET['bolao'];
$emailParticipante = $_POST['emailParticipante'];

// Verificar se o email informado é de um participante
// ---------------------------------------------------
$queryParticipante = $con->query("select id, nome, email from Participante where email = '{$emailParticipante}'");

$dadosParticipante = $queryParticipante->fetch_array();

if ($dadosParticipante == null) {
	echo 'Participante não cadastrado <br/>';
    echo "<a href=\"index.php\">Principal</a>";	
	exit;
} 
// ---------------------------------------------------

// Verificar se o participante já deu palpites;
$idParticipante = $dadosParticipante['id'];

$queryPalpiteUsuario = $con->query("select count(pp.id) as quant_palpite
                                     from Palpite pp
									 join Partida p on p.id = pp.partida
									where p.bolao = {$bolao}
                                      and pp.participante = {$idParticipante}
                                      and p.rodada = {$rodada}");
									  
$dadosPalpiteUsuario = $queryPalpiteUsuario->fetch_array();

if ($dadosPalpiteUsuario['quant_palpite'] > 0) {
	echo "O participante informado já deu seus palpites para a rodada {$rodada} <br/>";
    echo "<a href=\"index.php\">Voltar</a>";	
	exit;	
}
// ---------------------------------------------------

// Buscar os dados das partidas da rodada
$queryPartidas = $con->query("select *
                        from Partida
                       where bolao = {$bolao}
                         and rodada = {$rodada}
						 order by id");					  
// ---------------------------------------------------
	
$data = date("Y-m-d H:i:s");	
	
// Cadastrar o palpite
while ($dadosPartidas = $queryPartidas->fetch_array()) {
	$idPartida = $dadosPartidas['id'];
	$timePalpite = isset($_POST['partida_'.$idPartida]) && $_POST['partida_'.$idPartida] != '' ? $_POST['partida_'.$idPartida] : 'null';
	// TODO: Utilizar função para colocar aspas em uma string
	$bonus = isset($_POST['bonus_partida_'.$idPartida]) && $_POST['bonus_partida_'.$idPartida] != '' ? "'".$_POST['bonus_partida_'.$idPartida]."'" : 'null';
	
	$sql = "insert into Palpite(data_hora,participante,partida,time_palpite,bonus)values('{$data}',{$idParticipante},{$idPartida},'{$timePalpite}',{$bonus})";
	//echo $sql.'<br/>';
	$con->query($sql);
    
    $palpitesMsg .= "<b>{$timeVencedor} . ({$bonus} != 'null') ? ({$bonus}) : '' <b/><br/>";
}
// -------------------	

// Envia email confirmando o palpite para o participante.
$queryBolao = $con->query("select descricao from Bolao where id = {$bolao}");
$dadosBolao = $queryBolao->fetch_array();

$header = "MIME-Version: 1.0\r\n";
$header .= "Content-Type: text/html; charset=iso-8859-1\r\n";
$header .= "From:fumbolao <contato@fumblecast.com.br>";

$msg = "<h2>Fumbolão 2015/2016 </h2><br/>
Prezado(a) {$dadosParticipante['nome']}, seus palpites para a rodada {$rodada} foram: <br/>
{$palpitesMsg}";

mail($emailParticipante, "{$dadosBolao} rodada {$rodada}", $msg, $header);
// --------------------------------------------------------------------------------------

echo "Palpites cadastrado com sucesso. <br/>";
echo "Seus palpites foram enviados para o email cadastrado({$emailParticipante}). <br/>";
echo "<a href=\"index.php\">Principal</a>";	