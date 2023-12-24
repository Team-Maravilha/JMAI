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

const ListarEquipasMedicas = async (req, res) => {
	pool.query(
		"SELECT * FROM listar_equipas_medicas()",
		(error, results) => {
			if (error) {
				res.status(400).json({
					status: "error",
					data: null,
					messages: [error.message],
				});
				return;
			}
			res.status(200).json({
				status: "success",
				data: results.rows,
				messages: ["Lista de Equipas Médicas obtida com sucesso!"],
			});
		}
	);
}

const VerEquipaMedica = async (req, res) => {
	const hashed_id = req.params.hashed_id;
	pool.query(
		"SELECT * FROM listar_equipas_medicas($1)",
		[hashed_id],
		(error, results) => {
			if (error) {
				res.status(400).json({
					status: "error",
					data: null,
					messages: [error.message],
				});
				return;
			}
			res.status(200).json({
				status: "success",
				data: results.rows[0],
				messages: ["Equipa Médica obtida com sucesso!"],
			});
		}
	);
}

module.exports = {
    RegistarEquipaMedica,
	ListarEquipasMedicas,
	VerEquipaMedica
};
