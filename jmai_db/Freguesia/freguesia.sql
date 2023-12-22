/**
    * Esta função permite verificar se uma freguesia existe num concelho na base de dados.
    * @param {String} nome - O nome da freguesia a ser verificada.
    * @param {Number} id_concelho - O identificador do concelho a ser verificado.
    * @returns {Boolean} Retorna verdadeiro se a freguesia existir na base de dados.
    */
CREATE OR REPLACE FUNCTION existe_freguesia(nome varchar(255), id_concelho bigint, id_freguesia bigint DEFAULT NULL)
RETURNS boolean AS $$
BEGIN
    RETURN EXISTS (SELECT * FROM freguesia WHERE freguesia.nome = existe_freguesia.nome AND freguesia.id_concelho = existe_freguesia.id_concelho AND freguesia.id_freguesia <> existe_freguesia.id_freguesia);
END;
$$ LANGUAGE plpgsql;


/**
 * Esta função permite inserir uma nova freguesia na base de dados.
    * @param {String} nome - O nome da freguesia a ser inserida.
    * @param {Number} id_concelho - O identificador do concelho a ser inserido.
    * @returns {Boolean} Retorna verdadeiro se a freguesia for inserida com sucesso.
 */
CREATE OR REPLACE FUNCTION inserir_freguesia(inserir_freguesia_nome varchar(255), inserir_freguesia_id_concelho bigint)
RETURNS boolean AS $$
BEGIN 
    IF inserir_freguesia_nome IS NULL OR inserir_freguesia_nome = '' THEN
        RAISE EXCEPTION 'O nome da freguesia não pode ser nulo.';
    END IF; 

    IF NOT EXISTS (SELECT * FROM concelho WHERE concelho.id_concelho = inserir_freguesia_id_concelho) THEN
        RAISE EXCEPTION 'Não existe um concelho com o identificador %.', inserir_freguesia_id_concelho;
    END IF;

    IF EXISTS (SELECT * FROM freguesia WHERE freguesia.nome = inserir_freguesia_nome AND freguesia.id_concelho = inserir_freguesia_id_concelho) THEN
        RAISE EXCEPTION 'Já existe uma freguesia com o nome % neste concelho.', inserir_freguesia_nome;
    END IF;

    INSERT INTO freguesia (nome, id_concelho) VALUES (inserir_freguesia_nome, inserir_freguesia_id_concelho);
    RETURN TRUE;
END;
$$ LANGUAGE plpgsql;


/**
    * Esta função permite editar uma freguesia na base de dados.
    * @param {Number} id_freguesia - O identificador da freguesia a ser editada.
    * @param {String} nome - O novo nome da freguesia.
    * @param {Number} id_concelho - O identificador do concelho a ser editado.
    * @returns {Boolean} Retorna verdadeiro se a freguesia for editada com sucesso.
 */
CREATE OR REPLACE FUNCTION editar_freguesia(id_freguesia bigint, nome varchar(255), id_concelho bigint)
RETURNS boolean AS $$
BEGIN

    IF nome IS NULL OR nome = '' THEN
        RAISE EXCEPTION 'O nome da freguesia não pode ser nulo.';
    END IF;

    IF NOT EXISTS (SELECT * FROM freguesia WHERE freguesia.id_freguesia = editar_freguesia.id_freguesia) THEN
        RAISE EXCEPTION 'Não existe uma freguesia com o identificador %.', editar_freguesia.id_freguesia;
    END IF;

    IF NOT EXISTS (SELECT * FROM concelho WHERE concelho.id_concelho = editar_freguesia.id_concelho) THEN
        RAISE EXCEPTION 'Não existe um concelho com o identificador %.', editar_freguesia.id_concelho;
    END IF;

    IF EXISTS (SELECT * FROM freguesia WHERE freguesia.nome = editar_freguesia.nome AND freguesia.id_concelho = editar_freguesia.id_concelho) THEN
        RAISE EXCEPTION 'Já existe uma freguesia com o nome % neste concelho.', editar_freguesia.nome;
    END IF;

    UPDATE freguesia SET nome = editar_freguesia.nome, id_concelho = editar_freguesia.id_concelho WHERE freguesia.id_freguesia = editar_freguesia.id_freguesia;
    RETURN TRUE;
END;
$$ LANGUAGE plpgsql;


/**
    * Esta função permite remover uma freguesia da base de dados.
    * @param {Number} id_freguesia - O identificador da freguesia a ser removida.
    * @returns {Boolean} Retorna verdadeiro se a freguesia for removida com sucesso.
 */
CREATE OR REPLACE FUNCTION remover_freguesia(id_freguesia bigint)
RETURNS boolean AS $$
BEGIN
    IF NOT EXISTS (SELECT * FROM freguesia WHERE freguesia.id_freguesia = remover_freguesia.id_freguesia) THEN
        RAISE EXCEPTION 'Não existe uma freguesia com o identificador %.', remover_freguesia.id_freguesia;
    END IF;

    DELETE FROM freguesia WHERE freguesia.id_freguesia = remover_freguesia.id_freguesia;
    RETURN TRUE;
END;
$$ LANGUAGE plpgsql;


/**
    * Esta função permite obter uma listagem de freguesias.
    * @param {Number} id_freguesia_param - O identificador da freguesia a ser obtida.
    * @param {String} nome_param - O nome da freguesia a ser obtida.
    * @param {Number} id_concelho_param - O identificador do concelho a ser obtido.
    * @returns {Table} Retorna uma tabela com as freguesias.
    */
CREATE OR REPLACE FUNCTION listar_freguesias(id_freguesia_param bigint DEFAULT NULL, nome_param varchar(255) DEFAULT NULL, id_concelho_param bigint DEFAULT NULL)
RETURNS TABLE (id_freguesia bigint, nome varchar(255), id_concelho bigint) AS $$
BEGIN
    IF id_freguesia_param IS NOT NULL AND NOT EXISTS (SELECT * FROM freguesia WHERE freguesia.id_freguesia = id_freguesia_param) THEN
        RAISE EXCEPTION 'Não existe uma freguesia com o identificador %.', id_freguesia_param;
    END IF;

    IF nome_param IS NOT NULL AND NOT EXISTS (SELECT * FROM freguesia WHERE freguesia.nome = nome_param) THEN
        RAISE EXCEPTION 'Não existe uma freguesia com o nome %.', nome_param;
    END IF;

    IF id_concelho_param IS NOT NULL AND NOT EXISTS (SELECT * FROM concelho WHERE concelho.id_concelho = id_concelho_param) THEN
        RAISE EXCEPTION 'Não existe um concelho com o identificador %.', id_concelho_param;
    END IF;

    RETURN QUERY SELECT * FROM freguesia WHERE (id_freguesia_param IS NULL OR freguesia.id_freguesia = id_freguesia_param) AND (nome_param IS NULL OR freguesia.nome = nome_param) AND (id_concelho_param IS NULL OR freguesia.id_concelho = id_concelho_param);

END;
$$ LANGUAGE plpgsql;