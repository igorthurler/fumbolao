use fw_bolao;

create table Participante(
    id int(11) not null auto_increment primary key,
    nome varchar(100) not null,
    email varchar(100) not null unique,
    torcedor_time varchar(30) not null
);

create table Bolao(
    id int(11) not null auto_increment primary key,
    descricao varchar(30) not null,
	ativo tinyint(1) not null default 0
);

create table Partida(
    id int(11) not null auto_increment primary key,
    bolao int(11) not null,
    rodada int(11) not null,
    data_limite_aposta timestamp,
    time_casa varchar(30) not null,
    placar_time_casa int(11) not null  default 0,
    time_visitante varchar(30) not null, 
    placar_time_visitante int(11) not null default 0,
    finalizada tinyint(1) not null default 0
);

alter table Partida add constraint fk_partida_bolao foreign key(bolao) references Bolao(id) on update cascade on delete cascade;

create table Palpite(
    id int(11) not null auto_increment primary key,
    data_hora datetime not null,
    participante int(11) not null,
    partida int(11) not null,
    time_palpite varchar(30) not null,
    bonus char(2)
);

alter table Palpite add constraint fk_palpite_partida foreign key(partida) references Partida(id) on update cascade on delete cascade;
alter table Palpite add constraint fk_palpite_participante foreign key(participante) references Participante(id) on update cascade;