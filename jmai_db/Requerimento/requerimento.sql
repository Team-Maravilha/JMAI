/* 
CREATE TABLE
    numero_requerimento (
        numero_ultimo_requerimento bigint NOT NULL,
        ano integer NOT NULL
    );
*/
/**
    * Esta função permite verificar se exite contagem de requerimentos para o ano.
    * @param {Date} data - O ano a ser verificado.
    * @returns {Boolean} True se existir contagem de requerimentos para o ano, false caso contrário.
*/
CREATE OR REPLACE FUNCTION existe_contagem_requerimentos(data date) RETURNS boolean AS $$
DECLARE
    check_ano integer;
BEGIN
    check_ano := EXTRACT(YEAR FROM data);
    RETURN EXISTS(SELECT * FROM numero_requerimento WHERE ano = check_ano);
END;
$$ LANGUAGE plpgsql;


/**
    * Esta função permite criar uma contagem de requerimentos para o ano.
    * @param {Date} data - O ano a ser criado.
    * @returns {Boolean} True se a contagem for criada, false caso contrário.
*/
CREATE OR REPLACE FUNCTION criar_contagem_requerimentos(data date) RETURNS boolean AS $$
DECLARE
    check_ano integer;
BEGIN
    check_ano := EXTRACT(YEAR FROM data);
    IF existe_contagem_requerimentos(data) = FALSE THEN
        INSERT INTO numero_requerimento VALUES (0, check_ano);
        RETURN TRUE;
    ELSE
        RETURN TRUE;
    END IF;
END;
$$ LANGUAGE plpgsql;


/**
    * Esta função permite obter o número de requerimento para o ano.
    * @param {Date} data - O ano a ser obtido.
    * @returns {String} O número de requerimento para o ano. (REQ/00001/2020)
*/
CREATE OR REPLACE FUNCTION obter_numero_requerimento(data date) RETURNS varchar(255) AS $$
DECLARE
    check_ano integer;
    check_numero_requerimento bigint;
    check_numero_requerimento_string varchar(255);
BEGIN
    check_ano := EXTRACT(YEAR FROM data);
    IF existe_contagem_requerimentos(data) = FALSE THEN
        CALL criar_contagem_requerimentos(data);
    END IF;
    SELECT numero_ultimo_requerimento INTO check_numero_requerimento FROM numero_requerimento WHERE ano = check_ano;
    check_numero_requerimento := check_numero_requerimento + 1;
    check_numero_requerimento_string := check_numero_requerimento::varchar;
    check_numero_requerimento_string := LPAD(check_numero_requerimento_string, 5, '0');
    check_numero_requerimento_string := 'REQ/' || check_numero_requerimento_string || '/' || check_ano::varchar;
    UPDATE numero_requerimento SET numero_ultimo_requerimento = check_numero_requerimento WHERE ano = check_ano;
    RETURN check_numero_requerimento_string;
END;
$$ LANGUAGE plpgsql;


/**
    * Esta função permite incrementar o número de requerimento para o ano.
    * @param {Date} data - O ano a ser incrementado.
    * @returns {Boolean} True se o número de requerimento for incrementado, false caso contrário.
*/
CREATE OR REPLACE FUNCTION incrementar_numero_requerimento(data date) RETURNS boolean AS $$
DECLARE
    check_ano integer;
    check_numero_requerimento bigint;
BEGIN
    check_ano := EXTRACT(YEAR FROM data);
    IF existe_contagem_requerimentos(data) = FALSE THEN
        CALL criar_contagem_requerimentos(data);
    END IF;
    SELECT numero_ultimo_requerimento INTO check_numero_requerimento FROM numero_requerimento WHERE ano = check_ano;
    check_numero_requerimento := check_numero_requerimento + 1;
    UPDATE numero_requerimento SET numero_ultimo_requerimento = check_numero_requerimento WHERE ano = check_ano;
    RETURN TRUE;
END;
$$ LANGUAGE plpgsql;


/**
    * Esta função permite adcionar um novo requerimento na base de dados.
    * @param {Number} id_utente - O identificador do utente a ser inserido.
    * @param {Number} tipo_documento - O identificador do tipo de documento a ser inserido.
    * @param {Number} numero_documento - O número do documento a ser inserido.
    * @param {Date} data_emissao_documento - A data de emissão do documento a ser inserido.(NULL)
    * @param {String} local_emissao_documento - O local de emissão do documento a ser inserido.(NULL)
    * @param {Date} data_validade_documento - A data de validade do documento a ser inserido.
    * @param {Number} numero_contribuinte - O número de contribuinte a ser inserido.
    * @param {Date} data_nascimento - A data de nascimento a ser inserida.
    * @param {Number} id_freguesia_naturalidade - O identificador da freguesia de naturalidade a ser inserida.
    * @param {String} morada - A morada a ser inserida.
    * @param {String} codigo_postal - O código postal a ser inserido.
    * @param {Number} id_freguesia_residencia - O identificador da freguesia de residência a ser inserida.
    * @param {Number} numero_telemovel - O número de telemóvel a ser inserido.
    * @param {Number} numero_telefone - O número de telefone a ser inserido.
    * @param {String} email_preferencial - O email preferencial a ser inserido.
    * @param {Number} tipo_requerimento - O tipo de requerimento a ser inserido.
    * @param {Number} primeira_submissao - A primeira submissão a ser inserida.
    * @param {Date} data_submissao_anterior - A data de submissão anterior a ser inserida.
    * @param {JSON} array_documentos - O array de documentos a ser inserido.
    * @returns {String} O identificador do requerimento inserido.
*/


CREATE OR REPLACE FUNCTION inserir_requerimento(
    hashed_id_utente varchar(255),
    tipo_documento integer,
    numero_documento integer,
    data_validade_documento text,
    numero_contribuinte integer,
    data_nascimento text,
    id_freguesia_naturalidade bigint,
    morada varchar(255),
    codigo_postal varchar(255),
    id_freguesia_residencia bigint,
    numero_telemovel integer,
    tipo_requerimento integer,
    primeira_submissao integer,
    data_submissao_anterior text DEFAULT NULL,
    numero_telefone integer DEFAULT NULL,
    email_preferencial varchar(255) DEFAULT NULL,
    data_emissao_documento text DEFAULT NULL,
    local_emissao_documento varchar(255) DEFAULT NULL,
    array_documentos JSON DEFAULT NULL
)
RETURNS TABLE (hashed_id varchar(255)) AS $$  
DECLARE
    doc record;
    id_requerimento_aux integer;
    id_utente_aux integer;
    numero_requerimento_aux varchar(255);
    data_validade_documento_aux date DEFAULT NULL;
    data_nascimento_aux date DEFAULT NULL;
    data_submissao_anterior_aux date DEFAULT NULL;
    data_emissao_documento_aux date DEFAULT NULL;
BEGIN

    IF hashed_id_utente IS NULL THEN
        RAISE EXCEPTION 'O identificador do utente não pode ser nulo.';
    ELSIF NOT EXISTS(SELECT * FROM utente WHERE utente.hashed_id = inserir_requerimento.hashed_id_utente) THEN
        RAISE EXCEPTION 'Ocorreu um erro ao verificar o utente.';
    ELSE
        SELECT utente.id_utente INTO id_utente_aux FROM utente WHERE utente.hashed_id = inserir_requerimento.hashed_id_utente;
    END IF;

    IF id_utente_aux IS NULL THEN
        RAISE EXCEPTION 'O identificador do utente não pode ser nulo.';
    ELSIF NOT EXISTS(SELECT * FROM utente WHERE utente.id_utente = id_utente_aux) THEN
        RAISE EXCEPTION 'Ocorreu um erro ao verificar o utente.';
    END IF;

    IF tipo_documento IS NULL THEN
        RAISE EXCEPTION 'O identificador do tipo de documento não pode ser nulo.';
    ELSIF tipo_documento < 0 OR tipo_documento > 1 THEN
        RAISE EXCEPTION 'O identificador do tipo de documento tem de ser BI ou CC.';
    END IF;

    IF tipo_documento = 1 AND data_emissao_documento IS NULL THEN
        RAISE EXCEPTION 'A data de emissão do documento não é válida.';
    ELSE 
        data_emissao_documento_aux = converter_from_pt_to_iso(data_emissao_documento);

        IF data_emissao_documento_aux > CURRENT_DATE THEN
            RAISE EXCEPTION 'A data de emissão do documento tem de ser inferior à data atual.';
        END IF;

    END IF;

    IF tipo_documento = 1 THEN
        IF local_emissao_documento IS NULL OR local_emissao_documento = '' THEN
            RAISE EXCEPTION 'O local de emissão do documento não é válido.';
        END IF;
    END IF;

    IF numero_documento IS NULL THEN
        RAISE EXCEPTION 'O número do documento inválido.';
    ELSIF numero_documento < 0 THEN
        RAISE EXCEPTION 'O número do documento inválido.';
    END IF;

    IF data_validade_documento IS NULL THEN
        RAISE EXCEPTION 'A data de validade do documento não é válida.';
    ELSE 
        data_validade_documento_aux = converter_from_pt_to_iso(data_validade_documento);

        IF data_validade_documento_aux < CURRENT_DATE THEN
            RAISE EXCEPTION 'A data de validade do documento tem de ser superior à data atual.';
        END IF;

    END IF;

    IF numero_contribuinte IS NULL THEN
        RAISE EXCEPTION 'O número de contribuinte não é válido.';
    ELSIF numero_contribuinte < 0 THEN
        RAISE EXCEPTION 'O número de contribuinte não é válido.';
    END IF;

    IF data_nascimento IS NULL THEN
        RAISE EXCEPTION 'A data de nascimento não ´válida.';
    ELSE 
        data_nascimento_aux = converter_from_pt_to_iso(data_nascimento);

        IF data_nascimento_aux > CURRENT_DATE THEN
            RAISE EXCEPTION 'A data de nascimento tem de ser inferior à data atual.';
        END IF;

    END IF;

    IF id_freguesia_naturalidade IS NULL THEN
        RAISE EXCEPTION 'A freguesia de naturalidade não é válida.';
    ELSIF NOT EXISTS(SELECT * FROM freguesia WHERE freguesia.id_freguesia = inserir_requerimento.id_freguesia_naturalidade) THEN
        RAISE EXCEPTION 'Ocorreu um erro ao verificar a freguesia de naturalidade.';
    END IF;

    IF morada IS NULL OR morada = '' THEN
        RAISE EXCEPTION 'A morada não é válida.';
    END IF;

    IF codigo_postal IS NULL OR codigo_postal = '' THEN
        RAISE EXCEPTION 'O código postal não é válido.';
    ELSIF NOT codigo_postal ~ '^\d{4}-\d{3}$' THEN
        RAISE EXCEPTION 'O código postal não é válido.';
    END IF;

    IF id_freguesia_residencia IS NULL THEN
        RAISE EXCEPTION 'A freguesia de residência não é válida.';
    ELSIF NOT EXISTS(SELECT * FROM freguesia WHERE freguesia.id_freguesia = inserir_requerimento.id_freguesia_residencia) THEN
        RAISE EXCEPTION 'Ocorreu um erro ao verificar a freguesia de residência.';
    END IF;

    IF numero_telemovel IS NULL THEN
        RAISE EXCEPTION 'O número de telemóvel não é válido.';
    ELSIF numero_telemovel < 0 THEN
        RAISE EXCEPTION 'O número de telemóvel não é válido.';
    END IF;

    IF tipo_requerimento IS NULL THEN
        RAISE EXCEPTION 'O tipo de requerimento não é válido.';
    ELSIF tipo_requerimento < 0 OR tipo_requerimento > 1 THEN
        RAISE EXCEPTION 'O tipo de requerimento não é válido.';
    END IF;

    IF primeira_submissao IS NULL THEN
        RAISE EXCEPTION 'A primeira submissão não é válida.';
    ELSIF primeira_submissao < 0 OR primeira_submissao > 1 THEN
        RAISE EXCEPTION 'A primeira submissão não é válida.';
    END IF;

    IF primeira_submissao = 1 AND data_submissao_anterior IS NULL THEN
        RAISE EXCEPTION 'A data de submissão anterior não é válida.';
    ELSE 
        data_submissao_anterior_aux = converter_from_pt_to_iso(data_submissao_anterior);

        IF data_submissao_anterior_aux > CURRENT_DATE THEN
            RAISE EXCEPTION 'A data de submissão anterior tem de ser inferior à data atual.';
        END IF;

    END IF;

    IF email_preferencial IS NOT NULL AND email_preferencial <> '' THEN
        IF email_preferencial ~ '^[A-Za-z0-9._%+-]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,}$' THEN
            RAISE EXCEPTION 'O email preferencial não é válido.';
        END IF;
    ELSE 
        email_preferencial = NULL;
    END IF;

    numero_requerimento_aux := obter_numero_requerimento(CURRENT_DATE);
	
    INSERT INTO requerimento (
        numero_requerimento,
        id_utente,
        tipo_documento,
        numero_documento,
        data_emissao_documento,
        local_emissao_documento,
        data_validade_documento,
        numero_contribuinte,
        data_nascimento,
        id_freguesia_naturalidade,
        morada,
        codigo_postal,
        id_freguesia_residencia,
        numero_telemovel,
        numero_telefone,
        email_preferencial,
        tipo_requerimento,
        primeira_submissao,
        data_submissao_anterior,
        estado
    ) VALUES (
        numero_requerimento_aux,
       	id_utente_aux,
        inserir_requerimento.tipo_documento,
        inserir_requerimento.numero_documento,
        data_emissao_documento_aux,
        inserir_requerimento.local_emissao_documento,
        data_validade_documento_aux,
        inserir_requerimento.numero_contribuinte,
        data_nascimento_aux,
        inserir_requerimento.id_freguesia_naturalidade,
        inserir_requerimento.morada,
        inserir_requerimento.codigo_postal,
        inserir_requerimento.id_freguesia_residencia,
        inserir_requerimento.numero_telemovel,
        inserir_requerimento.numero_telefone,
        inserir_requerimento.email_preferencial,
        inserir_requerimento.tipo_requerimento,
        inserir_requerimento.primeira_submissao,
      	data_submissao_anterior_aux,
        0
    ) RETURNING requerimento.id_requerimento INTO id_requerimento_aux;

    IF array_documentos IS NOT NULL THEN
        FOR doc IN SELECT * FROM json_array_elements(array_documentos) LOOP
        
            DECLARE
                caminho_documento text := doc.value->>'caminho_documento';
                nome_documento text := doc.value->>'nome_documento';
            BEGIN
                IF caminho_documento IS NULL OR caminho_documento = '' THEN
                    --RAISE EXCEPTION 'O caminho do documento não pode ser nulo.';
                ELSIF nome_documento IS NULL OR nome_documento = '' THEN
                    --RAISE EXCEPTION 'O nome do documento não pode ser nulo.';
                ELSE
                    INSERT INTO documentos_requerimento (
                        caminho_documento,
                        nome_documento,
                        id_requerimento
                    ) VALUES (
                        caminho_documento,
                        nome_documento,
                        id_requerimento_aux
                    );
                END IF;
            END;
        END LOOP;
    END IF;

    RETURN QUERY SELECT requerimento.hashed_id FROM requerimento WHERE requerimento.id_requerimento = id_requerimento_aux;

END;
$$ LANGUAGE plpgsql;


/**
    * Adicionar o HashedID a um requerimento.
    */
CREATE TRIGGER add_uuid BEFORE INSERT ON requerimento FOR EACH ROW EXECUTE PROCEDURE add_uuid();


/**
    * Adicionar o HashedID a um documento.
    */
CREATE TRIGGER add_uuid_documento BEFORE INSERT ON documentos_requerimento FOR EACH ROW EXECUTE PROCEDURE add_uuid();


/**
    * Esta função permite obter uma lista de requerimentos.
    * @param {String} hashed_id_param - O identificador do requerimento a ser obtido.
    * @param {String} hashed_id_utente_param - O identificador do utente a ser obtido.
     * @param {Date} data_criacao_param - A data de criação do requerimento a ser obtido.
    * @param {Number} estado_param - O estado do requerimento a ser obtido.
    * @param {Number} tipo_requerimento_param - O tipo de requerimento a ser obtido.
    * @returns {JSON} Os dados do requerimento obtido.
*/
CREATE OR REPLACE FUNCTION listar_requerimentos(
    hashed_id_param varchar(255) DEFAULT NULL,
    hashed_id_utente_param varchar(255) DEFAULT NULL,
    data_criacao_param text DEFAULT NULL,
    estado_param integer DEFAULT NULL,
    tipo_requerimento_param integer DEFAULT NULL
)
RETURNS TABLE (
    hashed_id varchar(255),
    numero_requerimento varchar(255),
    hashed_id_utente varchar(255),
    informacao_utente JSON,
    tipo_documento integer,
    texto_tipo_documento text,
    numero_documento integer,
    data_emissao_documento text,
    local_emissao_documento varchar(255),
    data_validade_documento text,
    numero_contribuinte integer,
    data_nascimento text,
    nome_freguesia_naturalidade varchar(255),
    nome_concelho_naturalidade varchar(255),
    nome_distrito_naturalidade varchar(255),
    nome_pais_naturalidade varchar(255),
    morada varchar(255),
    codigo_postal varchar(255),
    nome_freguesia_residencia varchar(255),
    nome_concelho_residencia varchar(255),
    nome_distrito_residencia varchar(255),
    nome_pais_residencia varchar(255),
    numero_telemovel integer,
    numero_telefone integer,
    email_preferencial varchar(255),
    tipo_requerimento integer,
    texto_tipo_requerimento text,
    primeira_submissao integer,
    texto_primeira_submissao text,
    data_submissao_anterior text,
    estado integer,
    texto_estado text,
    data_criacao text,
    documentos_requerimento JSON
) AS $$
DECLARE data_criacao_aux date DEFAULT NULL;
BEGIN

    IF hashed_id_param IS NOT NULL AND hashed_id_param <> '' THEN
        IF NOT EXISTS(SELECT * FROM requerimento WHERE requerimento.hashed_id = hashed_id_param) THEN
            RAISE EXCEPTION 'Ocorreu um erro ao verificar o requerimento.';
        END IF;
    END IF;

    IF hashed_id_utente_param IS NOT NULL AND hashed_id_utente_param <> '' THEN
        IF NOT EXISTS(SELECT * FROM utente WHERE utente.hashed_id = hashed_id_utente_param) THEN
            RAISE EXCEPTION 'Ocorreu um erro ao verificar o utente.';
        END IF;
    END IF;

    IF data_criacao_param IS NOT NULL AND data_criacao_param <> '' THEN
        data_criacao_aux := converter_from_pt_to_iso(data_criacao_param);
    END IF;

    IF estado_param IS NOT NULL THEN
        IF estado_param < 0 OR estado_param > 6 THEN
            RAISE EXCEPTION 'O estado do requerimento não é válido.';
        END IF;
    END IF;

    IF tipo_requerimento_param IS NOT NULL THEN
        IF tipo_requerimento_param < 0 OR tipo_requerimento_param > 1 THEN
            RAISE EXCEPTION 'O tipo de requerimento não é válido.';
        END IF;
    END IF;

    RETURN QUERY SELECT
        requerimento.hashed_id,
        requerimento.numero_requerimento,
        requerimento.hashed_id AS hashed_id_utente,
        (
            SELECT json_build_object(
                'nome', utente.nome,
                'id_utente_rnu', utente.id_utente_rnu,
                'numero_utente', utente.numero_utente,
                'email_autenticacao', utente.email_autenticacao,
                'data_criacao', to_char(utente.data_criacao, 'DD/MM/YYYY'),
                'genero', utente.genero,
                'texto_genero', (
                    CASE
                        WHEN utente.genero = '1' THEN 'Masculino'
                        WHEN utente.genero = '2' THEN 'Feminino'
                        WHEN utente.genero = '3' THEN 'Não Divulgar'
                    END
                )
            ) FROM utente WHERE utente.id_utente = requerimento.id_utente
        ) AS informacao_utente,
        requerimento.tipo_documento,
        (
            CASE
                WHEN requerimento.tipo_documento = 0 THEN 'Cartão de Cidadão'
                WHEN requerimento.tipo_documento = 1 THEN 'Bilhete de Identidade'
            END
        ) AS texto_tipo_documento,
        requerimento.numero_documento,
        (
            CASE
                WHEN requerimento.data_emissao_documento IS NULL THEN NULL
                ELSE to_char(requerimento.data_emissao_documento, 'DD/MM/YYYY')
            END
        ) AS data_emissao_documento,
        requerimento.local_emissao_documento,
        to_char(requerimento.data_validade_documento, 'DD/MM/YYYY') AS data_validade_documento,
        requerimento.numero_contribuinte,
        to_char(requerimento.data_nascimento, 'DD/MM/YYYY') AS data_nascimento,
        (
            SELECT freguesia.nome FROM freguesia WHERE freguesia.id_freguesia = requerimento.id_freguesia_naturalidade
        ) AS nome_freguesia_naturalidade,
        (
            SELECT concelho.nome FROM concelho WHERE concelho.id_concelho = (
                SELECT freguesia.id_concelho FROM freguesia WHERE freguesia.id_freguesia = requerimento.id_freguesia_naturalidade
            )
        ) AS nome_concelho_naturalidade,
        (
            SELECT distrito.nome FROM distrito WHERE distrito.id_distrito = (
                SELECT concelho.id_distrito FROM concelho WHERE concelho.id_concelho = (
                    SELECT freguesia.id_concelho FROM freguesia WHERE freguesia.id_freguesia = requerimento.id_freguesia_naturalidade
                )
            )
        ) AS nome_distrito_naturalidade,
        (
            SELECT pais.nome FROM pais WHERE pais.id_pais = (
                SELECT distrito.id_pais FROM distrito WHERE distrito.id_distrito = (
                    SELECT concelho.id_distrito FROM concelho WHERE concelho.id_concelho = (
                        SELECT freguesia.id_concelho FROM freguesia WHERE freguesia.id_freguesia = requerimento.id_freguesia_naturalidade
                    )
                )
            )
        ) AS nome_pais_naturalidade,
        requerimento.morada,
        requerimento.codigo_postal,
        (
            SELECT freguesia.nome FROM freguesia WHERE freguesia.id_freguesia = requerimento.id_freguesia_residencia
        ) AS nome_freguesia_residencia,
        (
            SELECT concelho.nome FROM concelho WHERE concelho.id_concelho = (
                SELECT freguesia.id_concelho FROM freguesia WHERE freguesia.id_freguesia = requerimento.id_freguesia_residencia
            )
        ) AS nome_concelho_residencia,
        (
            SELECT distrito.nome FROM distrito WHERE distrito.id_distrito = (
                SELECT concelho.id_distrito FROM concelho WHERE concelho.id_concelho = (
                    SELECT freguesia.id_concelho FROM freguesia WHERE freguesia.id_freguesia = requerimento.id_freguesia_residencia
                )
            )
        ) AS nome_distrito_residencia,
        (
            SELECT pais.nome FROM pais WHERE pais.id_pais = (
                SELECT distrito.id_pais FROM distrito WHERE distrito.id_distrito = (
                    SELECT concelho.id_distrito FROM concelho WHERE concelho.id_concelho = (
                        SELECT freguesia.id_concelho FROM freguesia WHERE freguesia.id_freguesia = requerimento.id_freguesia_residencia
                    )
                )
            )
        ) AS nome_pais_residencia,
        requerimento.numero_telemovel,
        requerimento.numero_telefone,
        requerimento.email_preferencial,
        requerimento.tipo_requerimento,
        (
            CASE
                WHEN requerimento.tipo_requerimento = 0 THEN 'Multiuso'
                WHEN requerimento.tipo_requerimento = 1 THEN 'Importação de Veículo'
            END
        ) AS texto_tipo_requerimento,
        requerimento.primeira_submissao,
        (
            CASE
                WHEN requerimento.primeira_submissao = 0 THEN 'Não'
                WHEN requerimento.primeira_submissao = 1 THEN 'Sim'
            END
        ) AS texto_primeira_submissao,
        (
            CASE
                WHEN requerimento.data_submissao_anterior IS NULL THEN NULL
                ELSE to_char(requerimento.data_submissao_anterior, 'DD/MM/YYYY')
            END
        ) AS data_submissao_anterior,
        requerimento.estado,
        (
            CASE
                WHEN requerimento.estado = 0 THEN 'Pendente'
                WHEN requerimento.estado = 1 THEN 'Aguarda Avaliação'
                WHEN requerimento.estado = 2 THEN 'Avaliado'
                WHEN requerimento.estado = 3 THEN 'A Agendar'
                WHEN requerimento.estado = 4 THEN 'Agendado'
                WHEN requerimento.estado = 5 THEN 'Inválido'
                WHEN requerimento.estado = 6 THEN 'Cancelado'
            END
        ) AS texto_estado,
        to_char(requerimento.data_criacao, 'DD/MM/YYYY') AS data_criacao,
        (
            SELECT json_agg(
                json_build_object(
                    'hashed_id', documentos_requerimento.hashed_id,
                    'caminho_documento', documentos_requerimento.caminho_documento,
                    'nome_documento', documentos_requerimento.nome_documento
                )
            ) FROM documentos_requerimento WHERE documentos_requerimento.id_requerimento = requerimento.id_requerimento
        ) AS documentos_requerimento
    FROM requerimento
    WHERE
        (
            CASE
                WHEN hashed_id_param IS NULL THEN TRUE
                ELSE requerimento.hashed_id = hashed_id_param
            END
        )
        AND
        (
            CASE
                WHEN hashed_id_utente_param IS NULL THEN TRUE
                ELSE requerimento.id_utente = (
                    SELECT utente.id_utente FROM utente WHERE utente.hashed_id = hashed_id_utente_param
                )
            END
        )
        AND
        (
            CASE
                WHEN data_criacao_aux IS NULL THEN TRUE
                ELSE DATE(requerimento.data_criacao) = DATE(data_criacao_aux)
            END
        )
        AND
        (
            CASE
                WHEN estado_param IS NULL THEN TRUE
                ELSE requerimento.estado = estado_param
            END
        )
        AND
        (
            CASE
                WHEN tipo_requerimento_param IS NULL THEN TRUE
                ELSE requerimento.tipo_requerimento = tipo_requerimento_param
            END
        )
    ORDER BY requerimento.data_criacao ASC;

END;
$$ LANGUAGE plpgsql;


/**
    * Esta função permite inserir um Log de acesso a um requerimento.
    * @param {String} hashed_id_requerimento - O identificador do requerimento a ser inserido.
    * @param {String} hashed_id_utilizador - O identificador do utilizador a ser inserido.
    * @returns {Boolean} True se o Log de acesso for inserido, false caso contrário.
*/
/* CREATE TABLE
    historico_acesso_requerimento (
        id_requerimento bigint NOT NULL,
        id_utilizador bigint NOT NULL,
        data_hora_acesso timestamp NOT NULL
    );
ALTER TABLE historico_acesso_requerimento ALTER COLUMN data_hora_acesso SET DEFAULT CURRENT_TIMESTAMP; */
CREATE OR REPLACE FUNCTION inserir_log_acesso_requerimento(
    hashed_id_requerimento varchar(255),
    hashed_id_utilizador varchar(255)
)
RETURNS boolean AS $$
DECLARE
    id_requerimento integer;
    id_utilizador integer;
BEGIN 
    IF hashed_id_requerimento IS NULL OR hashed_id_requerimento = '' THEN
        RAISE EXCEPTION 'O identificador do requerimento não é válido.';
    ELSIF NOT EXISTS(SELECT * FROM requerimento WHERE requerimento.hashed_id = hashed_id_requerimento) THEN
        RAISE EXCEPTION 'Ocorreu um erro ao verificar o requerimento.';
    ELSE
        SELECT requerimento.id_requerimento INTO id_requerimento FROM requerimento WHERE requerimento.hashed_id = hashed_id_requerimento;
    END IF;

    IF hashed_id_utilizador IS NULL OR hashed_id_utilizador = '' THEN
        RAISE EXCEPTION 'O identificador do utilizador não é válido.';
    ELSIF NOT EXISTS(SELECT * FROM utilizador WHERE utilizador.hashed_id = hashed_id_utilizador) THEN
        RAISE EXCEPTION 'Ocorreu um erro ao verificar o utilizador.';
    ELSE
        SELECT utilizador.id_utlizador INTO id_utilizador FROM utilizador WHERE utilizador.hashed_id = hashed_id_utilizador;
    END IF;

    INSERT INTO historico_acesso_requerimento (
        id_requerimento,
        id_utilizador
    ) VALUES (
        id_requerimento,
        id_utilizador
    );

    RETURN TRUE;
END;
$$ LANGUAGE plpgsql;


/**
    * Esta função permite obter uma listagem de Logs de acesso a um requerimento.
    * @param {String} hashed_id_requerimento - O identificador do requerimento a ser obtido.
    * @param {Number} cargo_utilizador_param - O cargo do utilizador a ser obtido.
    * @returns {JSON} Os dados do Log de acesso obtido.
*/
CREATE OR REPLACE FUNCTION listar_log_acesso_requerimento(
    hashed_id_requerimento varchar(255),
    cargo_utilizador_param integer DEFAULT NULL
)
RETURNS TABLE (
    hashed_id_utilizador varchar(255),
    nome_utilizador varchar(255),
    cargo_utilizador integer,
    texto_cargo_utilizador text,
    data_hora_acesso text
) AS $$
BEGIN

    IF hashed_id_requerimento IS NULL OR hashed_id_requerimento = '' THEN
        RAISE EXCEPTION 'O identificador do requerimento não é válido.';
    ELSIF NOT EXISTS(SELECT * FROM requerimento WHERE requerimento.hashed_id = hashed_id_requerimento) THEN
        RAISE EXCEPTION 'Ocorreu um erro ao verificar o requerimento.';
    END IF;

    RETURN QUERY SELECT
        utilizador.hashed_id,
        utilizador.nome,
        utilizador.cargo,
        (
            CASE
                WHEN utilizador.cargo = 0 THEN 'Administrador'
                WHEN utilizador.cargo = 1 THEN 'Médico'
                WHEN utilizador.cargo = 2 THEN 'Rececionista'
            END
        ),
        to_char(historico_acesso_requerimento.data_hora_acesso, 'DD/MM/YYYY HH24:MI:SS')
    FROM historico_acesso_requerimento
    INNER JOIN utilizador ON utilizador.id_utlizador = historico_acesso_requerimento.id_utilizador
    WHERE historico_acesso_requerimento.id_requerimento = (
        SELECT requerimento.id_requerimento FROM requerimento WHERE requerimento.hashed_id = hashed_id_requerimento
    )
    AND
    (
        CASE
            WHEN cargo_utilizador_param IS NULL THEN TRUE
            ELSE utilizador.cargo = cargo_utilizador_param
        END
    )
    ORDER BY historico_acesso_requerimento.data_hora_acesso DESC;

END;
$$ LANGUAGE plpgsql;
        

