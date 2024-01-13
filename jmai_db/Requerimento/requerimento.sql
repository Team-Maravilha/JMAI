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
        PERFORM criar_contagem_requerimentos(data);
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
    estado_aux integer;
    texto_estado_aux text;
    numero_requerimento_anterior_aux varchar(255);
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

    IF primeira_submissao = 0 AND data_submissao_anterior IS NULL THEN
        RAISE EXCEPTION 'A data de submissão anterior não é válida.';
    ELSIF primeira_submissao = 0 THEN
        data_submissao_anterior_aux = converter_from_pt_to_iso(data_submissao_anterior);

        IF data_submissao_anterior_aux > CURRENT_DATE THEN
            RAISE EXCEPTION 'A data de submissão anterior tem de ser inferior à data atual.';
        END IF;
    END IF;

    IF email_preferencial IS NOT NULL AND email_preferencial <> '' THEN
        IF NOT email_preferencial ~ '^[A-Za-z0-9._%+-]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,}$' THEN
            RAISE EXCEPTION 'O email preferencial não é válido.';
        END IF;
    ELSE 
        email_preferencial = NULL;
    END IF;

    -- Verificar se o utente já tem um requerimento pendente
    IF EXISTS(SELECT * FROM requerimento WHERE requerimento.id_utente = id_utente_aux AND requerimento.estado < 4) THEN
        SELECT requerimento.estado INTO estado_aux FROM requerimento WHERE requerimento.id_utente = id_utente_aux AND requerimento.estado < 4 LIMIT 1;
        SELECT requerimento.numero_requerimento INTO numero_requerimento_anterior_aux FROM requerimento WHERE requerimento.id_utente = id_utente_aux AND requerimento.estado < 4 LIMIT 1;
        IF estado_aux = 0 THEN
            texto_estado_aux = 'Pendente';
        ELSIF estado_aux = 1 THEN
            texto_estado_aux = 'Aguarda Avaliação';
        ELSIF estado_aux = 2 THEN
            texto_estado_aux = 'Avaliado';
        ELSIF estado_aux = 3 THEN   
            texto_estado_aux = 'A Agendar';
        END IF;
        RAISE EXCEPTION 'O utente já tem um requerimento(%), com o estado %.', numero_requerimento_anterior_aux, texto_estado_aux;
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
    documentos_requerimento JSON,
    avaliacao JSON
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
        ) AS documentos_requerimento,
        (
            SELECT json_build_object(
                'id_utilizador', ar.id_utilizador,
                'nome_utilizador', (
                    SELECT utilizador.nome FROM utilizador WHERE utilizador.id_utlizador = ar.id_utilizador
                ),
                'data_avaliacao', to_char(ar.data_avaliacao, 'DD/MM/YYYY'),
                'grau_avaliacao', ar.grau_avaliacao,
                'notas', ar.notas
            ) FROM avaliacao_requerimento ar WHERE ar.id_requerimento = requerimento.id_requerimento
        ) AS avaliacao
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
        

/**
    * Esta função permite alterar o estado de um requerimento.
    * @param {String} hashed_id_requerimento - O identificador do requerimento a ser alterado.
    * @param {Number} estado_param - O estado do requerimento a ser alterado.
    * @returns {Boolean} True se o estado do requerimento for alterado, false caso contrário.
*/
CREATE OR REPLACE FUNCTION alterar_estado_requerimento(
    hashed_id_requerimento varchar(255),
    hashed_id_utilizador varchar(255),
    estado_param integer
)
RETURNS boolean AS $$
DECLARE
    id_requerimento_aux integer;
    id_utilizador_aux integer;
    estado_aux integer;
    texto_estado_aux text;
BEGIN
    
        IF hashed_id_requerimento IS NULL OR hashed_id_requerimento = '' THEN
            RAISE EXCEPTION 'O identificador do requerimento não é válido.';
        ELSIF NOT EXISTS(SELECT * FROM requerimento WHERE requerimento.hashed_id = hashed_id_requerimento) THEN
            RAISE EXCEPTION 'Ocorreu um erro ao verificar o requerimento.';
        ELSE
            SELECT requerimento.id_requerimento INTO id_requerimento_aux FROM requerimento WHERE requerimento.hashed_id = hashed_id_requerimento;
        END IF;

        IF hashed_id_utilizador IS NULL OR hashed_id_utilizador = '' THEN
            RAISE EXCEPTION 'O identificador do utilizador não é válido.';
        ELSIF NOT EXISTS(SELECT * FROM utilizador WHERE utilizador.hashed_id = hashed_id_utilizador) THEN
            RAISE EXCEPTION 'Ocorreu um erro ao verificar o utilizador.';
        ELSE
            SELECT utilizador.id_utlizador INTO id_utilizador_aux FROM utilizador WHERE utilizador.hashed_id = hashed_id_utilizador;
        END IF;

        IF estado_param IS NULL THEN
            RAISE EXCEPTION 'O estado do requerimento não é válido.';
        ELSIF estado_param < 0 OR estado_param > 6 THEN
            RAISE EXCEPTION 'O estado do requerimento não é válido.';
        END IF;

        SELECT requerimento.estado INTO estado_aux FROM requerimento WHERE requerimento.id_requerimento = id_requerimento_aux;

        IF estado_aux = estado_param THEN
            RAISE EXCEPTION 'O estado do requerimento não pode ser alterado.';
        END IF;

        IF estado_aux > estado_param THEN
            RAISE EXCEPTION 'O estado do requerimento não pode ser alterado.';
        END IF;

        IF estado_aux = 0 THEN
            texto_estado_aux := 'Pendente';
        ELSIF estado_aux = 1 THEN
            texto_estado_aux := 'Aguarda Avaliação';
        ELSIF estado_aux = 2 THEN
            texto_estado_aux := 'Avaliado';
        ELSIF estado_aux = 3 THEN
            texto_estado_aux := 'A Agendar';
        ELSIF estado_aux = 4 THEN
            texto_estado_aux := 'Agendado';
        ELSIF estado_aux = 5 THEN
            texto_estado_aux := 'Inválido';
        ELSIF estado_aux = 6 THEN
            texto_estado_aux := 'Cancelado';
        END IF;

        IF estado_param = 1 AND estado_aux <> 0 THEN
            RAISE EXCEPTION 'O estado do requerimento não pode ser alterado de % para Aguarda Avaliação.', texto_estado_aux;
        ELSIF estado_param = 2 AND estado_aux <> 1 THEN
            RAISE EXCEPTION 'O estado do requerimento não pode ser alterado de % para Avaliado.', texto_estado_aux;
        ELSIF estado_param = 3 AND estado_aux <> 2 THEN
            RAISE EXCEPTION 'O estado do requerimento não pode ser alterado de % para A Agendar.', texto_estado_aux;
        ELSIF estado_param = 4 AND estado_aux <> 3 THEN
            RAISE EXCEPTION 'O estado do requerimento não pode ser alterado de % para Agendado.', texto_estado_aux;
        ELSIF estado_param = 5 AND estado_aux <> 0 THEN
            RAISE EXCEPTION 'O estado do requerimento não pode ser alterado de % para Inválido.', texto_estado_aux;
        ELSIF estado_param = 6 AND estado_aux <> 2 THEN
            RAISE EXCEPTION 'O estado do requerimento não pode ser alterado de % para Cancelado.', texto_estado_aux;
        END IF;

        UPDATE requerimento SET estado = estado_param WHERE requerimento.id_requerimento = id_requerimento_aux;

        INSERT INTO historico_estados (
            id_requerimento,
            id_utilizador,
            estado_anterior,
            estado_novo
        ) VALUES (
            id_requerimento_aux,
            id_utilizador_aux,
            estado_aux,
            estado_param
        );

        RETURN TRUE;
    
    END;
$$ LANGUAGE plpgsql;


/**
    * Esta função permite rejeitar um requerimento.
    * @param {String} hashed_id_requerimento_param - O identificador do requerimento a ser obtido.
    * @param {String} hashed_id_utilizador_param - O identificador do utilizador a ser obtido.
    * @param {String} motivo_rejeicao_param - O motivo de rejeição a ser obtido.
    * @returns {Boolean} True se o requerimento for rejeitado, false caso contrário.
*/
CREATE OR REPLACE FUNCTION rejeitar_requerimento(
    hashed_id_requerimento_param varchar(255),
    hashed_id_utilizador_param varchar(255),
    motivo_rejeicao_param varchar(255)
)
RETURNS TABLE (
    nome varchar(255),
    email_preferencial varchar(255)
) AS $$
DECLARE
    id_requerimento_aux integer;
    id_utilizador_aux integer;
    estado_aux integer;
    email_preferencial_aux VARCHAR(255);
    nome_aux VARCHAR(255);
BEGIN

    IF hashed_id_requerimento_param IS NULL OR hashed_id_requerimento_param = '' THEN
        RAISE EXCEPTION 'O identificador do requerimento não é válido.';
    ELSIF NOT EXISTS(SELECT * FROM requerimento WHERE requerimento.hashed_id = hashed_id_requerimento_param) THEN
        RAISE EXCEPTION 'Ocorreu um erro ao verificar o requerimento.';
    ELSE
        SELECT requerimento.id_requerimento INTO id_requerimento_aux FROM requerimento WHERE requerimento.hashed_id = hashed_id_requerimento_param;
    END IF;

    IF hashed_id_utilizador_param IS NULL OR hashed_id_utilizador_param = '' THEN
        RAISE EXCEPTION 'O identificador do utilizador não é válido.';
    ELSIF NOT EXISTS(SELECT * FROM utilizador WHERE utilizador.hashed_id = hashed_id_utilizador_param) THEN
        RAISE EXCEPTION 'Ocorreu um erro ao verificar o utilizador.';
    ELSE
        SELECT utilizador.id_utlizador INTO id_utilizador_aux FROM utilizador WHERE utilizador.hashed_id = hashed_id_utilizador_param;
    END IF;

    SELECT requerimento.estado INTO estado_aux FROM requerimento WHERE requerimento.id_requerimento = id_requerimento_aux;

    SELECT requerimento.email_preferencial INTO email_preferencial_aux FROM requerimento WHERE requerimento.id_requerimento = id_requerimento_aux;
    IF email_preferencial_aux IS NULL OR email_preferencial_aux = '' THEN
        email_preferencial_aux := (
            SELECT utente.email_autenticacao FROM utente WHERE utente.id_utente = (
                SELECT requerimento.id_utente FROM requerimento WHERE requerimento.id_requerimento = id_requerimento_aux
            )
        );
    END IF;

    SELECT utente.nome INTO nome_aux FROM utente WHERE utente.id_utente = (
        SELECT requerimento.id_utente FROM requerimento WHERE requerimento.id_requerimento = id_requerimento_aux
    );

    IF motivo_rejeicao_param IS NULL OR motivo_rejeicao_param = '' THEN
        RAISE EXCEPTION 'O motivo de rejeição não é válido.';
    END IF;

    IF estado_aux <> 0 THEN
        RAISE EXCEPTION 'O requerimento não está no estado Pendente.';
    END IF;

    PERFORM alterar_estado_requerimento(hashed_id_requerimento_param, hashed_id_utilizador_param, 5);

    UPDATE requerimento SET motivo_rejeicao = motivo_rejeicao_param WHERE requerimento.id_requerimento = id_requerimento_aux;

    RETURN QUERY SELECT nome_aux, email_preferencial_aux;

END;
$$ LANGUAGE plpgsql;


/**
    * Esta função permite avaliar um requerimento.
    * @param {String} hashed_id_requerimento - O identificador do requerimento a ser avaliado.
    * @param {String} hashed_id_utilizador - O identificador do utilizador a ser avaliado.
    * @param {Number} grau_avaliacao - O grau de avaliação a ser avaliado.
    * @returns {Boolean} True se o requerimento for avaliado, false caso contrário.
*/
CREATE OR REPLACE FUNCTION avaliar_requerimento(
    hashed_id_requerimento varchar(255),
    hashed_id_utilizador varchar(255),
    grau_avaliacao float,
    notas_avaliacao varchar(255) DEFAULT NULL
)
RETURNS TABLE (
    status boolean,
	nome varchar(255),
    email_preferencial varchar(255),
    numero_telemovel integer,
    id_notificacao integer
) AS $$
DECLARE
    id_requerimento_aux integer;
    id_utilizador_aux integer;
    estado_aux integer;
    email_preferencial_aux varchar(255) DEFAULT NULL;
    nome_aux varchar(255);
    numero_telemovel_aux integer;
    id_notificacao_aux integer;
BEGIN 

    IF hashed_id_requerimento IS NULL OR hashed_id_requerimento = '' THEN
        RAISE EXCEPTION 'O identificador do requerimento não é válido.';
    ELSIF NOT EXISTS(SELECT * FROM requerimento WHERE requerimento.hashed_id = hashed_id_requerimento) THEN
        RAISE EXCEPTION 'Ocorreu um erro ao verificar o requerimento.';
    ELSE
        SELECT requerimento.id_requerimento INTO id_requerimento_aux FROM requerimento WHERE requerimento.hashed_id = hashed_id_requerimento;
    END IF;

    IF hashed_id_utilizador IS NULL OR hashed_id_utilizador = '' THEN
        RAISE EXCEPTION 'O identificador do utilizador não é válido.';
    ELSIF NOT EXISTS(SELECT * FROM utilizador WHERE utilizador.hashed_id = hashed_id_utilizador) THEN
        RAISE EXCEPTION 'Ocorreu um erro ao verificar o utilizador.';
    ELSE
        SELECT utilizador.id_utlizador INTO id_utilizador_aux FROM utilizador WHERE utilizador.hashed_id = hashed_id_utilizador;
    END IF;

    IF grau_avaliacao IS NULL THEN
        RAISE EXCEPTION 'O grau de avaliação não é válido.';
    ELSIF grau_avaliacao < 0 OR grau_avaliacao > 100 THEN
        RAISE EXCEPTION 'O grau de avaliação não é válido.';
    END IF;

    -- CHECK IF REQUERIMENTO IS IN AGUARDA AVALIAÇÃO
    SELECT requerimento.estado INTO estado_aux FROM requerimento WHERE requerimento.id_requerimento = id_requerimento_aux;
    IF estado_aux <> 1 THEN
        RAISE EXCEPTION 'O requerimento não está no estado Aguarda Avaliação.';
    END IF;

    PERFORM alterar_estado_requerimento(hashed_id_requerimento, hashed_id_utilizador, 2);

    SELECT requerimento.email_preferencial INTO email_preferencial_aux FROM requerimento WHERE requerimento.id_requerimento = id_requerimento_aux;
    SELECT requerimento.numero_telemovel INTO numero_telemovel_aux FROM requerimento WHERE requerimento.id_requerimento = id_requerimento_aux;

    IF email_preferencial_aux IS NULL OR email_preferencial_aux = '' THEN
        email_preferencial_aux := (
            SELECT utente.email_autenticacao FROM utente WHERE utente.id_utente = (
                SELECT requerimento.id_utente FROM requerimento WHERE requerimento.id_requerimento = id_requerimento_aux
            )
        );
    END IF;

    SELECT utente.nome INTO nome_aux FROM utente WHERE utente.id_utente = (
        SELECT requerimento.id_utente FROM requerimento WHERE requerimento.id_requerimento = id_requerimento_aux
    );

    INSERT INTO avaliacao_requerimento (
        id_requerimento,
        id_utilizador,
        grau_avaliacao,
        notas
    ) VALUES (
        id_requerimento_aux,
        id_utilizador_aux,
        grau_avaliacao,
        notas_avaliacao
    );

    CREATE TEMP TABLE temp_notificacao ON COMMIT DROP AS
        SELECT * FROM notificar_avaliacao_requerimento(hashed_id_requerimento);

    SELECT temp_notificacao.id_notificacao INTO id_notificacao_aux FROM temp_notificacao;

    RETURN QUERY SELECT TRUE, nome_aux, email_preferencial_aux, numero_telemovel_aux, id_notificacao_aux;

END;
$$ LANGUAGE plpgsql;


/**
    * Esta função permite obter uma listagem de alterações de estado de um requerimento.
    * @param {String} hashed_id_requerimento - O identificador do requerimento a ser obtido.
    * @returns {JSON} Os dados da avaliação obtida.
*/
CREATE OR REPLACE FUNCTION listar_alteracoes_estado_requerimento(
    hashed_id_requerimento varchar(255)
)
RETURNS TABLE (
    nome_utilizador varchar(255),
    estado_anterior integer,
    texto_estado_anterior text,
    estado_novo integer,
    texto_estado_novo text,
    data_hora_alteracao text
) AS $$
BEGIN

    IF hashed_id_requerimento IS NULL OR hashed_id_requerimento = '' THEN
        RAISE EXCEPTION 'O identificador do requerimento não é válido.';
    ELSIF NOT EXISTS(SELECT * FROM requerimento WHERE requerimento.hashed_id = hashed_id_requerimento) THEN
        RAISE EXCEPTION 'Ocorreu um erro ao verificar o requerimento.';
    END IF;

    RETURN QUERY SELECT
        (
            CASE WHEN historico_estados.id_utilizador IS NULL THEN 
                CONCAT(
                    (
                        SELECT utente.nome FROM utente WHERE utente.id_utente = (
                            SELECT requerimento.id_utente FROM requerimento WHERE requerimento.hashed_id = hashed_id_requerimento
                        )
                    ),
                    ' (Utente)'
                )
            ELSE
                (
                    SELECT utilizador.nome FROM utilizador WHERE utilizador.id_utlizador = historico_estados.id_utilizador
                )
            END
        ),
        historico_estados.estado_anterior,
        (
            CASE
                WHEN historico_estados.estado_anterior = 0 THEN 'Pendente'
                WHEN historico_estados.estado_anterior = 1 THEN 'Aguarda Avaliação'
                WHEN historico_estados.estado_anterior = 2 THEN 'Avaliado'
                WHEN historico_estados.estado_anterior = 3 THEN 'A Agendar'
                WHEN historico_estados.estado_anterior = 4 THEN 'Agendado'
                WHEN historico_estados.estado_anterior = 5 THEN 'Inválido'
                WHEN historico_estados.estado_anterior = 6 THEN 'Cancelado'
            END
        ),
        historico_estados.estado_novo,
        (
            CASE
                WHEN historico_estados.estado_novo = 0 THEN 'Pendente'
                WHEN historico_estados.estado_novo = 1 THEN 'Aguarda Avaliação'
                WHEN historico_estados.estado_novo = 2 THEN 'Avaliado'
                WHEN historico_estados.estado_novo = 3 THEN 'A Agendar'
                WHEN historico_estados.estado_novo = 4 THEN 'Agendado'
                WHEN historico_estados.estado_novo = 5 THEN 'Inválido'
                WHEN historico_estados.estado_novo = 6 THEN 'Cancelado'
            END
        ),
        to_char(historico_estados.data_alteracao, 'DD/MM/YYYY HH24:MI:SS')
    FROM historico_estados
    WHERE historico_estados.id_requerimento = (
        SELECT requerimento.id_requerimento FROM requerimento WHERE requerimento.hashed_id = hashed_id_requerimento
    )
    ORDER BY historico_estados.data_alteracao DESC;

END;
$$ LANGUAGE plpgsql;

/**
    * Esta função permite notificar o utente de uma avaliação de um requerimento.
    * @param {String} hashed_id_requerimento - O identificador do requerimento a ser notificado.
    * @returns {Table} Os dados da avaliação obtida.
*/
CREATE OR REPLACE FUNCTION notificar_avaliacao_requerimento(
    hashed_id_requerimento varchar(255)
)
RETURNS TABLE (
    id_notificacao bigint
) AS $$
DECLARE
    id_requerimento_aux integer;
    id_notificacao bigint;
BEGIN
    
        IF hashed_id_requerimento IS NULL OR hashed_id_requerimento = '' THEN
            RAISE EXCEPTION 'O identificador do requerimento não é válido.';
        ELSIF NOT EXISTS(SELECT * FROM requerimento WHERE requerimento.hashed_id = hashed_id_requerimento) THEN
            RAISE EXCEPTION 'Ocorreu um erro ao verificar o requerimento.';
        ELSE
            SELECT requerimento.id_requerimento INTO id_requerimento_aux FROM requerimento WHERE requerimento.hashed_id = hashed_id_requerimento;
        END IF;
    
        SELECT notificacar_utente.id_notificacao INTO id_notificacao FROM notificacar_utente WHERE notificacar_utente.id_requerimento = id_requerimento_aux;
    
        IF id_notificacao IS NULL THEN
            INSERT INTO notificacar_utente (
                id_requerimento
            ) VALUES (
                id_requerimento_aux
            ) RETURNING notificacar_utente.id_notificacao INTO id_notificacao;
        END IF;
    
        RETURN QUERY SELECT id_notificacao;
    
    END;
$$ LANGUAGE plpgsql;


/**
    * Esta função permite associar uma via de comunicação a uma notificação.
    * @param {Numeric} id_notificacao - O identificador da notificação a ser associada.
    * @param {Numeric} tipo - O tipo de via de comunicação a ser associada.
    * @param {String} assunto - O assunto da via de comunicação a ser associada.
    * @param {String} mensagem - A mensagem da via de comunicação a ser associada.
    * @returns {Boolean} True se a via de comunicação for associada, false caso contrário.
*/
CREATE OR REPLACE FUNCTION comunicar_utente(
    id_notificacao bigint,
    tipo integer,
    assunto varchar(255),
    mensagem varchar(255)
)
RETURNS boolean AS $$
DECLARE
    id_notificacao_aux bigint;
BEGIN

    IF id_notificacao IS NULL THEN
        RAISE EXCEPTION 'O identificador da notificação não é válido.';
    ELSIF NOT EXISTS(SELECT * FROM notificacar_utente WHERE notificacar_utente.id_notificacao = id_notificacao) THEN
        RAISE EXCEPTION 'Ocorreu um erro ao verificar a notificação.';
    ELSE
        SELECT notificacar_utente.id_notificacao INTO id_notificacao_aux FROM notificacar_utente WHERE notificacar_utente.id_notificacao = id_notificacao;
    END IF;

    IF tipo IS NULL THEN
        RAISE EXCEPTION 'O tipo de via de comunicação não é válido.';
    ELSIF tipo < 0 OR tipo > 1 THEN
        RAISE EXCEPTION 'O tipo de via de comunicação não é válido.';
    END IF;

    INSERT INTO comunicar_utente (
        id_notificacao,
        tipo,
        assunto,
        mensagem
    ) VALUES (
        id_notificacao_aux,
        tipo,
        assunto,
        mensagem
    );

    RETURN TRUE;

END;
$$ LANGUAGE plpgsql;


/**
    * Esta função permite ao utente responder à comunicação de um requerimento.
    * @param {String} hashed_id_requerimento - O identificador do requerimento a ser respondido.
    * @param {Number} resposta - A resposta do utente.
    * @returns {Boolean} True se a resposta for inserida, false caso contrário.
*/
CREATE OR REPLACE FUNCTION responder_comunicacao_utente(
    hashed_id_requerimento varchar(255),
    resposta integer
)
RETURNS boolean AS $$
DECLARE
    id_requerimento_aux integer;
    id_notificacao_aux bigint;
    id_comunicacao_utente_aux bigint;
    estado_aux integer;
BEGIN
    
        IF hashed_id_requerimento IS NULL OR hashed_id_requerimento = '' THEN
            RAISE EXCEPTION 'O identificador do requerimento não é válido.';
        ELSIF NOT EXISTS(SELECT * FROM requerimento WHERE requerimento.hashed_id = hashed_id_requerimento) THEN
            RAISE EXCEPTION 'Ocorreu um erro ao verificar o requerimento.';
        ELSE
            SELECT requerimento.id_requerimento INTO id_requerimento_aux FROM requerimento WHERE requerimento.hashed_id = hashed_id_requerimento;
            SELECT requerimento.estado INTO estado_aux FROM requerimento WHERE requerimento.hashed_id = hashed_id_requerimento;
        END IF;

        IF estado_aux <> 2 THEN
            RAISE EXCEPTION 'O requerimento não está no estado Avaliado.';
        END IF;
    
        SELECT notificacar_utente.id_notificacao INTO id_notificacao_aux FROM notificacar_utente WHERE notificacar_utente.id_requerimento = id_requerimento_aux;
    
        IF id_notificacao_aux IS NULL THEN
            RAISE EXCEPTION 'Ocorreu um erro ao verificar a notificação.';
        END IF;
    
        IF resposta IS NULL THEN
            RAISE EXCEPTION 'A resposta não é válida.';
        ELSIF resposta < 0 OR resposta > 1 THEN
            RAISE EXCEPTION 'A resposta não é válida.';
        END IF;
    
        UPDATE notificacar_utente SET resposta = responder_comunicacao_utente.resposta, data_resposta = CURRENT_TIMESTAMP WHERE notificacar_utente.id_notificacao = id_notificacao_aux;

        IF resposta = 1 THEN
            UPDATE requerimento SET estado = 3 WHERE id_requerimento = id_requerimento_aux;

            INSERT INTO historico_estados (
                id_requerimento,
                id_utilizador,
                estado_anterior,
                estado_novo
            ) VALUES (
                id_requerimento_aux,
                NULL,
                2,
                3
            );
        ELSIF resposta = 0 THEN
            UPDATE requerimento SET estado = 6 WHERE id_requerimento = id_requerimento_aux;

            INSERT INTO historico_estados (
                id_requerimento,
                id_utilizador,
                estado_anterior,
                estado_novo
            ) VALUES (
                id_requerimento_aux,
                NULL,
                2,
                6
            );
        END IF;

        RETURN TRUE;

END;
$$ LANGUAGE plpgsql;


/**
    * Esta função permite obter uma listagem de comunicações de um requerimento.
    * @param {String} hashed_id_requerimento - O identificador do requerimento a ser obtido.
    * @returns {JSON} Os dados da comunicação obtida.
*/
CREATE OR REPLACE FUNCTION listar_comunicacoes_requerimento(
    hashed_id_requerimento varchar(255)
)
RETURNS TABLE (
    tipo integer,
    texto_tipo text,
    assunto varchar(255),
    mensagem varchar(255),
    data_hora_comunicacao text
) AS $$
DECLARE
    id_requerimento_aux integer;
    id_notificacao_aux bigint;
BEGIN

    IF hashed_id_requerimento IS NULL OR hashed_id_requerimento = '' THEN
        RAISE EXCEPTION 'O identificador do requerimento não é válido.';
    ELSIF NOT EXISTS(SELECT * FROM requerimento WHERE requerimento.hashed_id = hashed_id_requerimento) THEN
        RAISE EXCEPTION 'Ocorreu um erro ao verificar o requerimento';
    END IF;

    SELECT requerimento.id_requerimento INTO id_requerimento_aux FROM requerimento WHERE requerimento.hashed_id = hashed_id_requerimento;

    SELECT notificacar_utente.id_notificacao INTO id_notificacao_aux FROM notificacar_utente WHERE notificacar_utente.id_requerimento = id_requerimento_aux;

    IF id_notificacao_aux IS NULL THEN
        RAISE EXCEPTION 'Não existem comunicações para o requerimento.';
    END IF;

    RETURN QUERY SELECT 
        cu.tipo,
        (
            CASE
                WHEN cu.tipo = 0 THEN 'Email'
                WHEN cu.tipo = 1 THEN 'SMS'
            END
        ),
        cu.assunto,
        cu.mensagem,
        to_char(cu.data_comunicacao, 'DD/MM/YYYY HH24:MI:SS')
    FROM comunicar_utente AS cu
    WHERE cu.id_notificacao = id_notificacao_aux
    ORDER BY cu.data_comunicacao DESC;

END;
$$ LANGUAGE plpgsql;


/**
    * Esta função permite obter agendar um requerimento.
    * @param {String} hashed_id_requerimento - O identificador do requerimento a ser agendado.
    * @param {String} hashed_id_utilizador - O identificador do utilizador a ser agendado.
    * @param {String} data_agendamento - A data do agendamento a ser agendado.
    * @param {String} hora_agendamento - A hora do agendamento a ser agendado.
    * @param {String} hashed_id_equipa_medica - O identificador da equipa médica a ser agendado.
    * @returns {Table} O hashed_id do agendamento obtido.
*/
CREATE OR REPLACE FUNCTION agendar_consulta_requerimento(
    hashed_id_requerimento_param varchar(255),
    hashed_id_utilizador_param varchar(255),
    data_agendamento_param varchar(255),
    hora_agendamento_param time,
    hashed_id_equipa_medica_param varchar(255)
)
RETURNS TABLE (
    hashed_id_agendamento varchar(255),
    nome varchar(255),
    email_preferencial varchar(255)
) AS $$
DECLARE
    id_requerimento_aux integer;
    id_utilizador_aux integer;
    id_equipa_medica_aux integer;
    data_ageendamento_aux timestamp;
    estado_aux integer;
    nome_aux varchar(255);
    email_preferencial_aux varchar(255);
    hashed_id_aux varchar(255);
BEGIN
    
    IF hashed_id_requerimento_param IS NULL OR hashed_id_requerimento_param = '' THEN
        RAISE EXCEPTION 'O identificador do requerimento não é válido.';
    ELSIF NOT EXISTS(SELECT * FROM requerimento WHERE requerimento.hashed_id = hashed_id_requerimento_param) THEN
        RAISE EXCEPTION 'Ocorreu um erro ao verificar o requerimento.';
    ELSE
        SELECT requerimento.id_requerimento INTO id_requerimento_aux FROM requerimento WHERE requerimento.hashed_id = hashed_id_requerimento_param;
        SELECT requerimento.estado INTO estado_aux FROM requerimento WHERE requerimento.hashed_id = hashed_id_requerimento_param;
    END IF;

    IF hashed_id_utilizador_param IS NULL OR hashed_id_utilizador_param = '' THEN
        RAISE EXCEPTION 'O identificador do utilizador não é válido.';
    ELSIF NOT EXISTS(SELECT * FROM utilizador WHERE utilizador.hashed_id = hashed_id_utilizador_param) THEN
        RAISE EXCEPTION 'Ocorreu um erro ao verificar o utilizador.';
    ELSE
        SELECT utilizador.id_utlizador INTO id_utilizador_aux FROM utilizador WHERE utilizador.hashed_id = hashed_id_utilizador_param;
    END IF;

    IF estado_aux <> 3 THEN
        RAISE EXCEPTION 'O requerimento não está no estado A Agendar.';
    END IF;

    IF data_agendamento_param IS NULL OR data_agendamento_param = '' THEN
        RAISE EXCEPTION 'A data do agendamento não é válida.';
    ELSIF data_agendamento_param ~ '^[0-9]{2}/[0-9]{2}/[0-9]{4}$' = FALSE THEN
        RAISE EXCEPTION 'A data do agendamento não é válida.';
    ELSE
        data_ageendamento_aux := converter_from_pt_to_iso(data_agendamento_param);
    END IF;

    IF hora_agendamento_param IS NULL THEN
        RAISE EXCEPTION 'A hora do agendamento não é válida.';
    END IF;

    IF hashed_id_equipa_medica_param IS NULL OR hashed_id_equipa_medica_param = '' THEN
        RAISE EXCEPTION 'O identificador da equipa médica não é válido.';
    ELSIF NOT EXISTS(SELECT * FROM equipa_medica WHERE equipa_medica.hashed_id = hashed_id_equipa_medica_param) THEN
        RAISE EXCEPTION 'Ocorreu um erro ao verificar a equipa médica.';
    ELSE
        SELECT equipa_medica.id_equipa_medica INTO id_equipa_medica_aux FROM equipa_medica WHERE equipa_medica.hashed_id = hashed_id_equipa_medica_param;
    END IF;

    SELECT requerimento.email_preferencial INTO email_preferencial_aux FROM requerimento WHERE requerimento.id_requerimento = id_requerimento_aux;
    IF email_preferencial_aux IS NULL OR email_preferencial_aux = '' THEN
        email_preferencial_aux := (
            SELECT utente.email_autenticacao FROM utente WHERE utente.id_utente = (
                SELECT requerimento.id_utente FROM requerimento WHERE requerimento.id_requerimento = id_requerimento_aux
            )
        );
    END IF;

    SELECT utente.nome INTO nome_aux FROM utente WHERE utente.id_utente = (
        SELECT requerimento.id_utente FROM requerimento WHERE requerimento.id_requerimento = id_requerimento_aux
    );

    INSERT INTO agendamento_consulta (
        id_requerimento,
        id_utilizador,
        data_agendamento,
        hora_agendamento,
        id_equipa_medica
    ) VALUES (
        id_requerimento_aux,
        id_utilizador_aux,
        data_ageendamento_aux,
        hora_agendamento_param,
        id_equipa_medica_aux
    );

    PERFORM alterar_estado_requerimento(hashed_id_requerimento_param, hashed_id_utilizador_param, 4);

    SELECT hashed_id INTO hashed_id_aux FROM agendamento_consulta WHERE agendamento_consulta.id_requerimento = id_requerimento_aux; 

    RETURN QUERY SELECT hashed_id_aux, nome_aux, email_preferencial_aux;

END;
$$ LANGUAGE plpgsql;


/**
    * Adicionar o HashedID a um agendamento de consulta.
    */
CREATE TRIGGER add_uuid_agendamento_consulta BEFORE INSERT ON agendamento_consulta FOR EACH ROW EXECUTE PROCEDURE add_uuid();


/**
    * Esta função permite obter uma listagem de agendamentos de consulta.
    * @param {String} hashed_id_requerimento_param - O identificador do requerimento a ser obtido.
    * @param {String} hashed_id_utente_param - O identificador do utente a ser obtido.
    * @param {String} data_agendamento_param - A data do agendamento a ser obtido.
    * @returns {JSON} Os dados do agendamento obtido.
*/
CREATE OR REPLACE FUNCTION listar_agendamentos_consulta(
    hashed_id_requerimento_param varchar(255) DEFAULT NULL,
    hashed_id_utente_param varchar(255) DEFAULT NULL,
    data_inicio_agendamento_param varchar(255) DEFAULT NULL,
    data_fim_agendamento_param varchar(255) DEFAULT NULL
)
RETURNS TABLE (
    hashed_id varchar(255),
    utente JSON,
    data_agendamento text,
    hora_agendamento text,
    duracao_consulta integer,
    data_fim_agendamento text,
    hora_fim_agendamento text,
    equipa_medica JSON,
    tipo_requerimento integer,
    texto_tipo_requerimento text
) AS $$

DECLARE
    id_requerimento_aux integer;
    id_utente_aux integer;
    data_inicio_agendamento_aux timestamp;
    data_fim_agendamento_aux timestamp;
    id_equipa_medica_aux integer;
    tipo_requerimento_aux integer;
BEGIN

    IF hashed_id_requerimento_param IS NOT NULL AND hashed_id_requerimento_param <> '' THEN
        IF NOT EXISTS(SELECT * FROM requerimento WHERE requerimento.hashed_id = hashed_id_requerimento_param) THEN
            RAISE EXCEPTION 'Ocorreu um erro ao verificar o requerimento.';
        ELSE
            SELECT requerimento.id_requerimento INTO id_requerimento_aux FROM requerimento WHERE requerimento.hashed_id = hashed_id_requerimento_param;
        END IF;
    END IF;

    IF hashed_id_utente_param IS NOT NULL AND hashed_id_utente_param <> '' THEN
        IF NOT EXISTS(SELECT * FROM utente WHERE utente.hashed_id = hashed_id_utente_param) THEN
            RAISE EXCEPTION 'Ocorreu um erro ao verificar o utente.';
        ELSE
            SELECT utente.id_utente INTO id_utente_aux FROM utente WHERE utente.hashed_id = hashed_id_utente_param;
        END IF;
    END IF;

    IF data_inicio_agendamento_param IS NOT NULL AND data_inicio_agendamento_param <> '' THEN
        IF data_inicio_agendamento_param ~ '^[0-9]{2}/[0-9]{2}/[0-9]{4}$' = FALSE THEN
            RAISE EXCEPTION 'A data do agendamento não é válida.';
        ELSE
            data_inicio_agendamento_aux := converter_from_pt_to_iso(data_inicio_agendamento_param);
        END IF;
    END IF;

    IF data_fim_agendamento_param IS NOT NULL AND data_fim_agendamento_param <> '' THEN
        IF data_fim_agendamento_param ~ '^[0-9]{2}/[0-9]{2}/[0-9]{4}$' = FALSE THEN
            RAISE EXCEPTION 'A data do agendamento não é válida.';
        ELSE
            data_fim_agendamento_aux := converter_from_pt_to_iso(data_fim_agendamento_param);
        END IF;
    END IF;

    RETURN QUERY SELECT
        agendamento_consulta.hashed_id,
        (
            SELECT json_build_object(
                'hashed_id', utente.hashed_id,
                'nome', utente.nome,
                'numero_utente', utente.numero_utente,
                'email_autenticacao', utente.email_autenticacao
            ) FROM utente WHERE utente.id_utente = (
                SELECT requerimento.id_utente FROM requerimento WHERE requerimento.id_requerimento = agendamento_consulta.id_requerimento
            )
        ),
        to_char(agendamento_consulta.data_agendamento, 'DD/MM/YYYY'),
        to_char(agendamento_consulta.hora_agendamento, 'HH24:MI:SS'),
        60,
        to_char(agendamento_consulta.data_agendamento, 'DD/MM/YYYY'),
        --ADD 60 MINUTES TO TIME
        to_char(agendamento_consulta.hora_agendamento + INTERVAL '60 MINUTE', 'HH24:MI:SS'),
        (
            SELECT json_build_object(
                'hashed_id', equipa_medica.hashed_id,
                'nome', equipa_medica.nome,
                'medicos', (
                    SELECT json_agg(
                        json_build_object(
                            'nome', u_m.nome
                        )
                    ) FROM equipa_medica_medicos
					INNER JOIN utilizador u_m ON equipa_medica_medicos.id_utilizador = u_m.id_utlizador
					WHERE equipa_medica_medicos.id_equipa_medica = equipa_medica.id_equipa_medica
                )
            ) FROM equipa_medica WHERE equipa_medica.id_equipa_medica = agendamento_consulta.id_equipa_medica
        ),
        (
            SELECT requerimento.tipo_requerimento FROM requerimento WHERE requerimento.id_requerimento = agendamento_consulta.id_requerimento
        ),
        (
            SELECT
                CASE
                    WHEN requerimento.tipo_requerimento = 0 THEN 'Multiuso'
                    WHEN requerimento.tipo_requerimento = 1 THEN 'Importação de Veículo'
                    ElSE 'Não definido'
                END
			FROM requerimento WHERE requerimento.id_requerimento = agendamento_consulta.id_requerimento
        )
    FROM agendamento_consulta
    WHERE
        (
            CASE
                WHEN id_requerimento_aux IS NULL THEN TRUE
                ELSE agendamento_consulta.id_requerimento = id_requerimento_aux
            END
        )
        AND
        (
            CASE
                WHEN id_utente_aux IS NULL THEN TRUE
                ELSE id_utente_aux = (
					SELECT requerimento.id_utente FROM requerimento WHERE requerimento.id_requerimento = agendamento_consulta.id_requerimento
				)
            END
        )
        AND
        (
            CASE
                WHEN data_inicio_agendamento_aux IS NULL THEN TRUE
                ELSE agendamento_consulta.data_agendamento >= data_inicio_agendamento_aux
            END
        )
        AND
        (
            CASE
                WHEN data_fim_agendamento_param IS NULL THEN TRUE
                ELSE agendamento_consulta.data_agendamento <= data_fim_agendamento_aux
            END
        )
    ORDER BY agendamento_consulta.data_agendamento DESC;

END;
$$ LANGUAGE plpgsql;


/**
    * Esta função permite obter uma listagem de requerimentos por distrito de pais.
    * @param {Number} id_pais - O identificador do país a ser obtido.
    * @param {Date} data_inicio - A data de início a ser obtida.
    * @param {Date} data_fim - A data de fim a ser obtida.
    * @returns {JSON} Os dados do país obtido.
*/
CREATE OR REPLACE FUNCTION listar_contagem_requerimentos_por_distrito(
    id_pais bigint,
    data_inicio text,
    data_fim text
)
RETURNS TABLE (
    nome_distrito varchar(255),
    total_requerimentos bigint
) AS $$
DECLARE
    data_inicio_aux date;
    data_fim_aux date;

BEGIN
    
    IF id_pais IS NULL THEN
        RAISE EXCEPTION 'O identificador do país não é válido.';
    ELSIF NOT EXISTS(SELECT 1 FROM pais WHERE pais.id_pais = listar_contagem_requerimentos_por_distrito.id_pais) THEN
        RAISE EXCEPTION 'Ocorreu um erro ao verificar o país.';
    END IF;

    IF data_inicio IS NULL THEN
        RAISE EXCEPTION 'A data de início não é válida.';
    ELSIF NOT data_inicio ~ '^[0-9]{4}-[0-9]{2}-[0-9]{2}$' THEN
        RAISE EXCEPTION 'A data de início não é válida.';
    ELSE
        data_inicio_aux := data_inicio::date;
    END IF;

    IF data_fim IS NULL THEN
        RAISE EXCEPTION 'A data de fim não é válida.';
    ELSIF NOT data_fim ~ '^[0-9]{4}-[0-9]{2}-[0-9]{2}$' THEN
        RAISE EXCEPTION 'A data de fim não é válida.';
    ELSE
        data_fim_aux := data_fim::date;
    END IF;

    RETURN QUERY SELECT
        d.nome AS nome_distrito,
        COALESCE(SUM(CASE WHEN r.id_requerimento IS NOT NULL THEN 1 ELSE 0 END), 0) AS total_requerimentos
    FROM
        distrito d
        LEFT JOIN concelho c ON d.id_distrito = c.id_distrito
        LEFT JOIN freguesia f ON c.id_concelho = f.id_concelho
        LEFT JOIN requerimento r ON f.id_freguesia = r.id_freguesia_residencia AND r.data_criacao >= data_inicio_aux AND r.data_criacao <= data_fim_aux
    WHERE
        d.id_pais = listar_contagem_requerimentos_por_distrito.id_pais
    GROUP BY
        d.nome
    ORDER BY
        d.nome ASC;

END;
$$ LANGUAGE plpgsql;


/**
    * Esta função permite obter uma listagem de requerimentos por concelho de distrito.
    * @param {Number} id_distrito - O identificador do distrito a ser obtido.
    * @param {Date} data_inicio - A data de início a ser obtida.
    * @param {Date} data_fim - A data de fim a ser obtida.
    * @returns {JSON} Os dados do país obtido.
*/
CREATE OR REPLACE FUNCTION listar_contagem_requerimentos_por_concelho(
    id_distrito bigint,
    data_inicio text,
    data_fim text
)
RETURNS TABLE (
    nome_concelho varchar(255),
    total_requerimentos bigint
) AS $$
DECLARE
    data_inicio_aux date;
    data_fim_aux date;

BEGIN
    
    IF id_distrito IS NULL THEN
        RAISE EXCEPTION 'O identificador do distrito não é válido.';
    ELSIF NOT EXISTS(SELECT 1 FROM distrito WHERE distrito.id_distrito = listar_contagem_requerimentos_por_concelho.id_distrito) THEN
        RAISE EXCEPTION 'Ocorreu um erro ao verificar o distrito.';
    END IF;

    IF data_inicio IS NULL THEN
        RAISE EXCEPTION 'A data de início não é válida.';
    ELSIF NOT data_inicio ~ '^[0-9]{4}-[0-9]{2}-[0-9]{2}$' THEN
        RAISE EXCEPTION 'A data de início não é válida.';
    ELSE
        data_inicio_aux := data_inicio::date;
    END IF;

    IF data_fim IS NULL THEN
        RAISE EXCEPTION 'A data de fim não é válida.';
    ELSIF NOT data_fim ~ '^[0-9]{4}-[0-9]{2}-[0-9]{2}$' THEN
        RAISE EXCEPTION 'A data de fim não é válida.';
    ELSE
        data_fim_aux := data_fim::date;
    END IF;

    RETURN QUERY SELECT
        c.nome AS nome_concelho,
        COALESCE(SUM(CASE WHEN r.id_requerimento IS NOT NULL THEN 1 ELSE 0 END), 0) AS total_requerimentos
    FROM
        concelho c
        LEFT JOIN freguesia f ON c.id_concelho = f.id_concelho
        LEFT JOIN requerimento r ON f.id_freguesia = r.id_freguesia_residencia AND r.data_criacao >= data_inicio_aux AND r.data_criacao <= data_fim_aux
    WHERE
        c.id_distrito = listar_contagem_requerimentos_por_concelho.id_distrito
    GROUP BY
        c.nome
    ORDER BY
        c.nome ASC;

END;
$$ LANGUAGE plpgsql;


/**
    * Esta função permite obter uma listagem de requerimentos por periodo.
    * @param {Date} data_inicio - A data de início a ser obtida.
    * @param {Date} data_fim - A data de fim a ser obtida.
    * @returns {JSON} Os dados obtidos.
*/
CREATE OR REPLACE FUNCTION listar_contagem_requerimentos_por_periodo(
    data_inicio text,
    data_fim text
)
RETURNS TABLE (
    periodo text,
    texto_periodo text,
    total_requerimentos bigint
) AS $$
DECLARE
    data_inicio_aux date;
    data_fim_aux date;
    dias_diff int;
BEGIN
    
    -- Validações iniciais
    IF data_inicio IS NULL THEN
        RAISE EXCEPTION 'A data de início não é válida.';
    ELSIF NOT data_inicio ~ '^[0-9]{4}-[0-9]{2}-[0-9]{2}$' THEN
        RAISE EXCEPTION 'A data de início não é válida.';
    ELSE
        data_inicio_aux := data_inicio::date;
    END IF;

    IF data_fim IS NULL THEN
        RAISE EXCEPTION 'A data de fim não é válida.';
    ELSIF NOT data_fim ~ '^[0-9]{4}-[0-9]{2}-[0-9]{2}$' THEN
        RAISE EXCEPTION 'A data de fim não é válida.';
    ELSE
        data_fim_aux := data_fim::date;
    END IF;
    
    dias_diff := data_fim_aux - data_inicio_aux;

    -- Retornar dados por dia
    IF dias_diff < 60 THEN
        RETURN QUERY
        WITH date_series AS (
            SELECT generate_series(data_inicio_aux, data_fim_aux, '1 day'::interval)::date AS data
        )
        SELECT
            TO_CHAR(ds.data, 'YYYY-MM-DD') AS periodo,
            TO_CHAR(ds.data, 'YYYY-MM-DD') AS texto_periodo,
            COALESCE(COUNT(r.data_criacao), 0) AS total_requerimentos
        FROM
            date_series ds
            LEFT JOIN requerimento r ON ds.data = DATE(r.data_criacao)
        GROUP BY
            ds.data
        ORDER BY
            ds.data;

    -- Retornar dados por mês
    ELSIF dias_diff >= 60 AND dias_diff < 370 THEN
        RETURN QUERY
        WITH month_series AS (
            SELECT generate_series(data_inicio_aux, data_fim_aux, '1 month'::interval)::date AS mes
        )
        SELECT
            TO_CHAR(ms.mes, 'YYYY-MM') AS periodo,
            CASE EXTRACT(MONTH FROM ms.mes)
                WHEN 1 THEN 'jan'
                WHEN 2 THEN 'fev'
                WHEN 3 THEN 'mar'
                WHEN 4 THEN 'abr'
                WHEN 5 THEN 'mai'
                WHEN 6 THEN 'jun'
                WHEN 7 THEN 'jul'
                WHEN 8 THEN 'ago'
                WHEN 9 THEN 'set'
                WHEN 10 THEN 'out'
                WHEN 11 THEN 'nov'
                WHEN 12 THEN 'dez'
            END || ' de ' ||  TO_CHAR(ms.mes, 'YYYY') AS texto_periodo,
            COALESCE(COUNT(r.data_criacao), 0) AS total_requerimentos
        FROM
            month_series ms
            LEFT JOIN requerimento r ON DATE_TRUNC('month', r.data_criacao) = ms.mes
        GROUP BY
            ms.mes
        ORDER BY
            ms.mes;

    -- Retornar dados por ano
    ELSE
        RETURN QUERY
        WITH year_series AS (
            SELECT generate_series(data_inicio_aux, data_fim_aux, '1 year'::interval)::date AS ano
        )
        SELECT
            TO_CHAR(ys.ano, 'YYYY') AS periodo,
            TO_CHAR(ys.ano, 'YYYY') AS texto_periodo,
            COALESCE(COUNT(r.data_criacao), 0) AS total_requerimentos
        FROM
            year_series ys
            LEFT JOIN requerimento r ON DATE_TRUNC('year', r.data_criacao) = ys.ano
        GROUP BY
            ys.ano
        ORDER BY
            ys.ano;
    END IF;

END;
$$ LANGUAGE plpgsql;


/**
    * Esta função permite obter uma listagem de querimentos por estado.
    * @returns {Table} Os dados obtidos.
*/
CREATE OR REPLACE FUNCTION listar_contagem_requerimentos_por_estado()
RETURNS TABLE (
    estado integer,
    texto_estado text,
    total_requerimentos bigint
) AS $$
BEGIN

    RETURN QUERY
    WITH estados AS (
        SELECT 0 AS estado, 'Pendente' AS texto_estado
		UNION ALL SELECT 1, 'Aguarda Avaliação'
		UNION ALL SELECT 2, 'Avaliado'
        UNION ALL SELECT 3, 'A Agendar'
        UNION ALL SELECT 4, 'Agendado'
		UNION ALL SELECT 5, 'Inválido'
        UNION ALL SELECT 6, 'Cancelado'
    )
    SELECT
        e.estado,
        e.texto_estado,
        COALESCE(COUNT(r.estado), 0) AS total_requerimentos
    FROM
        estados e
        LEFT JOIN requerimento r ON e.estado = r.estado
    GROUP BY
        e.estado, e.texto_estado
    ORDER BY
        e.texto_estado DESC;

END;
$$ LANGUAGE plpgsql;


/**
    * Esta função permite obter uma contagem de dados para o dashboard.
    * @returns {Table} Os dados obtidos.
*/
CREATE OR REPLACE FUNCTION listar_contagem_dashboard()
RETURNS TABLE (
    total_requerimentos bigint,
    total_utentes bigint,
    total_equipas_medicas bigint,
    total_medicos bigint,
    total_requerimentos_pendentes bigint,
    total_requerimentos_aguarda_avaliacao bigint,
    total_requerimentos_avaliados bigint,
    total_requerimentos_a_agendar bigint,
    total_requerimentos_agendados bigint,
    total_requerimentos_invalidos bigint,
    total_requerimentos_cancelados bigint,
    total_requerimentos_tipo_multiuso bigint,
    total_requerimentos_tipo_importacao bigint
) AS $$
BEGIN

    RETURN QUERY
    WITH estados AS (
        SELECT 0 AS estado, 'Pendente' AS texto_estado
        UNION ALL SELECT 1, 'Aguarda Avaliação'
        UNION ALL SELECT 2, 'Avaliado'
        UNION ALL SELECT 3, 'A Agendar'
        UNION ALL SELECT 4, 'Agendado'
        UNION ALL SELECT 5, 'Inválido'
        UNION ALL SELECT 6, 'Cancelado'
    )
    SELECT
        (
            SELECT COUNT(r.id_requerimento) FROM requerimento r
        ),
        (
            SELECT COUNT(u.id_utente) FROM utente u
        ),
        (
            SELECT COUNT(em.id_equipa_medica) FROM equipa_medica em
        ),
        (
            SELECT COUNT(u.id_utlizador) FROM utilizador u WHERE u.cargo=1
        ),
        (
            SELECT COUNT(r.id_requerimento) FROM requerimento r WHERE r.estado = 0
        ),
        (
            SELECT COUNT(r.id_requerimento) FROM requerimento r WHERE r.estado = 1
        ),
        (
            SELECT COUNT(r.id_requerimento) FROM requerimento r WHERE r.estado = 2
        ),
        (
            SELECT COUNT(r.id_requerimento) FROM requerimento r WHERE r.estado = 3
        ),
        (
            SELECT COUNT(r.id_requerimento) FROM requerimento r WHERE r.estado = 4
        ),
        (
            SELECT COUNT(r.id_requerimento) FROM requerimento r WHERE r.estado = 5
        ),
        (
            SELECT COUNT(r.id_requerimento) FROM requerimento r WHERE r.estado = 6
        ),
        (
            SELECT COUNT(r.id_requerimento) FROM requerimento r WHERE r.tipo_requerimento = 0
        ),
        (
            SELECT COUNT(r.id_requerimento) FROM requerimento r WHERE r.tipo_requerimento = 1
        )
    FROM
        estados e
        LEFT JOIN requerimento r ON e.estado = r.estado
    GROUP BY
        e.estado, e.texto_estado
    ORDER BY
        e.texto_estado DESC
	LIMIT 1;
END;
$$ LANGUAGE plpgsql;


/**
    * Esta função permite obter uma contagem de dados para o dashboard por utilizador.
    * @param {String} hashed_id_utilizador - O identificador do utilizador a ser obtido.
    * @returns {Table} Os dados obtidos.
*/
CREATE OR REPLACE FUNCTION listar_contagem_dashboard_por_utilizador(
    hashed_id_utilizador varchar(255)
)
RETURNS TABLE (
    total_requerimentos_avaliados bigint,
    total_avaliados_acima_60 bigint,
    total_avaliados_ate_60 bigint,
    total_requerimentos_agendados bigint,
    total_requerimentos_por_validar bigint,
    total_requerimentos_validados bigint,
    total_requerimentos_invalidos bigint
)
AS $$
DECLARE
    id_utilizador_aux integer;
BEGIN

    IF hashed_id_utilizador IS NULL OR hashed_id_utilizador = '' THEN
        RAISE EXCEPTION 'O identificador do utilizador não é válido.';
    ELSIF NOT EXISTS(SELECT * FROM utilizador WHERE utilizador.hashed_id = hashed_id_utilizador) THEN
        RAISE EXCEPTION 'Ocorreu um erro ao verificar o utilizador.';
    ELSE
        SELECT utilizador.id_utlizador INTO id_utilizador_aux FROM utilizador WHERE utilizador.hashed_id = hashed_id_utilizador;
    END IF;

    RETURN QUERY
    WITH estados AS (
        SELECT 0 AS estado, 'Pendente' AS texto_estado
        UNION ALL SELECT 1, 'Aguarda Avaliação'
        UNION ALL SELECT 2, 'Avaliado'
        UNION ALL SELECT 3, 'A Agendar'
        UNION ALL SELECT 4, 'Agendado'
        UNION ALL SELECT 5, 'Inválido'
        UNION ALL SELECT 6, 'Cancelado'
    )
    SELECT
        (
            SELECT 
                COUNT(r.id_requerimento) 
            FROM requerimento r 
            INNER JOIN avaliacao_requerimento ar ON r.id_requerimento = ar.id_requerimento 
            WHERE r.estado = 2 AND ar.id_utilizador = id_utilizador_aux
        ),
        (
            SELECT 
                COUNT(r.id_requerimento) 
            FROM requerimento r 
            INNER JOIN avaliacao_requerimento ar ON r.id_requerimento = ar.id_requerimento 
            WHERE r.estado = 2 AND ar.id_utilizador = id_utilizador_aux AND ar.grau_avaliacao > 60
        ),
        (
            SELECT 
                COUNT(r.id_requerimento) 
            FROM requerimento r 
            INNER JOIN avaliacao_requerimento ar ON r.id_requerimento = ar.id_requerimento 
            WHERE r.estado = 2 AND ar.id_utilizador = id_utilizador_aux AND ar.grau_avaliacao <= 60
        ),
        (
            SELECT 
                COUNT(r.id_requerimento) 
            FROM requerimento r 
            INNER JOIN agendamento_consulta ac ON r.id_requerimento = ac.id_requerimento 
            WHERE r.estado = 4 AND ac.id_utilizador = id_utilizador_aux
        ),
        (
            SELECT 
                COUNT(r.id_requerimento) 
            FROM requerimento r 
            WHERE r.estado = 0
        ),
        (
            SELECT 
                COUNT(r.id_requerimento) 
            FROM requerimento r 
            INNER JOIN historico_estados he WHERE he.id_requerimento = r.id_requerimento AND he.estado_novo = 1
            WHERE r.estado > 0 AND r.estado <> 5 AND r.estado <> 6 AND he.id_utilizador = id_utilizador_aux
        ),
        (
            SELECT 
                COUNT(r.id_requerimento) 
            FROM requerimento r 
            INNER JOIN historico_estados he WHERE he.id_requerimento = r.id_requerimento AND he.estado_novo = 5
            WHERE r.estado = 5 AND he.id_utilizador = id_utilizador_aux
        )
    FROM
        estados e
        LEFT JOIN requerimento r ON e.estado = r.estado
    GROUP BY
        e.estado, e.texto_estado
    ORDER BY
        e.texto_estado DESC
    LIMIT 1;

END;
$$ LANGUAGE plpgsql;





/**
    * Esta função permite obter uma contagem de dados para o dashboard por utente.
    * @param {String} hashed_id_utente - O identificador do utente a ser obtido.
    * @returns {Table} Os dados obtidos.
*/
CREATE OR REPLACE FUNCTION listar_contagem_dashboard_por_utente(
    hashed_id_utente varchar(255)
)
RETURNS TABLE (
    total_requerimentos bigint,
    total_requerimentos_validados bigint,
    total_requerimentos_invalidos bigint,
    total_requerimentos_agendados bigint
)
AS $$
DECLARE
    id_utente_aux integer;
BEGIN

    IF hashed_id_utente IS NULL OR hashed_id_utente = '' THEN
        RAISE EXCEPTION 'O identificador do utente não é válido.';
    ELSIF NOT EXISTS(SELECT * FROM utente WHERE utente.hashed_id = hashed_id_utente) THEN
        RAISE EXCEPTION 'Ocorreu um erro ao verificar o utente.';
    ELSE
        SELECT utente.id_utente INTO id_utente_aux FROM utente WHERE utente.hashed_id = hashed_id_utente;
    END IF;

    RETURN QUERY
    WITH estados AS (
        SELECT 0 AS estado, 'Pendente' AS texto_estado
        UNION ALL SELECT 1, 'Aguarda Avaliação'
        UNION ALL SELECT 2, 'Avaliado'
        UNION ALL SELECT 3, 'A Agendar'
        UNION ALL SELECT 4, 'Agendado'
        UNION ALL SELECT 5, 'Inválido'
        UNION ALL SELECT 6, 'Cancelado'
    )
    SELECT
        (
            SELECT 
                COUNT(r.id_requerimento) 
            FROM requerimento r 
            WHERE r.id_utente = id_utente_aux
        ),
        (
            SELECT 
                COUNT(r.id_requerimento) 
            FROM requerimento r 
            INNER JOIN avaliacao_requerimento ar ON r.id_requerimento = ar.id_requerimento 
            WHERE r.id_utente = id_utente_aux AND r.estado > 0 AND r.estado <> 5 AND r.estado <> 6
        ),
        (
            SELECT 
                COUNT(r.id_requerimento) 
            FROM requerimento r 
            WHERE r.id_utente = id_utente_aux AND r.estado = 5
        ),
        (
            SELECT 
                COUNT(r.id_requerimento) 
            FROM requerimento r 
            INNER JOIN agendamento_consulta ac ON r.id_requerimento = ac.id_requerimento 
            WHERE r.id_utente = id_utente_aux AND r.estado = 4
        )
    FROM
        estados e
        LEFT JOIN requerimento r ON e.estado = r.estado
    GROUP BY
        e.estado, e.texto_estado
    ORDER BY
        e.texto_estado DESC
    LIMIT 1;

END;
$$ LANGUAGE plpgsql;







    

    



