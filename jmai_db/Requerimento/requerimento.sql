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
    * @returns {String} O identificador do requerimento inserido.
*/
SELECT inserir_requerimento(1, 0, 157669159, '2020-01-01', 123456789, '2001-01-01', 2, 'Rua do teste', '1234-123', 1, 123456789, 1, 0, NULL, NULL, NULL, NULL, NULL)

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
    local_emissao_documento varchar(255) DEFAULT NULL
)
RETURNS TABLE (hashed_id varchar(255)) AS $$  
DECLARE
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

    IF tipo_documento = 1 AND local_emissao_documento IS NULL OR local_emissao_documento = '' THEN
        RAISE EXCEPTION 'O local de emissão do documento não é válido.';
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
        IF email_preferencial ~ '^[a-zA-Z0-9_.+-]+@[a-zA-Z0-9-]+\.[a-zA-Z0-9-.]+$' THEN
            RAISE EXCEPTION 'O email preferencial não é válido.';
        END IF;
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
    );

    RETURN QUERY SELECT requerimento.hashed_id FROM requerimento WHERE requerimento.numero_requerimento = numero_requerimento_aux;

END;
$$ LANGUAGE plpgsql;


/**
    * Adicionar o HashedID a um requerimento.
    */
CREATE TRIGGER add_uuid BEFORE INSERT ON requerimento FOR EACH ROW EXECUTE PROCEDURE add_uuid();


