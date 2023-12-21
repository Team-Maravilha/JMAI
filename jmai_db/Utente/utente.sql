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
