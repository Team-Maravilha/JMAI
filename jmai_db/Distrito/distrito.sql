/**
    * Esta função permite verificar se um distrito existe num pais na base de dados.
    * @param {String} nome - O nome do distrito a ser verificado.
    * @param {Number} id_pais - O identificador do país a ser verificado.
    * @returns {Boolean} Retorna verdadeiro se o país existir na base de dados.
 */
CREATE OR REPLACE FUNCTION existe_distrito(nome varchar(255), id_pais bigint, id_distrito bigint DEFAULT NULL)
RETURNS boolean AS $$
BEGIN
    RETURN EXISTS (SELECT * FROM distrito WHERE distrito.nome = existe_distrito.nome AND distrito.id_pais = existe_distrito.id_pais AND distrito.id_distrito <> existe_distrito.id_distrito);
END;
$$ LANGUAGE plpgsql;


/**
 * Esta função permite inserir um novo distrito na base de dados.
    * @param {String} nome - O nome do distrito a ser inserido.
    * @param {Number} id_pais - O identificador do país a ser inserido.
    * @returns {Boolean} Retorna verdadeiro se o distrito for inserido com sucesso.
 */
CREATE OR REPLACE FUNCTION inserir_distrito(inserir_distrito_nome varchar(255), inserir_distrito_id_pais bigint)
RETURNS boolean AS $$
BEGIN
    IF inserir_distrito_nome IS NULL THEN
        RAISE EXCEPTION 'O nome do distrito não pode ser nulo.';
    END IF;

    IF NOT EXISTS (SELECT * FROM pais WHERE pais.id_pais = inserir_distrito_id_pais) THEN
        RAISE EXCEPTION 'Não existe um país com o identificador %.', inserir_distrito_id_pais;
    END IF;

    IF EXISTS (SELECT * FROM distrito WHERE distrito.nome = inserir_distrito_nome AND distrito.id_pais = inserir_distrito_id_pais) THEN
        RAISE EXCEPTION 'Já existe um distrito com o nome % neste país.', inserir_distrito_nome;
    END IF;

    INSERT INTO distrito (nome, id_pais) VALUES (inserir_distrito_nome, inserir_distrito_id_pais);
    RETURN TRUE;
END;
$$ LANGUAGE plpgsql;



/**
    * Esta função permite editar um distrito na base de dados.
    * @param {Number} id_distrito - O identificador do distrito a ser editado.
    * @param {String} nome - O novo nome do distrito.
    * @param {Number} id_pais - O identificador do país a ser editado.
    * @returns {Boolean} Retorna verdadeiro se o distrito for editado com sucesso.
 */
CREATE OR REPLACE FUNCTION editar_distrito(id_distrito bigint, nome varchar(255), id_pais bigint)
RETURNS boolean AS $$
BEGIN

    IF nome IS NULL THEN
        RAISE EXCEPTION 'O nome do distrito não pode ser nulo.';
    END IF;

    IF NOT EXISTS (SELECT * FROM distrito WHERE distrito.id_distrito = editar_distrito.id_distrito) THEN
        RAISE EXCEPTION 'Não existe um distrito com o identificador %.', editar_distrito.id_distrito;
    END IF;

    IF NOT EXISTS (SELECT * FROM pais WHERE pais.id_pais = editar_distrito.id_pais) THEN
        RAISE EXCEPTION 'Não existe um país com o identificador %.', editar_distrito.id_pais;
    END IF;

    IF existe_distrito(editar_distrito.nome, editar_distrito.id_pais, editar_distrito.id_distrito) = TRUE THEN
        RAISE EXCEPTION 'Já existe um distrito com o nome %.', editar_distrito.nome;
    END IF;

    UPDATE distrito SET nome = editar_distrito.nome, id_pais = editar_distrito.id_pais WHERE distrito.id_distrito = editar_distrito.id_distrito;
    RETURN TRUE;
END;
$$ LANGUAGE plpgsql;


/**
    * Esta função permite remover um distrito da base de dados.
    * @param {Number} id_distrito - O identificador do distrito a ser removido.
    * @returns {Boolean} Retorna verdadeiro se o distrito for removido com sucesso.
 */
CREATE OR REPLACE FUNCTION remover_distrito(id_distrito bigint)
RETURNS boolean AS $$
BEGIN

    IF NOT EXISTS (SELECT * FROM distrito WHERE distrito.id_distrito = remover_distrito.id_distrito) THEN
        RAISE EXCEPTION 'Não existe um distrito com o identificador %.', remover_distrito.id_distrito;
    END IF;

    DELETE FROM distrito WHERE distrito.id_distrito = remover_distrito.id_distrito;
    RETURN TRUE;
END;
$$ LANGUAGE plpgsql;

/**
    * Esta função permite obter uma listagem de distritos.
    * @param {Number} id_distrito_param - O identificador do distrito.
    * @param {String} nome_param - O nome do distrito.
    * @param {Number} id_pais_param - O identificador do país.
    * @returns {Table} Retorna uma tabela com os paises.
 */ 
CREATE OR REPLACE FUNCTION listar_distritos(id_distrito_param bigint DEFAULT NULL, nome_param varchar(255) DEFAULT NULL, id_pais_param bigint DEFAULT NULL)
RETURNS TABLE(id_distrito bigint, nome varchar(255), id_pais bigint) AS $$
BEGIN

    IF id_distrito_param IS NOT NULL AND NOT EXISTS (SELECT * FROM distrito WHERE distrito.id_distrito = id_distrito_param) THEN
        RAISE EXCEPTION 'Não existe um distrito com o identificador %.', id_distrito_param;
    END IF;

    IF nome_param IS NOT NULL AND NOT EXISTS (SELECT * FROM distrito WHERE distrito.nome LIKE nome_param) THEN
        RAISE EXCEPTION 'Não existe um distrito com o nome %.', nome_param;
    END IF;

    IF id_pais_param IS NOT NULL AND NOT EXISTS (SELECT * FROM pais WHERE pais.id_pais = id_pais_param) THEN
        RAISE EXCEPTION 'Não existe um país com o identificador %.', id_pais_param;
    END IF;

    RETURN QUERY
    SELECT distrito.id_distrito, distrito.nome, distrito.id_pais FROM distrito
    WHERE (distrito.id_distrito = listar_distritos.id_distrito_param OR listar_distritos.id_distrito_param IS NULL)
    AND (distrito.nome LIKE listar_distritos.nome_param OR listar_distritos.nome_param IS NULL)
    AND (distrito.id_pais = listar_distritos.id_pais_param OR listar_distritos.id_pais_param IS NULL)
    ORDER BY distrito.nome ASC;
END;
$$ LANGUAGE plpgsql;
