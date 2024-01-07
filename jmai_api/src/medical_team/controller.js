const pool = require("../../db");
const axios = require('axios').default;
// Definir as tags da Documentação
/**
 * @swagger
 * tags:
 *   name: Equipas Médicas
 *   description: Gestão de Equipas Médicas
 */


/**
 * @swagger
 * /api/equipas_medicas/registar:
 *  post:
 *      tags: [Equipas Médicas]
 *      summary: Registar Nova Equipa Médica
 *      description: Permite inserir uma nova Equipa Médica
 *      responses:
 *          '201':
 *              description: Sucesso
 *          '400':
 *              description: Erro
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

/**
 * @swagger
 * /api/equipas_medicas/listar:
 *  get:
 *      tags: [Equipas Médicas]
 *      summary: Lista de Equipas Médicas DataTable
 *      description: Obter Lista de Equipas Médicas para a DataTable
 *      responses:
 *          '201':
 *              description: Sucesso
 *          '400':
 *              description: Erro
 */
const ListarEquipasMedicasDataTable = async (req, res) => {
	pool.query(
		"SELECT * FROM listar_equipas_medicas()",
		(error, results) => {
			if (error) {
				res.status(400).json({
					recordsTotal: 0,
					recordsFiltered: 0,
					data: [],
				});
				return;
			}
			res.status(200).json({
				recordsTotal: results.rows.length,
				recordsFiltered: results.rows.length,
				data: results.rows,
			});
		}
	);
}

/**
 * @swagger
 * /api/equipas_medicas/listar_equipas_medicas:
 *  get:
 *      tags: [Equipas Médicas]
 *      summary: Lista de Equipas Médicas
 *      description: Obter Lista de Equipas Médicas
 *      responses:
 *          '200':
 *              description: Sucesso
 *          '400':
 *              description: Erro
 */
const ListarEquipasMedicas = async (req, res) => {
	const { estado } = req.query;
	pool.query(
		"SELECT * FROM listar_equipas_medicas(NULL, $1)",
		[estado],
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

/**
 * @swagger
 * /api/equipas_medicas/ver/{hashed_id}:
 *  get:
 *      tags: [Equipas Médicas]
 *      summary: Ver Equipa Médica
 *      description: Obter Informação da Equipa Médica
 *      responses:
 *          '200':
 *              description: Sucesso
 *          '400':
 *              description: Erro
 */
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

/**
 * @swagger
 * /api/equipas_medicas/editar/{hashed_id}:
 *  put:
 *      tags: [Equipas Médicas]
 *      summary: Editar Equipa Médica
 *      description: Editar Equipa Médica
 *      responses:
 *          '200':
 *              description: Sucesso
 *          '400':
 *              description: Erro
 */
const EditarEquipaMedica = async (req, res) => {
	const hashed_id = req.params.hashed_id;
	const { nome, cor, medicos } = req.body;
	pool.query(
		"SELECT * FROM editar_equipa_medica($1, $2, $3, $4)",
		[
			hashed_id,
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
			res.status(200).json({
				status: "success",
				data: results.rows[0],
				messages: ["Equipa Médica editada com sucesso!"],
			});
		}
	);
}

/**
 * @swagger
 * /api/equipas_medicas/desativar/{hashed_id}:
 *  put:
 *      tags: [Equipas Médicas]
 *      summary: Desativar Equipa Médica
 *      description: Desativar uma Equipa Médica
 *      responses:
 *          '200':
 *              description: Sucesso
 *          '400':
 *              description: Erro
 */
const RemoverEquipaMedica = async (req, res) => {
	const hashed_id = req.params.hashed_id;
	pool.query(
		"SELECT * FROM alterar_estado_equipa_medica($1, 0)",
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
				data: null,
				messages: ["Equipa Médica desativada com sucesso!"],
			});
		}
	);
}

/**
 * @swagger
 * /api/equipas_medicas/ativar/{hashed_id}:
 *  put:
 *      tags: [Equipas Médicas]
 *      summary: Ativar Equipa Médica
 *      description: Ativar uma Equipa Médica
 *      responses:
 *          '200':
 *              description: Sucesso
 *          '400':
 *              description: Erro
 */
const AtivarEquipaMedica = async (req, res) => {
	const hashed_id = req.params.hashed_id;
	pool.query(
		"SELECT * FROM alterar_estado_equipa_medica($1, 1)",
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
				data: null,
				messages: ["Equipa Médica ativada com sucesso!"],
			});
		}
	);
}

module.exports = {
    RegistarEquipaMedica,
	ListarEquipasMedicasDataTable,
	ListarEquipasMedicas,
	VerEquipaMedica,
	EditarEquipaMedica,
	RemoverEquipaMedica,
	AtivarEquipaMedica
};
