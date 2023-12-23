/**
    * Esta função permite inserir uma nova equipa médica na base de dados.
    * @param {String} nome_param - O nome da equipa médica.
    * @param {String} cor_param - A cor da equipa médica.
    * @param {JSON} membros_param - Os membros da equipa médica.
    * @returns {Boolean} Retorna verdadeiro se o distrito for inserido com sucesso.
 */
CREATE OR REPLACE FUNCTION inserir_equipa_medica(nome_param varchar(255), cor_param varchar(255), membros_param json)
RETURNS TABLE (hashed_id varchar(255)) AS $$
DECLARE 
    medico record;
    id_equipa_medica_aux int;
BEGIN

    IF nome_param IS NULL OR nome_param = '' THEN
        RAISE EXCEPTION 'O nome da equipa médica não é válido.';
    ELSIF EXISTS (SELECT * FROM equipa_medica WHERE nome = nome_param) THEN
        RAISE EXCEPTION 'Já existe uma equipa médica com esse nome.';
    END IF;

    IF cor_param IS NULL OR cor_param = '' THEN
        RAISE EXCEPTION 'A cor da equipa médica não é válida.';
    ELSIF EXISTS (SELECT * FROM equipa_medica WHERE cor = cor_param) THEN
        RAISE EXCEPTION 'Já existe uma equipa médica com essa cor.';
    END IF;


    INSERT INTO equipa_medica (nome, cor) VALUES (nome_param, cor_param) RETURNING id_equipa_medica INTO id_equipa_medica_aux;

    IF membros_param IS NOT NULL THEN
        FOR medico IN SELECT * FROM json_array_elements(membros_param) LOOP
            DECLARE
                hashed_id_medico text := medico.value->>'hashed_id';
                id_medico_aux bigint;
            BEGIN
                IF hashed_id_medico IS NULL OR hashed_id_medico = '' THEN
                    --RAISE EXCEPTION 'O hashed_id do médico não pode ser nulo.';
                ELSIF NOT EXISTS (SELECT * FROM utilizador WHERE utilizador.hashed_id = hashed_id_medico) THEN
                    --RAISE EXCEPTION 'Não existe nenhum médico com esse hashed_id.';
                ELSE
                    SELECT utilizador.id_utlizador INTO id_medico_aux FROM utilizador WHERE utilizador.hashed_id = hashed_id_medico;
                    INSERT INTO equipa_medica_medicos (id_utilizador, id_equipa_medica) VALUES (id_medico_aux, id_equipa_medica_aux);
                END IF;
            END;
        END LOOP;
    END IF;

    RETURN QUERY SELECT equipa_medica.hashed_id FROM equipa_medica WHERE equipa_medica.id_equipa_medica = id_equipa_medica_aux;
END;
$$ LANGUAGE plpgsql;
SELECT * FROM inserir_equipa_medica('equipa1', 'cor1', '[{"hashed_id": "7f707912-5b68-4497-8e69-43a7aeb0006e"}, {"hashed_id": "11d062d3-2831-4de4-95b0-a7063afb03d1"}]');



/**
    * Adicionar o HashedID a uma equipa médica.
    */
CREATE TRIGGER add_uuid BEFORE INSERT ON equipa_medica FOR EACH ROW EXECUTE PROCEDURE add_uuid();


/**
    * Esta função permite obter todas as equipas médicas.
    * @param {String} hashed_id_param - O hashed_id da equipa médica.
    * @returns {Set} Retorna um conjunto de equipas médicas.
 */
CREATE OR REPLACE FUNCTION listar_equipas_medicas(hashed_id_param varchar(255) DEFAULT NULL)
RETURNS TABLE (hashed_id varchar(255), nome varchar(255), cor varchar(255), medicos json) AS $$
BEGIN
    
    IF hashed_id_param IS NOT NULL THEN
        IF NOT EXISTS (SELECT * FROM equipa_medica WHERE equipa_medica.hashed_id = hashed_id_param) THEN
            RAISE EXCEPTION 'Não existe nenhuma equipa médica com o identificador.';
        END IF;
    END IF; 

    RETURN QUERY SELECT equipa_medica.hashed_id, equipa_medica.nome, equipa_medica.cor, (SELECT json_agg(json_build_object('hashed_id', utilizador.hashed_id, 'nome', utilizador.nome)) FROM equipa_medica_medicos INNER JOIN utilizador ON equipa_medica_medicos.id_utilizador = utilizador.id_utlizador WHERE equipa_medica_medicos.id_equipa_medica = equipa_medica.id_equipa_medica) FROM equipa_medica WHERE 1 = 1 AND (hashed_id_param IS NULL OR equipa_medica.hashed_id = hashed_id_param);
END;
$$ LANGUAGE plpgsql;


    