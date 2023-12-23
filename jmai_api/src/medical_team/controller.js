const pool = require("../../db");
const axios = require('axios').default;
// Definir as tags da Documentação
/**
 * @swagger
 * tags:
 *   name: Equipas Médicas
 *   description: Gestão de Equipas Médicas
 */

const RegistarEquipaMedica = async (req, res) => {
    const { nome, cor, medicos } = req.body;
    pool.query(
		"SELECT * FROM inserir_equipa_medica($1, $2, $3)",
		[
			nome,
            cor,
            medicos,
		],
		(error, results) => {
			if (error) {
				res.status(400).json({
					status: "error",
					data: null,
					messages: [error.message],
				});
				return;
			}
			res.status(201).json({
				status: "success",
				data: results.rows[0],
				messages: ["Equipa Médica registada com sucesso!"],
			});
		}
	);
};

module.exports = {
    RegistarEquipaMedica,
};
