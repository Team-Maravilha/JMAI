/**
    * Esta função permite verificar se o nome de um país existe na base de dados.
    * @param {String} nome - O nome do país a ser verificado.
    * @returns {Boolean} Retorna verdadeiro se o país existir na base de dados.
 */
CREATE OR REPLACE FUNCTION existe_pais(nome varchar(255), id_pais bigint DEFAULT NULL)
RETURNS boolean AS $$
BEGIN
    RETURN EXISTS (SELECT * FROM pais WHERE pais.nome = existe_pais.nome AND (pais.id_pais <> existe_pais.id_pais OR existe_pais.id_pais IS NULL));
END;
$$ LANGUAGE plpgsql;


/**
 * Esta função permite inserir um novo país na base de dados.
    * @param {String} nome - O nome do país a ser inserido.
    * @returns {Boolean} Retorna verdadeiro se o país for inserido com sucesso.
 */
CREATE OR REPLACE FUNCTION inserir_pais(nome varchar(255))
RETURNS boolean AS $$
BEGIN

    IF nome IS NULL THEN
        RAISE EXCEPTION 'O nome do país não pode ser nulo.';
    END IF;

    IF EXISTS (SELECT * FROM pais WHERE pais.nome = inserir_pais.nome) THEN
        RAISE EXCEPTION 'Já existe um país com o nome %.', inserir_pais.nome;
    END IF;

    INSERT INTO pais (nome) VALUES (inserir_pais.nome);
    RETURN TRUE;
END;
$$ LANGUAGE plpgsql;


/**
    * Esta função permite editar um país na base de dados.
    * @param {Number} id_pais - O identificador do país a ser editado.
    * @param {String} nome - O novo nome do país.
    * @returns {Boolean} Retorna verdadeiro se o país for editado com sucesso.
 */
CREATE OR REPLACE FUNCTION editar_pais(id_pais bigint, nome varchar(255))
RETURNS boolean AS $$
BEGIN

    IF nome IS NULL THEN
        RAISE EXCEPTION 'O nome do país não pode ser nulo.';
    END IF;

    IF NOT EXISTS (SELECT * FROM pais WHERE pais.id_pais = editar_pais.id_pais) THEN
        RAISE EXCEPTION 'Não existe um país com o identificador %.', editar_pais.id_pais;
    END IF;

    IF existe_pais(editar_pais.nome, editar_pais.id_pais) = TRUE THEN
        RAISE EXCEPTION 'Já existe um país com o nome %.', editar_pais.nome;
    END IF;

    UPDATE pais SET nome = editar_pais.nome WHERE pais.id_pais = editar_pais.id_pais;
    RETURN TRUE;
END;
$$ LANGUAGE plpgsql;


/**
    * Esta função permite remover um país da base de dados.
    * @param {Number} id_pais - O identificador do país a ser removido.
    * @returns {Boolean} Retorna verdadeiro se o país for removido com sucesso.
 */ 
CREATE OR REPLACE FUNCTION remover_pais(id_pais bigint)
RETURNS boolean AS $$
BEGIN

    IF NOT EXISTS (SELECT * FROM pais WHERE pais.id_pais = remover_pais.id_pais) THEN
        RAISE EXCEPTION 'Não existe um país com o identificador %.', remover_pais.id_pais;
    END IF;

    DELETE FROM pais WHERE pais.id_pais = remover_pais.id_pais;
    RETURN TRUE;
END;
$$ LANGUAGE plpgsql;


/**
    * Esta função permite obter uma listagem de paises.
    * @param {Number} id_pais_param - O identificador do país.
    * @param {String} nome_param - O nome do país.
    * @param {Number} offset_val - O offset da listagem.
    * @param {Number} limit_val - O limite da listagem.
    * @returns {Table} Retorna uma tabela com os paises.
 */
CREATE OR REPLACE FUNCTION listar_paises(
    id_pais_param bigint DEFAULT NULL, 
    nome_param varchar(255) DEFAULT NULL)
RETURNS TABLE (id_pais bigint, nome varchar(255)) AS $$
BEGIN

    IF id_pais_param IS NOT NULL AND NOT EXISTS (SELECT * FROM pais WHERE pais.id_pais = id_pais_param) THEN
        RAISE EXCEPTION 'Não existe um país com o identificador %.', id_pais_param;
    END IF;

    IF nome_param IS NOT NULL AND existe_pais(nome_param) = FALSE THEN
        RAISE EXCEPTION 'Não existe um país com o nome %.', nome_param;
    END IF;

    RETURN QUERY
    SELECT p.id_pais, p.nome
    FROM pais p
    WHERE (p.id_pais = id_pais_param OR id_pais_param IS NULL)
    AND (p.nome = nome_param OR nome_param IS NULL);
END;
$$ LANGUAGE plpgsql;


