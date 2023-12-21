/**
 * Esta função gera um hash aleatório de 8 caracteres.
 * @returns {string} Retorna o hash gerado.
 */
CREATE OR REPLACE FUNCTION add_uuid() RETURNS TRIGGER AS $$
BEGIN
  NEW.hashed_id = uuid_generate_v4();
  RETURN NEW;
END;
$$ LANGUAGE plpgsql;


/**
 * Esta função verifica se uma data está no formato YYYY-MM-DD.
 * @param {Date} data - A data a ser verificada.
 * @returns {boolean} Retorna verdadeiro se a data estiver no formato válido.
 */
CREATE OR REPLACE FUNCTION verificar_data(data date)
RETURNS boolean AS $$
BEGIN
    IF data IS NULL THEN
        RETURN FALSE;
    END IF;

    IF data ~ '^(?:20\d{2}|19\d{2})-(?:0[1-9]|1[0-2])-(?:0[1-9]|[12]\d|3[01])$' THEN
        RETURN TRUE;
    ELSE
        RETURN FALSE;
    END IF;
END;
$$ LANGUAGE plpgsql;


/**
 * Esta função converte uma data no formato ISO (YYYY-MM-DD) para o formato PT (DD/MM/YYYY).
 * @param {Date} data - A data a ser convertida.
 * @returns {Date} Retorna a data convertida.
 */
CREATE OR REPLACE FUNCTION converter_from_iso_to_pt(data date)
RETURNS date AS $$
BEGIN
    IF data IS NULL THEN
        RETURN NULL;
    END IF;

    IF verificar_data(data) = FALSE THEN
        RETURN NULL;
    END IF;

    RETURN to_date(data::text, 'YYYY-MM-DD');
END;
$$ LANGUAGE plpgsql;


/**
 * Esta função converte uma data no formato PT (DD/MM/YYYY) para o formato ISO (YYYY-MM-DD).
 * @param {Date} data - A data a ser convertida.
 * @returns {Date} Retorna a data convertida.
 */
CREATE OR REPLACE FUNCTION converter_from_pt_to_iso(data date)
RETURNS date AS $$
BEGIN
    IF data IS NULL THEN
        RETURN NULL; -- Retorna NULL quando a entrada é NULL
    END IF;

    RETURN to_date(data::text, 'DD/MM/YYYY');
END;
$$ LANGUAGE plpgsql;

/**
 * Esta função verifica se uma data e hora estão no formato YYYY-MM-DD HH:MM:SS.
 * @param {DateTime} data_hora - A data e hora a ser verificada.
 * @returns {boolean} Retorna verdadeiro se a data estiver no formato válido.
 */
CREATE OR REPLACE FUNCTION verificar_data_hora(data_hora timestamp)
RETURNS boolean AS $$
BEGIN
	IF data_hora IS NULL THEN
		RETURN FALSE;
	END IF;

	IF data_hora ~ '^(?:20\d{2}|19\d{2})-(?:0[1-9]|1[0-2])-(?:0[1-9]|[12]\d|3[01]) (?:[01]\d|2[0-3]):(?:[0-5]\d):(?:[0-5]\d)$' THEN
		RETURN TRUE;
	ELSE
		RETURN FALSE;
	END IF;
END;
$$ LANGUAGE plpgsql;


/**
 * Esta função converte uma data e hora no formato ISO (YYYY-MM-DD HH:MM:SS) para o formato PT (DD/MM/YYYY HH:MM:SS).
 * @param {DateTime} data_hora - A data e hora a ser convertida.
 * @returns {DateTime} Retorna a data e hora convertida.
 */
CREATE OR REPLACE FUNCTION converter_data_hora_from_iso_to_pt(data_hora timestamp)
RETURNS timestamp AS $$
BEGIN
	IF data_hora IS NULL THEN
		RETURN NULL;
	END IF;

	IF verificar_data_hora(data_hora) = FALSE THEN
		RETURN NULL;
	END IF;

	RETURN to_timestamp(data_hora::text, 'YYYY-MM-DD HH24:MI:SS');
END;
$$ LANGUAGE plpgsql;


/**
 * Esta função converte uma data e hora no formato PT (DD/MM/YYYY HH:MM:SS) para o formato ISO (YYYY-MM-DD HH:MM:SS).
 * @param {DateTime} data_hora - A data e hora a ser convertida.
 * @returns {DateTime} Retorna a data e hora convertida.
 */
CREATE OR REPLACE FUNCTION converter_data_hora_from_pt_to_iso(data_hora timestamp)
RETURNS timestamp AS $$
BEGIN
	IF data_hora IS NULL THEN
		RETURN NULL;
	END IF;

	RETURN to_timestamp(data_hora::text, 'DD/MM/YYYY HH24:MI:SS');
END;
$$ LANGUAGE plpgsql;



