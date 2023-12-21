/**
    * Esta função permite verificar se um concelho existe num distrito na base de dados.
    * @param {String} nome - O nome do concelho a ser verificado.
    * @param {Number} id_distrito - O identificador do distrito a ser verificado.
    * @returns {Boolean} Retorna verdadeiro se o concelho existir na base de dados.
    */
CREATE OR REPLACE FUNCTION existe_concelho(nome varchar(255), id_distrito bigint, id_concelho bigint DEFAULT NULL)
RETURNS boolean AS $$
BEGIN
    RETURN EXISTS (SELECT * FROM concelho WHERE concelho.nome = existe_concelho.nome AND concelho.id_distrito = existe_concelho.id_distrito AND concelho.id_concelho <> existe_concelho.id_concelho);
END;
$$ LANGUAGE plpgsql;


/**
 * Esta função permite inserir um novo concelho na base de dados.
    * @param {String} nome - O nome do concelho a ser inserido.
    * @param {Number} id_distrito - O identificador do distrito a ser inserido.
    * @returns {Boolean} Retorna verdadeiro se o concelho for inserido com sucesso.
 */
CREATE OR REPLACE FUNCTION inserir_concelho(inserir_concelho_nome varchar(255), inserir_concelho_id_distrito bigint)
RETURNS boolean AS $$
BEGIN 
    IF inserir_concelho_nome IS NULL OR inserir_concelho_nome = '' THEN
        RAISE EXCEPTION 'O nome do concelho não pode ser nulo.';
    END IF; 

    IF NOT EXISTS (SELECT * FROM distrito WHERE distrito.id_distrito = inserir_concelho_id_distrito) THEN
        RAISE EXCEPTION 'Não existe um distrito com o identificador %.', inserir_concelho_id_distrito;
    END IF;

    IF EXISTS (SELECT * FROM concelho WHERE concelho.nome = inserir_concelho_nome AND concelho.id_distrito = inserir_concelho_id_distrito) THEN
        RAISE EXCEPTION 'Já existe um concelho com o nome % neste distrito.', inserir_concelho_nome;
    END IF;

    INSERT INTO concelho (nome, id_distrito) VALUES (inserir_concelho_nome, inserir_concelho_id_distrito);
    RETURN TRUE;
END;
$$ LANGUAGE plpgsql;


/**
    * Esta função permite editar um concelho na base de dados.
    * @param {Number} id_concelho - O identificador do concelho a ser editado.
    * @param {String} nome - O novo nome do concelho.
    * @param {Number} id_distrito - O identificador do distrito a ser editado.
    * @returns {Boolean} Retorna verdadeiro se o concelho for editado com sucesso.
 */
CREATE OR REPLACE FUNCTION editar_concelho(id_concelho bigint, nome varchar(255), id_distrito bigint)
RETURNS boolean AS $$
BEGIN

    IF nome IS NULL OR nome = '' THEN
        RAISE EXCEPTION 'O nome do concelho não pode ser nulo.';
    END IF;

    IF NOT EXISTS (SELECT * FROM concelho WHERE concelho.id_concelho = editar_concelho.id_concelho) THEN
        RAISE EXCEPTION 'Não existe um concelho com o identificador %.', editar_concelho.id_concelho;
    END IF;

    IF NOT EXISTS (SELECT * FROM distrito WHERE distrito.id_distrito = editar_concelho.id_distrito) THEN
        RAISE EXCEPTION 'Não existe um distrito com o identificador %.', editar_concelho.id_distrito;
    END IF;

    IF EXISTS (SELECT * FROM concelho WHERE concelho.nome = editar_concelho.nome AND concelho.id_distrito = editar_concelho.id_distrito AND concelho.id_concelho <> editar_concelho.id_concelho) THEN
        RAISE EXCEPTION 'Já existe um concelho com o nome % neste distrito.', editar_concelho.nome;
    END IF;

    UPDATE concelho SET nome = editar_concelho.nome, id_distrito = editar_concelho.id_distrito WHERE concelho.id_concelho = editar_concelho.id_concelho;
    RETURN TRUE;
END;
$$ LANGUAGE plpgsql;


/**
    * Esta função permite remover um concelho da base de dados.
    * @param {Number} id_concelho - O identificador do concelho a ser removido.
    * @returns {Boolean} Retorna verdadeiro se o concelho for removido com sucesso.
    */
CREATE OR REPLACE FUNCTION remover_concelho(id_concelho bigint)
RETURNS boolean AS $$
BEGIN
    IF NOT EXISTS (SELECT * FROM concelho WHERE concelho.id_concelho = remover_concelho.id_concelho) THEN
        RAISE EXCEPTION 'Não existe um concelho com o identificador %.', remover_concelho.id_concelho;
    END IF;

    DELETE FROM concelho WHERE concelho.id_concelho = remover_concelho.id_concelho;
    RETURN TRUE;
END;
$$ LANGUAGE plpgsql;


/**
    * Esta função permite obter uma listagem de concelhos.
    * @param {Number} id_concelho_param - O identificador do concelho a ser filtrado.
    * @param {String} nome_param - O nome do concelho a ser filtrado.
    * @param {Number} id_distrito_param - O identificador do distrito a ser filtrado.
    * @returns {Table} Retorna uma tabela com os concelhos.
    */
CREATE OR REPLACE FUNCTION listar_concelhos(id_concelho_param bigint DEFAULT NULL, nome_param varchar(255) DEFAULT NULL, id_distrito_param bigint DEFAULT NULL)
RETURNS TABLE (id_concelho bigint, nome varchar(255), id_distrito bigint) AS $$
BEGIN
    IF id_concelho_param IS NOT NULL AND NOT EXISTS (SELECT * FROM concelho WHERE concelho.id_concelho = id_concelho_param) THEN
        RAISE EXCEPTION 'Não existe um concelho com o identificador %.', id_concelho_param;
    END IF;

    IF nome_param IS NOT NULL AND NOT EXISTS (SELECT * FROM concelho WHERE concelho.nome = nome_param) THEN
        RAISE EXCEPTION 'Não existe um concelho com o nome %.', nome_param;
    END IF;

    IF id_distrito_param IS NOT NULL AND NOT EXISTS (SELECT * FROM distrito WHERE distrito.id_distrito = id_distrito_param) THEN
        RAISE EXCEPTION 'Não existe um distrito com o identificador %.', id_distrito_param;
    END IF;

    RETURN QUERY SELECT * FROM concelho WHERE (id_concelho_param IS NULL OR concelho.id_concelho = id_concelho_param) AND (nome_param IS NULL OR concelho.nome = nome_param) AND (id_distrito_param IS NULL OR concelho.id_distrito = id_distrito_param) ORDER BY concelho.nome ASC;

END;
$$ LANGUAGE plpgsql;