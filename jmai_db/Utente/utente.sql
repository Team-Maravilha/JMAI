CREATE EXTENSION IF NOT EXISTS pgcrypto;
/**
    * Esta função permite realizar a autenticação de um utente.
    * @param {String} email - O email do utente
    * @param {String} palavra_passe - A palavra passe do utente
    * @returns {Table} - Retorna o utente autenticado.
    */

CREATE OR REPLACE FUNCTION autenticar_utente(p_email varchar(255), p_palavra_passe varchar(255))
RETURNS TABLE (hashed_id varchar(255), nome varchar(255), email_autenticacao varchar(255), genero varchar(1), numero_utente integer, data_criacao timestamp, cargo integer, texto_cargo text) AS $$
BEGIN
    IF p_email IS NULL OR p_email = '' THEN
        RAISE EXCEPTION 'O email de autenticação do utente não é válido.';
    END IF;

    IF p_palavra_passe IS NULL OR p_palavra_passe = '' THEN
        RAISE EXCEPTION 'A palavra-passe do utente não é válida.';
    END IF;

    IF NOT EXISTS (SELECT * FROM utente WHERE utente.email_autenticacao = p_email) THEN
        RAISE EXCEPTION 'Não existe um utente com o email %.', p_email;
    END IF;

    IF NOT EXISTS (SELECT * FROM utente WHERE utente.email_autenticacao = p_email AND utente.palavra_passe = crypt(p_palavra_passe, utente.palavra_passe)) THEN
        RAISE EXCEPTION 'A palavra-passe não está correta.';
    END IF;

    RETURN QUERY SELECT utente.hashed_id, utente.nome, utente.email_autenticacao, utente.genero, utente.numero_utente, utente.data_criacao, 3, 'Utente' FROM utente WHERE utente.email_autenticacao = p_email;

END;
$$ LANGUAGE plpgsql;


/**
    * Criar um utente
    * @param {String} nome - O nome do utente.
    * @param {String} email_autenticacao - O email do utente.
    * @param {String} palavra_passe - A palavra-passe do utente.
    * @param {String} genero - O género do utente.
    * @param {Integer} numero_utente - O número de utente do utente.
    * @returns {Table} Retorna o utilizador criado.
    */
CREATE OR REPLACE FUNCTION inserir_utente(p_nome varchar(255), p_id_utente_rnu bigint, p_email_autenticacao varchar(255), p_palavra_passe varchar(255), p_genero integer, p_numero_utente integer)
RETURNS TABLE (hashed_id varchar(255)) AS $$
BEGIN
   IF p_nome IS NULL OR p_nome = '' THEN
        RAISE EXCEPTION 'O nome do utente não é válido.';
    END IF;

    IF p_id_utente_rnu IS NULL THEN
        RAISE EXCEPTION 'O id do utente não é válido.';
    ELSIF EXISTS (SELECT * FROM utente WHERE utente.id_utente_rnu = inserir_utente.p_id_utente_rnu) THEN
        RAISE EXCEPTION 'Já existe um utente com o número de utente %. Em caso de dúvida, contacte um administrador.', inserir_utente.id_utente_rnu;
    END IF;

    IF p_email_autenticacao IS NULL OR p_email_autenticacao = '' THEN
        RAISE EXCEPTION 'O email do utente não é válido.';
    ELSIF EXISTS (SELECT * FROM utente WHERE utente.email_autenticacao = inserir_utente.p_email_autenticacao) THEN
        RAISE EXCEPTION 'Já existe um utente com o email %.', inserir_utente.p_email_autenticacao;
    ELSIF NOT p_email_autenticacao ~ '^[A-Za-z0-9._%+-]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,}$' THEN
        RAISE EXCEPTION 'O email do utente não cumpre os requisitos de validação.';
    END IF;

    IF p_palavra_passe IS NULL THEN
        RAISE EXCEPTION 'A palavra-passe do utente não é válida.';
    ELSIF LENGTH(p_palavra_passe) < 8 THEN
        RAISE EXCEPTION 'A palavra-passe deve ter pelo menos 8 caracteres.';
    ELSIF NOT (p_palavra_passe ~ '[A-Z]') THEN
        RAISE EXCEPTION 'A palavra-passe deve conter pelo menos uma letra maiúscula.';
    ELSIF NOT (p_palavra_passe ~ '[a-z]') THEN
        RAISE EXCEPTION 'A palavra-passe deve conter pelo menos uma letra minúscula.';
    ELSIF NOT (p_palavra_passe ~ '[0-9]') THEN
        RAISE EXCEPTION 'A palavra-passe deve conter pelo menos um número.';
    ELSIF NOT (p_palavra_passe ~ '[!@#$%^&*()]') THEN
        RAISE EXCEPTION 'A palavra-passe deve conter pelo menos um caractere especial (!@#$^&*()).';
    END IF;

    IF p_genero IS NULL OR p_genero < 1 OR p_genero > 3 THEN
        RAISE EXCEPTION 'O género do utente não é válido.';
    END IF;

    IF p_numero_utente IS NULL OR p_numero_utente < 1 THEN
        RAISE EXCEPTION 'O número de utente do utente não é válido.';
    ELSEIF EXISTS (SELECT * FROM utente WHERE utente.numero_utente = inserir_utente.p_numero_utente) THEN
        RAISE EXCEPTION 'Já existe um utente com o número de utente %.', inserir_utente.p_numero_utente;
    ELSEIF NOT (cast(p_numero_utente as varchar(255)) ~ '^[0-9]{9}$') THEN
        RAISE EXCEPTION 'O número de utente do utente não cumpre os requisitos de validação.';
    END IF;

   INSERT INTO utente (nome, id_utente_rnu, email_autenticacao, palavra_passe, genero, numero_utente) VALUES (p_nome, p_id_utente_rnu, p_email_autenticacao, crypt(p_palavra_passe, gen_salt('bf')), p_genero, p_numero_utente);
   RETURN QUERY SELECT utente.hashed_id FROM utente WHERE utente.email_autenticacao = p_email_autenticacao;

END;
$$ LANGUAGE plpgsql;
SELECT * FROM inserir_utente('João', 1, 'joao@gmail.ocm', '12345678', 'M', '123456789');


/**
    * Adicionar o HashedID a um utilizador.
    */
CREATE TRIGGER add_uuid BEFORE INSERT ON utente FOR EACH ROW EXECUTE PROCEDURE add_uuid();


/**
    * Esta função permite obter uma listagem de todos os utentes.
    * @param {String} hashed_id - O hashed_id do utente.
    * @returns {Table} - Retorna os dados do utente.
    */
CREATE OR REPLACE FUNCTION listar_utentes(p_hashed_id varchar(255) DEFAULT NULL)
RETURNS TABLE (hashed_id varchar(255), nome varchar(255), email_autenticacao varchar(255), genero varchar(1), texto_genero text, numero_utente integer, data_criacao text, cargo integer, texto_cargo text) AS $$
BEGIN
    IF p_hashed_id IS NULL OR p_hashed_id = '' THEN
        RETURN QUERY SELECT utente.hashed_id, utente.nome, utente.email_autenticacao, utente.genero, CASE WHEN utente.genero = '1' THEN 'Masculino' WHEN utente.genero = '2' THEN 'Feminino' WHEN utente.genero = '3' THEN 'Não Divulgar' END AS texto_genero, utente.numero_utente, to_char(utente.data_criacao, 'DD/MM/YYYY HH24:MI') AS data_criacao, 3, 'Utente' FROM utente;
    ELSE
        RETURN QUERY SELECT utente.hashed_id, utente.nome, utente.email_autenticacao, utente.genero, CASE WHEN utente.genero = '1' THEN 'Masculino' WHEN utente.genero = '2' THEN 'Feminino' WHEN utente.genero = '3' THEN 'Não Divulgar' END AS texto_genero, utente.numero_utente, to_char(utente.data_criacao, 'DD/MM/YYYY HH24:MI') AS data_criacao, 3, 'Utente' FROM utente WHERE utente.hashed_id = p_hashed_id;
    END IF;
END;
$$ LANGUAGE plpgsql;


/**
    * Esta função permite registar um pedido de recuperação de palavra-passe.
    * @param {String} email_autenticacao - O email do utente.
    * @returns {Table} - Retorna o pedido de recuperação de palavra-passe.
    */
CREATE OR REPLACE FUNCTION registar_pedido_recuperacao_palavra_passe(email_autenticacao varchar(255))
RETURNS TABLE (token varchar(255), nome varchar(255), codigo_recuperacao varchar(25), data_expiracao timestamp) AS $$
DECLARE
    v_id_utente bigint;
    v_codigo_recuperacao varchar(25);
    v_token varchar(255);
BEGIN
    IF email_autenticacao IS NULL OR email_autenticacao = '' THEN
        RAISE EXCEPTION 'O email do utente não é válido.';
    END IF;

    IF NOT email_autenticacao ~ '^[A-Za-z0-9._%+-]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,}$' THEN
        RAISE EXCEPTION 'O email do utente não cumpre os requisitos de validação.';
    END IF;

    IF NOT EXISTS (SELECT * FROM utente WHERE utente.email_autenticacao = registar_pedido_recuperacao_palavra_passe.email_autenticacao) THEN
        RAISE EXCEPTION 'Não existe um utente com o email %.', registar_pedido_recuperacao_palavra_passe.email_autenticacao;
    END IF;

    v_id_utente := (SELECT utente.id_utente FROM utente WHERE utente.email_autenticacao = registar_pedido_recuperacao_palavra_passe.email_autenticacao);

    IF EXISTS (SELECT * FROM recuperacao_palavra_passe WHERE recuperacao_palavra_passe.id_utente = v_id_utente AND recuperacao_palavra_passe.estado <> 0 AND recuperacao_palavra_passe.data_expiracao > now()) THEN
        RAISE EXCEPTION 'Já existe um pedido de recuperação de palavra-passe ativo.';
    END IF;

    v_codigo_recuperacao := (
        SELECT string_agg(
            substring('0123456789', (floor(random() * 10) + 1)::integer, 1),
            ''
        ) AS codigo_recuperacao
        FROM generate_series(1, 6) g(i)
    );

    INSERT INTO recuperacao_palavra_passe (id_utente, codigo_recuperacao, token, data_expiracao) VALUES (v_id_utente, v_codigo_recuperacao, uuid_generate_v4(), now() + INTERVAL '1 hour') RETURNING recuperacao_palavra_passe.token INTO v_token;

    RETURN QUERY SELECT recuperacao_palavra_passe.token, utente.nome, recuperacao_palavra_passe.codigo_recuperacao, to_char(recuperacao_palavra_passe.data_expiracao, 'DD/MM/YYYY HH24:MI') AS data_expiracao FROM recuperacao_palavra_passe INNER JOIN utente ON utente.id_utente = recuperacao_palavra_passe.id_utente WHERE recuperacao_palavra_passe.token = v_token;

END;
$$ LANGUAGE plpgsql;


/**
    * Esta função permite verificar se um pedido de recuperação de palavra-passe é válido.
    * @param {String} token - O token do pedido de recuperação de palavra-passe.
    * @returns {Boolean} - Retorna verdadeiro se o pedido de recuperação de palavra-passe for válido.
    */
CREATE OR REPLACE FUNCTION verificar_pedido_recuperacao_palavra_passe(token varchar(255))
RETURNS BOOLEAN AS $$
DECLARE
    v_id_utente bigint;
BEGIN
    IF token IS NULL OR token = '' THEN
        RAISE EXCEPTION 'O token do pedido de recuperação de palavra-passe não é válido.';
    END IF;

    IF NOT EXISTS (SELECT * FROM recuperacao_palavra_passe WHERE recuperacao_palavra_passe.token = verificar_pedido_recuperacao_palavra_passe.token) THEN
        RAISE EXCEPTION 'Não existe um pedido de recuperação de palavra-passe com o token %.', verificar_pedido_recuperacao_palavra_passe.token;
    END IF;

    IF EXISTS (SELECT * FROM recuperacao_palavra_passe WHERE recuperacao_palavra_passe.token = verificar_pedido_recuperacao_palavra_passe.token AND recuperacao_palavra_passe.estado = 0) THEN
        RAISE EXCEPTION 'O pedido de recuperação de palavra-passe já foi utilizado.';
    ELSEIF EXISTS (SELECT * FROM recuperacao_palavra_passe WHERE recuperacao_palavra_passe.token = verificar_pedido_recuperacao_palavra_passe.token AND recuperacao_palavra_passe.estado = 2) THEN
        RETURN FALSE;
    END IF;

    IF EXISTS (SELECT * FROM recuperacao_palavra_passe WHERE recuperacao_palavra_passe.token = verificar_pedido_recuperacao_palavra_passe.token AND recuperacao_palavra_passe.data_expiracao < now()) THEN
        RAISE EXCEPTION 'O pedido de recuperação de palavra-passe expirou.';
    END IF;

    v_id_utente := (SELECT recuperacao_palavra_passe.id_utente FROM recuperacao_palavra_passe WHERE recuperacao_palavra_passe.token = verificar_pedido_recuperacao_palavra_passe.token);

    RETURN TRUE;

END;
$$ LANGUAGE plpgsql;


/**
    * Esta função permite validar um pedido de recuperação de palavra-passe com o código de recuperação.
    * @param {String} token - O token do pedido de recuperação de palavra-passe.
    * @param {String} codigo_recuperacao - O código de recuperação do pedido de recuperação de palavra-passe.
    * @returns {Boolean} - Retorna verdadeiro se o pedido de recuperação de palavra-passe for válido.
    */
CREATE OR REPLACE FUNCTION validar_pedido_recuperacao_palavra_passe(token_param varchar(255), codigo_recuperacao varchar(25))
RETURNS BOOLEAN AS $$
DECLARE
    v_id_utente bigint;
    token_output varchar(255);
BEGIN
    IF token_param IS NULL OR token_param = '' THEN
        RAISE EXCEPTION 'O token do pedido de recuperação de palavra-passe não é válido.';
    END IF;

    IF codigo_recuperacao IS NULL OR codigo_recuperacao = '' THEN
        RAISE EXCEPTION 'O código de recuperação do pedido de recuperação de palavra-passe não é válido.';
    END IF;

    IF NOT EXISTS (SELECT * FROM recuperacao_palavra_passe WHERE recuperacao_palavra_passe.token = validar_pedido_recuperacao_palavra_passe.token_param) THEN
        RAISE EXCEPTION 'Não existe um pedido de recuperação de palavra-passe com o token %.', validar_pedido_recuperacao_palavra_passe.token_param;
    END IF;

    IF EXISTS (SELECT * FROM recuperacao_palavra_passe WHERE recuperacao_palavra_passe.token = validar_pedido_recuperacao_palavra_passe.token_param AND recuperacao_palavra_passe.estado = 0) THEN
        RAISE EXCEPTION 'O pedido de recuperação de palavra-passe já foi utilizado.';
    END IF;

    IF EXISTS (SELECT * FROM recuperacao_palavra_passe WHERE recuperacao_palavra_passe.token = validar_pedido_recuperacao_palavra_passe.token_param AND recuperacao_palavra_passe.data_expiracao < now()) THEN
        RAISE EXCEPTION 'O pedido de recuperação de palavra-passe expirou.';
    END IF;

    IF EXISTS (SELECT * FROM recuperacao_palavra_passe WHERE recuperacao_palavra_passe.token = validar_pedido_recuperacao_palavra_passe.token_param AND recuperacao_palavra_passe.codigo_recuperacao != validar_pedido_recuperacao_palavra_passe.codigo_recuperacao) THEN
        RAISE EXCEPTION 'O código de recuperação não é válido.';
    END IF;

    v_id_utente := (SELECT recuperacao_palavra_passe.id_utente FROM recuperacao_palavra_passe WHERE recuperacao_palavra_passe.token = validar_pedido_recuperacao_palavra_passe.token_param);

    --ALTERAR ESTADO
    UPDATE recuperacao_palavra_passe SET estado = 2 WHERE recuperacao_palavra_passe.token = validar_pedido_recuperacao_palavra_passe.token_param;

    RETURN TRUE;  

END;
$$ LANGUAGE plpgsql;


/**
    * Esta função permite alterar a palavra-passe de um utente.
    * @param {String} token - O token do pedido de recuperação de palavra-passe.
    * @param {String} palavra_passe - A palavra-passe do utente.
    * @returns {Table} - Retorna o utente com a palavra-passe alterada.
    */
CREATE OR REPLACE FUNCTION alterar_palavra_passe(token_param varchar(255), palavra_passe varchar(255))
RETURNS TABLE (nome varchar(255), email varchar(255)) AS $$
DECLARE
    v_id_utente bigint;
    token_output varchar(255);
BEGIN
    IF token_param IS NULL OR token_param = '' THEN
        RAISE EXCEPTION 'O token do pedido de recuperação de palavra-passe não é válido.';
    END IF;

    IF palavra_passe IS NULL THEN
        RAISE EXCEPTION 'A palavra-passe do utente não é válida.';
    ELSIF LENGTH(palavra_passe) < 8 THEN
        RAISE EXCEPTION 'A palavra-passe deve ter pelo menos 8 caracteres.';
    ELSIF NOT (palavra_passe ~ '[A-Z]') THEN
        RAISE EXCEPTION 'A palavra-passe deve conter pelo menos uma letra maiúscula.';
    ELSIF NOT (palavra_passe ~ '[a-z]') THEN
        RAISE EXCEPTION 'A palavra-passe deve conter pelo menos uma letra minúscula.';
    ELSIF NOT (palavra_passe ~ '[0-9]') THEN
        RAISE EXCEPTION 'A palavra-passe deve conter pelo menos um número.';
    ELSIF NOT (palavra_passe ~ '[!@#$%^&*()]') THEN
        RAISE EXCEPTION 'A palavra-passe deve conter pelo menos um caractere especial (!@#$^&*()).';
    END IF;

    IF NOT EXISTS (SELECT * FROM recuperacao_palavra_passe WHERE recuperacao_palavra_passe.token = alterar_palavra_passe.token_param) THEN
        RAISE EXCEPTION 'Não existe um pedido de recuperação de palavra-passe com o token %.', alterar_palavra_passe.token_param;
    END IF;

    IF EXISTS (SELECT * FROM recuperacao_palavra_passe WHERE recuperacao_palavra_passe.token = alterar_palavra_passe.token_param AND recuperacao_palavra_passe.estado = 0) THEN
        RAISE EXCEPTION 'O pedido de recuperação de palavra-passe já foi utilizado.';
    END IF;

    IF NOT EXISTS (SELECT * FROM recuperacao_palavra_passe WHERE recuperacao_palavra_passe.token = alterar_palavra_passe.token_param AND recuperacao_palavra_passe.estado = 2) THEN
        RAISE EXCEPTION 'O pedido de recuperação de palavra-passe não foi validado.';
    END IF;

    IF EXISTS (SELECT * FROM recuperacao_palavra_passe WHERE recuperacao_palavra_passe.token = alterar_palavra_passe.token_param AND recuperacao_palavra_passe.data_expiracao < now()) THEN
        RAISE EXCEPTION 'O pedido de recuperação de palavra-passe expirou.';
    END IF;

    v_id_utente := (SELECT recuperacao_palavra_passe.id_utente FROM recuperacao_palavra_passe WHERE recuperacao_palavra_passe.token = alterar_palavra_passe.token_param);


    --ALTERAR ESTADO
    UPDATE recuperacao_palavra_passe SET estado = 0 WHERE recuperacao_palavra_passe.token = alterar_palavra_passe.token_param;

    --ALTERAR PALAVRA-PASSE
    UPDATE utente SET palavra_passe = crypt(alterar_palavra_passe.palavra_passe, gen_salt('bf')) WHERE utente.id_utente = v_id_utente;

    RETURN QUERY SELECT utente.nome, utente.email_autenticacao FROM utente WHERE utente.id_utente = v_id_utente;

END;
$$ LANGUAGE plpgsql;


