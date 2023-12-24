CREATE SEQUENCE sequencia_requerimento
    INCREMENT 1
    START 1;
CREATE TABLE
    requerimento (
        id_requerimento bigint PRIMARY KEY NOT NULL DEFAULT NEXTVAL('sequencia_requerimento'::regclass),
        numero_requerimento varchar(255) NOT NULL UNIQUE,
        id_utente bigint NOT NULL,
        tipo_documento integer NOT NULL,
        numero_documento integer NOT NULL,
        data_emissao_documento date,
        local_emissao_documento varchar(255),
        data_validade_documento date NOT NULL,
        numero_contribuinte integer NOT NULL,
        data_nascimento date NOT NULL,
        id_freguesia_naturalidade bigint NOT NULL,
        morada varchar(255) NOT NULL,
        codigo_postal varchar(255) NOT NULL,
        id_freguesia_residencia bigint NOT NULL,
        numero_telemovel integer NOT NULL,
        numero_telefone integer,
        email_preferencial varchar(255),
        tipo_requerimento integer NOT NULL,
        primeira_submissao integer NOT NULL,
        data_submissao_anterior date,
        estado integer NOT NULL,
        data_criacao timestamp NOT NULL,
        hashed_id varchar(255) UNIQUE
    );
ALTER TABLE requerimento ALTER COLUMN data_criacao SET DEFAULT CURRENT_TIMESTAMP;


CREATE SEQUENCE sequencia_pais
    INCREMENT 1
    START 1;
CREATE TABLE
    pais (
        id_pais bigint PRIMARY KEY NOT NULL DEFAULT NEXTVAL('sequencia_pais'::regclass),
        nome varchar(255) NOT NULL UNIQUE
    );


CREATE SEQUENCE sequencia_freguesia
    INCREMENT 1
    START 1;
CREATE TABLE
    freguesia (
        id_freguesia bigint PRIMARY KEY NOT NULL DEFAULT NEXTVAL('sequencia_freguesia'::regclass),
        nome varchar(255) NOT NULL,
        id_concelho bigint NOT NULL
    );


CREATE SEQUENCE sequencia_concelho
    INCREMENT 1
    START 1;
CREATE TABLE
    concelho (
        id_concelho bigint PRIMARY KEY NOT NULL DEFAULT NEXTVAL('sequencia_concelho'::regclass),
        nome varchar(255) NOT NULL,
        id_distrito bigint NOT NULL
    );


CREATE SEQUENCE sequencia_distrito
    INCREMENT 1
    START 1;
CREATE TABLE
    distrito (
        id_distrito bigint PRIMARY KEY NOT NULL DEFAULT NEXTVAL('sequencia_distrito'::regclass),
        nome varchar(255) NOT NULL,
        id_pais bigint NOT NULL
    );


CREATE TABLE
    numero_requerimento (
        numero_ultimo_requerimento bigint NOT NULL,
        ano integer NOT NULL
    );


CREATE SEQUENCE sequencia_documentos_requerimento
    INCREMENT 1
    START 1;
CREATE TABLE
    documentos_requerimento (
        id_documento bigint PRIMARY KEY NOT NULL DEFAULT NEXTVAL('sequencia_documentos_requerimento'::regclass),
        id_requerimento bigint NOT NULL,
        caminho_documento varchar(255) NOT NULL,
        data_criacao timestamp NOT NULL,
        hashed_id varchar(255) UNIQUE
    );
ALTER TABLE documentos_requerimento ALTER COLUMN data_criacao SET DEFAULT CURRENT_TIMESTAMP;
ALTER TABLE documentos_requerimento ADD nome_documento varchar(255) NOT NULL;


CREATE SEQUENCE sequencia_utilizador
    INCREMENT 1
    START 1;
CREATE TABLE
    utilizador (
        id_utlizador bigint PRIMARY KEY NOT NULL DEFAULT NEXTVAL('sequencia_utilizador'::regclass),
        nome varchar(255) NOT NULL,
        email varchar(255) NOT NULL UNIQUE,
        palavra_passe varchar(255) NOT NULL,
        cargo integer NOT NULL,
        estado integer NOT NULL,
        data_criacao timestamp NOT NULL,
        hashed_id varchar(255) UNIQUE
    );
ALTER TABLE utilizador ALTER COLUMN data_criacao SET DEFAULT CURRENT_TIMESTAMP;


CREATE SEQUENCE sequencia_utente
    INCREMENT 1
    START 1;
CREATE TABLE
    utente (
        id_utente bigint PRIMARY KEY NOT NULL DEFAULT NEXTVAL('sequencia_utente'::regclass),
        id_utente_rnu bigint NOT NULL UNIQUE,
        nome varchar(255) NOT NULL,
        palavra_passe varchar(255) NOT NULL,
        numero_utente integer NOT NULL UNIQUE,
        email_autenticacao varchar(255) NOT NULL,
        data_criacao timestamp NOT NULL,
        hashed_id varchar(255) UNIQUE
    );
ALTER TABLE utente ALTER COLUMN data_criacao SET DEFAULT CURRENT_TIMESTAMP;
ALTER TABLE utente ADD genero varchar(1) NOT NULL;


CREATE TABLE
    historico_acesso_requerimento (
        id_requerimento bigint NOT NULL,
        id_utilizador bigint NOT NULL,
        data_hora_acesso timestamp NOT NULL
    );
ALTER TABLE historico_acesso_requerimento ALTER COLUMN data_hora_acesso SET DEFAULT CURRENT_TIMESTAMP;


CREATE TABLE
    avaliacao_requerimento (
        id_requerimento bigint NOT NULL,
        id_utilizador bigint NOT NULL,
        grau_avalicao float NOT NULL,
        data_avaliacao timestamp NOT NULL
    );
ALTER TABLE avaliacao_requerimento ALTER COLUMN data_avaliacao SET DEFAULT CURRENT_TIMESTAMP;
--CHANGE COLUMN NAME
ALTER TABLE avaliacao_requerimento RENAME COLUMN grau_avalicao TO grau_avaliacao;
--ADD COLUMN notas
ALTER TABLE avaliacao_requerimento ADD notas varchar(255);


CREATE TABLE
    historico_estados (
        id_requerimento bigint NOT NULL,
        id_utilizador bigint NOT NULL,
        estado_anterior integer NOT NULL,
        estado_novo integer NOT NULL,
        data_alteracao timestamp NOT NULL
    );
ALTER TABLE historico_estados ALTER COLUMN data_alteracao SET DEFAULT CURRENT_TIMESTAMP;


CREATE SEQUENCE sequencia_notificacao
    INCREMENT 1
    START 1;
CREATE TABLE
    notificacar_utente (
        id_notificacao bigint PRIMARY KEY NOT NULL DEFAULT NEXTVAL('sequencia_notificacao'::regclass),
        id_requerimento bigint NOT NULL,
        resposta integer,
        data_notificacao timestamp NOT NULL,
        data_resposta timestamp NULL
    );
ALTER TABLE notificacar_utente ALTER COLUMN data_notificacao SET DEFAULT CURRENT_TIMESTAMP;

    
CREATE SEQUENCE sequencia_comunicacao
    INCREMENT 1
    START 1;
CREATE TABLE
    comunicar_utente (
        id_comunicacao bigint PRIMARY KEY NOT NULL DEFAULT NEXTVAL('sequencia_comunicacao'::regclass),
        id_notificacao bigint NOT NULL,
        sms integer NOT NULL,
        email integer NOT NULL
    );


CREATE SEQUENCE sequencia_grupo_medico
    INCREMENT 1
    START 1;
CREATE TABLE
    grupos_medicos (
        id_grupo_medico bigint PRIMARY KEY NOT NULL DEFAULT NEXTVAL('sequencia_grupo_medico'::regclass),
        nome varchar(255) NOT NULL,
        cor varchar(50) NOT NULL,
        data_criacao timestamp NOT NULL,
        hashed_id varchar(255) UNIQUE
    );
ALTER TABLE grupos_medicos ALTER COLUMN data_criacao SET DEFAULT CURRENT_TIMESTAMP;
ALTER TABLE grupos_medicos RENAME TO equipa_medica;
ALTER TABLE equipa_medica RENAME COLUMN id_grupo_medico TO id_equipa_medica;
ALTER TABLE equipa_medica ADD CONSTRAINT equipa_medica_nome_key UNIQUE (nome);
ALTER TABLE equipa_medica ADD CONSTRAINT equipa_medica_cor_key UNIQUE (cor);


CREATE TABLE
    medico_grupo (
        id_utilizador bigint NOT NULL,
        id_grupos_medicos bigint NOT NULL
    );

--RENAME TABLE
ALTER TABLE medico_grupo RENAME TO equipa_medica_medicos;
ALTER TABLE equipa_medica_medicos RENAME COLUMN id_grupos_medicos TO id_equipa_medica;

CREATE SEQUENCE sequencia_agendamento_consulta
    INCREMENT 1
    START 1;
CREATE TABLE
    agendamento_consulta (
        id_agendamento_consulta bigint PRIMARY KEY NOT NULL DEFAULT NEXTVAL('sequencia_agendamento_consulta'::regclass),
        id_requerimento bigint NOT NULL,
        id_grupo_medico bigint NOT NULL,
        id_utilizador bigint NOT NULL,
        data_agendamento date NOT NULL,
        hora_agendamento time NOT NULL,
        data_criacao timestamp NOT NULL,
        hashed_id varchar(255) UNIQUE
    );
ALTER TABLE agendamento_consulta ALTER COLUMN data_criacao SET DEFAULT CURRENT_TIMESTAMP;

ALTER TABLE distrito
ADD
    CONSTRAINT FKDistrito504456 FOREIGN KEY (id_pais) REFERENCES pais (id_pais);

ALTER TABLE concelho
ADD
    CONSTRAINT FKConcelho527678 FOREIGN KEY (id_distrito) REFERENCES distrito (id_distrito);

ALTER TABLE freguesia
ADD
    CONSTRAINT FKFreguesia606879 FOREIGN KEY (id_concelho) REFERENCES concelho (id_concelho);

ALTER TABLE requerimento
ADD
    CONSTRAINT FKRequerimen241545 FOREIGN KEY (id_freguesia_naturalidade) REFERENCES freguesia (id_freguesia);

ALTER TABLE requerimento
ADD
    CONSTRAINT FKRequerimen955880 FOREIGN KEY (id_freguesia_residencia) REFERENCES freguesia (id_freguesia);

ALTER TABLE
    documentos_requerimento
ADD
    CONSTRAINT FKDocumentos878764 FOREIGN KEY (id_requerimento) REFERENCES requerimento (id_requerimento);

ALTER TABLE requerimento
ADD
    CONSTRAINT FKRequerimen537269 FOREIGN KEY (id_utente) REFERENCES utente (id_utente);

ALTER TABLE
    historico_acesso_requerimento
ADD
    CONSTRAINT FKHistoricoA878915 FOREIGN KEY (id_requerimento) REFERENCES requerimento (id_requerimento);

ALTER TABLE
    historico_acesso_requerimento
ADD
    CONSTRAINT FKHistoricoA915471 FOREIGN KEY (id_utilizador) REFERENCES utilizador (id_utlizador);

ALTER TABLE
    avaliacao_requerimento
ADD
    CONSTRAINT FKAvaliacaoR663368 FOREIGN KEY (id_requerimento) REFERENCES requerimento (id_requerimento);

ALTER TABLE
    avaliacao_requerimento
ADD
    CONSTRAINT FKAvaliacaoR271666 FOREIGN KEY (id_utilizador) REFERENCES utilizador (id_utlizador);

ALTER TABLE historico_estados
ADD
    CONSTRAINT FKHistoricoE813186 FOREIGN KEY (id_requerimento) REFERENCES requerimento (id_requerimento);

ALTER TABLE historico_estados
ADD
    CONSTRAINT FKHistoricoE849742 FOREIGN KEY (id_utilizador) REFERENCES utilizador (id_utlizador);

ALTER TABLE notificacar_utente
ADD
    CONSTRAINT FKNotificaca68898 FOREIGN KEY (id_requerimento) REFERENCES requerimento (id_requerimento);

ALTER TABLE comunicar_utente
ADD
    CONSTRAINT FKComunicarU324115 FOREIGN KEY (id_notificacao) REFERENCES notificacar_utente (id_notificacao);

ALTER TABLE medico_grupo
ADD
    CONSTRAINT FKMedicoGrup968912 FOREIGN KEY (id_utilizador) REFERENCES utilizador (id_utlizador);

ALTER TABLE medico_grupo
ADD
    CONSTRAINT FKMedicoGrup246372 FOREIGN KEY (id_grupos_medicos) REFERENCES grupos_medicos (id_grupo_medico);

ALTER TABLE
    agendamento_consulta
ADD
    CONSTRAINT FKAgendament978309 FOREIGN KEY (id_requerimento) REFERENCES requerimento (id_requerimento);

ALTER TABLE
    agendamento_consulta
ADD
    CONSTRAINT FKAgendament596249 FOREIGN KEY (id_grupo_medico) REFERENCES grupos_medicos (id_grupo_medico);

ALTER TABLE
    agendamento_consulta
ADD
    CONSTRAINT FKAgendament956724 FOREIGN KEY (id_utilizador) REFERENCES utilizador (id_utlizador);