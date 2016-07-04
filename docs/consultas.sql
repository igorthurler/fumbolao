-- Resultados de cada rodada (Retorna o time que ganhou o jogo e o bônus, se houver)
create view vw_resultados_rodada as
select p.bolao,
       p.rodada,
	   p.id as partida,
       p.time_visitante, 
       p.placar_time_visitante, 
       p.time_casa, 
       p.placar_time_casa,
       case when p.placar_time_visitante > p.placar_time_casa then p.time_visitante
            when p.placar_time_casa > p.placar_time_visitante then p.time_casa
            else 'EMPATE' 
       end as resultado,
       case when ABS(p.placar_time_visitante - p.placar_time_casa) >= 20 and ABS(p.placar_time_visitante - p.placar_time_casa) < 30 then 'RR'
            when ABS(p.placar_time_visitante - p.placar_time_casa) >= 30 and ABS(p.placar_time_visitante - p.placar_time_casa) < 40 then 'AH'
            when ABS(p.placar_time_visitante - p.placar_time_casa) >= 40 then 'OJ'
            else ''
       end as bonus     
  from Partida p;

-- Resultado dos participantes por rodada
-- O participante ganha ponto se apostou no time perdedor
-- O bônus é dado se o time que o participante apostou perdeu de lavada
-- Se o time que o participante apostou ganhar, ele perde um ponto
-- Se o time que o participante apostou ganhou de lavada, ele perde os pontos do bônus
-- Se o participante não votar no seu time ele será considerado um desonesto e perde 5 pontos
-- Se o participante perde um ponto por partida não apostada
create view vw_resultados_rodada_participante as
select vrr.bolao,
       vrr.rodada,
       vrr.partida,
       prt.id as id_participante,
       prt.nome as nome_participante,
       prt.email as email_participante,
	   ppt.torcedor_time as time_participante,
	   vrr.time_visitante as time_visitante,
	   vrr.placar_time_visitante as placar_time_visitante,
       vrr.time_casa as time_casa, 
       vrr.placar_time_casa as placar_time_casa,
       ppt.time_palpite as aposta_participante,
       vrr.resultado,
            /*Se não for jogo do time do participante e ele não deu palpite, perde 1 ponto*/	   
       case when (((ppt.time_visitante <> prt.torcedor_time) and (ppt.time_casa <> prt.torcedor_time)) and ppt.time_palpite is null) then -1
			/*Se for jogo do time do participante e ele não apostou no seu time, perde 5 pontos*/
	        case when (
			                ((ppt.time_visitante = prt.torcedor_time) or (ppt.time_casa = prt.torcedor_time)) 
						and ((ppt.time_palpite is null) or (ppt.time_palpite <> prt.torcedor_time))
			           ) then -5
	        /*Se o time que o participante apostou perder, ganha 1 ponto*/
			when (vrr.resultado <> ppt.time_palpite) and (vrr.resultado <> 'EMPATE') then 1						
			/*Se o time que o participante apostou ganhar, perde 1 ponto*/
			when (vrr.resultado = ppt.time_palpite) and (vrr.resultado <> 'EMPATE') then -1	
			else 0
       end as pontos,
	        /*Se o time que o participante apostou perdeu e o participante acertou o bônus, ele ganha ponto*/
       case when (ppt.time_palpite is null) then 0
	        when (vrr.resultado <> 'EMPATE') and (vrr.resultado <> ppt.time_palpite) and (binary ppt.bonus = vrr.bonus) and (binary vrr.bonus = 'RR') then 3
            when (vrr.resultado <> 'EMPATE') and (vrr.resultado <> ppt.time_palpite) and (binary ppt.bonus = vrr.bonus) and (binary vrr.bonus = 'AH') then 5
            when (vrr.resultado <> 'EMPATE') and (vrr.resultado <> ppt.time_palpite) and (binary ppt.bonus = vrr.bonus) and (binary vrr.bonus = 'OJ') then 7
			/*Se o time que o participante apostou ganhou e o participante acertou o bônus, ele perde ponto*/
			when (vrr.resultado = ppt.time_palpite) and (binary ppt.bonus = vrr.bonus) and (binary vrr.bonus = 'RR') then -3
            when (vrr.resultado = ppt.time_palpite) and (binary ppt.bonus = vrr.bonus) and (binary vrr.bonus = 'AH') then -5
            when (vrr.resultado = ppt.time_palpite) and (binary ppt.bonus = vrr.bonus) and (binary vrr.bonus = 'OJ') then -7
            else 0
       end as bonus,	   
	   -- Se for jogo do time do participante e ele não apostar ou apostar no outro time ele é um desonesto
	   case when (
	                     ((ppt.time_visitante = prt.torcedor_time) or (ppt.time_casa = prt.torcedor_time)) 
	                 and ((ppt.time_palpite is null) or (ppt.time_palpite <> prt.torcedor_time))
				  ) then 'S'
			else 'N'
	   end as desonesto 	
  from Palpite ppt
  left join vw_resultados_rodada vrr on vrr.partida = ppt.partida
  join Participante prt on prt.id = ppt.participante;
  
-- Total de pontos dos participantes por rodada  
create view vw_pontos_participante AS 
	select rp.bolao as bolao, 
		   rp.rodada AS rodada,
	       rp.nome_participante as nome_participante,
	       rp.email_participante as email_participante,
		   sum(rp.pontos) AS soma_pontos,
		   sum(rp.bonus) AS soma_bonus,
		   sum(rp.pontos + rp.bonus) as soma_total
	  from vw_resultados_rodada_participante rp
	  group by rp.nome_participante,rp.bolao, rp.rodada 
	  order by rp.nome_participante,rp.bolao, rp.rodada;	  
  
-- Ranking	
create view vw_ranking as	  
select vpp.bolao,
       vpp.nome_participante,       
	   sum(vpp.soma_pontos) as pontos,
	   sum(vpp.soma_bonus) as bonus,
	   sum(vpp.soma_total) as total
  from	vw_pontos_participante vpp  
 group by vpp.bolao, vpp.nome_participante;