CREATE EXTENSION IF NOT EXISTS pgcrypto;

/**
    * Esta função permite realizar a autenticação de um utilizador.
    * @param {String} email - O email do utilizador.
    * @param {String} palavra_passe - A palavra passe do utilizador.
    * @returns {Table} Retorna o utilizador autenticado.
    */
CREATE OR REPLACE FUNCTION autenticar_utilizador(p_email varchar(255), p_palavra_passe varchar(255))
RETURNS TABLE (hashed_id varchar(255), nome varchar(255), email varchar(255), cargo integer, texto_cargo text, data_criacao timestamp) AS $$
BEGIN
    IF p_email IS NULL THEN
        RAISE EXCEPTION 'O email do utilizador não é válido.';
    END IF;

    IF p_palavra_passe IS NULL THEN
        RAISE EXCEPTION 'A palavra-passe do utilizador não é válida.';
    END IF;

    IF NOT EXISTS (SELECT * FROM utilizador WHERE utilizador.email = p_email) THEN
        RAISE EXCEPTION 'Não existe um utilizador com o email %.', p_email;
    END IF;

    IF NOT EXISTS (SELECT * FROM utilizador WHERE utilizador.email = p_email AND utilizador.palavra_passe = crypt(p_palavra_passe, utilizador.palavra_passe)) THEN
        RAISE EXCEPTION 'A palavra-passe não está correta.';
    END IF;

    IF NOT EXISTS (SELECT * FROM utilizador WHERE utilizador.email = p_email AND utilizador.palavra_passe = crypt(p_palavra_passe, utilizador.palavra_passe) AND utilizador.estado = 1) THEN
        RAISE EXCEPTION 'O utilizador não tem permissões para aceder ao sistema.';
    END IF;

    RETURN QUERY SELECT utilizador.hashed_id, utilizador.nome, utilizador.email, utilizador.cargo, (CASE WHEN utilizador.cargo = 0 THEN 'Administrador' WHEN utilizador.cargo = 1 THEN 'Médico' ELSE 'Rececionista' END), utilizador.data_criacao FROM utilizador WHERE utilizador.email = p_email AND utilizador.palavra_passe = crypt(p_palavra_passe, utilizador.palavra_passe);

END;
$$ LANGUAGE plpgsql;


/**
    * Criar um utilizador.
    * @param {String} nome - O nome do utilizador.
    * @param {String} email - O email do utilizador.
    * @param {String} palavra_passe - A palavra-passe do utilizador.
    * @param {Number} cargo - O cargo do utilizador.
    * @returns {Table} Retorna o utilizador criado.
    */
CREATE OR REPLACE FUNCTION inserir_utilizador(nome varchar(255), email varchar(255), palavra_passe varchar(255), cargo integer)
RETURNS TABLE (hashed_id varchar(255)) AS $$
BEGIN
    
    IF nome IS NULL THEN
        RAISE EXCEPTION 'O nome do utilizador não é válido.';
    END IF;

    IF email IS NULL THEN
        RAISE EXCEPTION 'O email do utilizador não é válido.';
    ELSIF EXISTS (SELECT * FROM utilizador WHERE utilizador.email = inserir_utilizador.email) THEN
        RAISE EXCEPTION 'Já existe um utilizador com o email %.', inserir_utilizador.email;
    ELSIF NOT email ~ '^[A-Za-z0-9._%+-]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,}$' THEN
        RAISE EXCEPTION 'O email do utilizador não cumpre os requisitos de validação.';
    END IF;

    IF palavra_passe IS NULL THEN
        RAISE EXCEPTION 'A palavra-passe do utilizador não é válida.';
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

    IF cargo IS NULL OR cargo < 0 OR cargo > 2 THEN
        RAISE EXCEPTION 'O cargo do utilizador não é válido.';
    END IF;

    INSERT INTO utilizador (nome, email, palavra_passe, cargo, estado) VALUES (inserir_utilizador.nome, inserir_utilizador.email, crypt(inserir_utilizador.palavra_passe, gen_salt('bf')), inserir_utilizador.cargo, 1);
    
    RETURN QUERY SELECT utilizador.hashed_id FROM utilizador WHERE utilizador.email = inserir_utilizador.email;
END;
$$ LANGUAGE plpgsql;


/**
    * Adicionar o HashedID a um utilizador.
    */
CREATE TRIGGER add_uuid BEFORE INSERT ON utilizador FOR EACH ROW EXECUTE PROCEDURE add_uuid();


/**
    * Esta função permite editar um utilizador.
    * @param {String} hashed_id - O HashedID do utilizador.
    * @param {String} nome - O nome do utilizador.
    * @param {String} email - O email do utilizador.
    * @param {Number} cargo - O cargo do utilizador.
    * @returns {Table} Retorna o utilizador editado.
    */ 
CREATE OR REPLACE FUNCTION editar_utilizador(hashed_id_param varchar(255), nome varchar(255), email varchar(255), cargo integer)
RETURNS TABLE (hashed_id varchar(255)) AS $$
BEGIN
    IF hashed_id_param IS NULL THEN
        RAISE EXCEPTION 'O utilizador não é válido.';
    ELSIF NOT EXISTS (SELECT * FROM utilizador WHERE utilizador.hashed_id = editar_utilizador.hashed_id_param) THEN
        RAISE EXCEPTION 'O utilizador não é válido.';
    END IF;

    IF nome IS NULL THEN
        RAISE EXCEPTION 'O nome do utilizador não é válido.';
    END IF;

    IF email IS NULL THEN
        RAISE EXCEPTION 'O email do utilizador não é válido.';
    ELSIF EXISTS (SELECT * FROM utilizador WHERE utilizador.email = editar_utilizador.email AND utilizador.hashed_id != editar_utilizador.hashed_id_param) THEN
        RAISE EXCEPTION 'Já existe um utilizador com o email %.', editar_utilizador.email;
    ELSIF NOT email ~ '^[A-Za-z0-9._%+-]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,}$' THEN
        RAISE EXCEPTION 'O email do utilizador não cumpre os requisitos de validação.';
    END IF;

    IF cargo IS NULL OR cargo < 0 OR cargo > 2 THEN
        RAISE EXCEPTION 'O cargo do utilizador não é válido.';
    END IF;

    UPDATE utilizador SET nome = editar_utilizador.nome, email = editar_utilizador.email, cargo = editar_utilizador.cargo WHERE utilizador.hashed_id = editar_utilizador.hashed_id_param;
    
    RETURN QUERY SELECT utilizador.hashed_id FROM utilizador WHERE utilizador.hashed_id = editar_utilizador.hashed_id_param;
END;
$$ LANGUAGE plpgsql;


/**
    * Esta função permite editar a palavra-passe de um utilizador.
    * @param {String} hashed_id - O HashedID do utilizador.
    * @param {String} palavra_passe - A palavra-passe do utilizador.
    * @returns {Table} Retorna o utilizador editado.
    */
CREATE OR REPLACE FUNCTION editar_palavra_passe_utilizador(hashed_id_param varchar(255), palavra_passe varchar(255))
RETURNS TABLE (hashed_id varchar(255)) AS $$
BEGIN
    IF hashed_id_param IS NULL THEN
        RAISE EXCEPTION 'O utilizador não é válido.';
    ELSIF NOT EXISTS (SELECT * FROM utilizador WHERE utilizador.hashed_id = editar_palavra_passe_utilizador.hashed_id_param) THEN
        RAISE EXCEPTION 'O utilizador não é válido.';
    END IF;

    IF palavra_passe IS NULL THEN
        RAISE EXCEPTION 'A palavra-passe do utilizador não é válida.';
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

    UPDATE utilizador SET palavra_passe = crypt(editar_palavra_passe_utilizador.palavra_passe, gen_salt('bf')) WHERE utilizador.hashed_id = editar_palavra_passe_utilizador.hashed_id_param;
    
    RETURN QUERY SELECT utilizador.hashed_id FROM utilizador WHERE utilizador.hashed_id = editar_palavra_passe_utilizador.hashed_id_param;
END;
$$ LANGUAGE plpgsql;


/**
    * Esta função permite listar todos os utilizadores.
    * @param {String} hashed_id_par - O HashedID do utilizador.
    * @param {String} nome_param - O nome do utilizador.
    * @param {Number} cargo_param - O cargo do utilizador.
    * @param {Number} offset_val - O offset da listagem.
    * @param {Number} limit_val - O limite da listagem.
    # @param {String} search_param - O array de pesquisa.
    * @param {Array} order_param - O array de ordenação.
    * @returns {Table} Retorna o utilizador editado.
    */
CREATE OR REPLACE FUNCTION listar_utilizadores(hashed_id_par varchar(255) DEFAULT NULL, nome_param varchar(255) DEFAULT NULL, cargo_param integer DEFAULT NULL, offset_val integer DEFAULT NULL, limit_val integer DEFAULT NULL, search_param varchar(255) DEFAULT NULL, order_param varchar(255)[] DEFAULT NULL)
RETURNS TABLE (hashed_id varchar(255), nome varchar(255), email varchar(255), cargo integer, texto_cargo text, data_criacao timestamp, estado integer, texto_estado text) AS $$
DECLARE
    _query text := 'SELECT utilizador.hashed_id, utilizador.nome, utilizador.email, utilizador.cargo, (CASE WHEN utilizador.cargo = 0 THEN ''Administrador'' WHEN utilizador.cargo = 1 THEN ''Médico'' ELSE ''Rececionista'' END), utilizador.data_criacao, utilizador.estado, (CASE WHEN utilizador.estado = 0 THEN ''Inativo'' ELSE ''Ativo'' END) FROM utilizador';
    _where text := '';
    _order text := '';
    _limit text := '';
    _offset text := '';
BEGIN

    IF hashed_id_par IS NOT NULL THEN
        _where := _where || ' WHERE utilizador.hashed_id = ' || hashed_id_par;
    ELSEIF nome_param IS NOT NULL THEN
        _where := _where || ' WHERE utilizador.nome ILIKE ''%' || nome_param || '%''';
    ELSEIF cargo_param IS NOT NULL THEN
        _where := _where || ' WHERE utilizador.cargo = ' || cargo_param;
    END IF;

    IF search_param IS NOT NULL THEN
        IF _where = '' THEN
            _where := _where || ' WHERE (utilizador.hashed_id ILIKE ''%' || search_param || '%'' OR utilizador.nome ILIKE ''%' || search_param || '%'' OR utilizador.email ILIKE ''%' || search_param || '%'' OR (CASE WHEN utilizador.cargo = 0 THEN ''Administrador'' WHEN utilizador.cargo = 1 THEN ''Médico'' ELSE ''Rececionista'' END) ILIKE ''%' || search_param || '%'' OR (CASE WHEN utilizador.estado = 0 THEN ''Inativo'' ELSE ''Ativo'' END) ILIKE ''%' || search_param || '%'')';
        ELSE
            _where := _where || ' AND (utilizador.hashed_id ILIKE ''%' || search_param || '%'' OR utilizador.nome ILIKE ''%' || search_param || '%'' OR utilizador.email ILIKE ''%' || search_param || '%'' OR (CASE WHEN utilizador.cargo = 0 THEN ''Administrador'' WHEN utilizador.cargo = 1 THEN ''Médico'' ELSE ''Rececionista'' END) ILIKE ''%' || search_param || '%'' OR (CASE WHEN utilizador.estado = 0 THEN ''Inativo'' ELSE ''Ativo'' END) ILIKE ''%' || search_param || '%'')';
        END IF;
    END IF;

    IF limit_val IS NOT NULL THEN
        _limit := _limit || ' LIMIT ' || limit_val;
    END IF;

    IF offset_val IS NOT NULL THEN
        _offset := _offset || ' OFFSET ' || offset_val;
    END IF;

    _query := _query || _where || _order || _limit || _offset;

    RETURN QUERY EXECUTE _query;
END;
$$ LANGUAGE plpgsql;



    

