const pool = require("../../db");
// Definir as tags da Documentação
/**
 * @swagger
 * tags:
 *   name: Dashboard
 *   description: Obter dados para Dashboard
 */

/**
 * @swagger
 * /api/graficos/requerimentos_por_distrito:
 *  get:
 *      tags: [Dashboard]
 *      summary: Requerimentos por Distrito
 *      description: Obter Dados de Requerimentos por Distrito
 *      responses:
 *          '200':
 *              description: Sucesso
 *          '400':
 *              description: Erro
 */
const RequerimentoPorDistrito = (req, res) => {
	const { id_pais, data_inicio, data_fim } = req.query;
	pool.query("SELECT * FROM listar_contagem_requerimentos_por_distrito($1, $2, $3)", [id_pais, data_inicio, data_fim], (error, results) => {
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
			messages: ["Lista de Requerimentos por Distrito obtida com sucesso"],
		});
	});
};

/**
 * @swagger
 * /api/graficos/requerimentos_por_concelho:
 *   get:
 *     tags: [Dashboard]
 *     summary: Requerimentos por Concelho
 *     description: Obter Dados de Requerimentos por Concelho
 *     responses:
 *          '200':
 *              description: Sucesso
 *          '400':
 *              description: Erro
 */
const RequerimentoPorConcelho = (req, res) => {
	const { id_distrito, data_inicio, data_fim } = req.query;
	pool.query("SELECT * FROM listar_contagem_requerimentos_por_concelho($1, $2, $3)", [id_distrito, data_inicio, data_fim], (error, results) => {
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
			messages: ["Lista de Requerimentos por Concelho obtida com sucesso"],
		});
	});
}

/**
 * @swagger
 * /api/graficos/requerimentos_por_periodo:
 *   get:
 *     tags: [Dashboard]
 *     summary: Total Requerimentos por Período
 *     description: Obter Dados do Total Requerimentos por Período
 *     responses:
 *          '200':
 *              description: Sucesso
 *          '400':
 *              description: Erro
 */
const RequerimentoPorPeriodo = (req, res) => {
	const { data_inicio, data_fim } = req.query;
	pool.query("SELECT * FROM listar_contagem_requerimentos_por_periodo($1, $2)", [data_inicio, data_fim], (error, results) => {
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
			messages: ["Lista de Requerimentos por Período obtida com sucesso"],
		});
	});
}

/**
 * @swagger
 * /api/graficos/requerimentos_por_estado:
 *   get:
 *     tags: [Dashboard]
 *     summary: Total Requerimentos por Estado
 *     description: Obter Dados do Total Requerimentos por Estado
 *     responses:
 *          '200':
 *              description: Sucesso
 *          '400':
 *              description: Erro
 */
const RequerimentoPorEstado = (req, res) => {
	pool.query("SELECT * FROM listar_contagem_requerimentos_por_estado()", [], (error, results) => {
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
			messages: ["Lista de Requerimentos por Estado obtida com sucesso"],
		});
	});
}

/**
 * @swagger
 * /api/graficos/requerimentos_por_mes_anual:
 *   get:
 *     tags: [Dashboard]
 *     summary: Total Requerimentos por Mês Anual
 *     description: Obter Dados do Total Requerimentos por Mês Anual
 *     responses:
 *          '200':
 *              description: Sucesso
 *          '400':
 *              description: Erro
 */
const RequerimentoPorMesAnual = (req, res) => {
	pool.query("SELECT * FROM listar_contagem_requerimentos_anual()", [], (error, results) => {
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
			messages: ["Lista de Requerimentos por Mês Anual obtida com sucesso"],
		});
	});
}

/**
 * @swagger
 * /api/graficos/dashboard_totais:
 *   get:
 *     tags: [Dashboard]
 *     summary: Total Requerimentos para Indicadores Administrador
 *     description: Obter Dados do Total Requerimentos para Indicadores Administrador
 *     responses:
 *          '200':
 *              description: Sucesso
 *          '400':
 *              description: Erro
 */
const DashboardTotais = (req, res) => {
	pool.query("SELECT * FROM listar_contagem_dashboard()", [], (error, results) => {
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
			messages: ["Totais obtidos com sucesso"],
		});
	});
}

/**
 * @swagger
 * /api/graficos/dashboard_totais_por_utilizador:
 *   get:
 *     tags: [Dashboard]
 *     summary: Total Requerimentos para Indicadores Utilizadores
 *     description: Obter Dados do Total Requerimentos para Indicadores Utilizadores
 *     responses:
 *          '200':
 *              description: Sucesso
 *          '400':
 *              description: Erro
 */
const DashboardTotaisPorUtilizador = (req, res) => {
	const { id_utilizador } = req.query;
	pool.query("SELECT * FROM listar_contagem_dashboard_por_utilizador($1)", [id_utilizador], (error, results) => {
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
			messages: ["Totais obtidos com sucesso"],
		});
	});
}

/**
 * @swagger
 * /api/graficos/dashboard_totais_por_utente:
 *   get:
 *     tags: [Dashboard]
 *     summary: Total Requerimentos para Indicadores Utentes
 *     description: Obter Dados do Total Requerimentos para Indicadores Utentes
 *     responses:
 *          '200':
 *              description: Sucesso
 *          '400':
 *              description: Erro
 */
const DashboardTotaisPorUtente = (req, res) => {
	const { id_utente } = req.query;
	pool.query("SELECT * FROM listar_contagem_dashboard_por_utente($1)", [id_utente], (error, results) => {
		if (error) {
			res.status(400).json({
				status: "error",
				data: null,
				messages: [error.message]
			});
			return;
		}
		res.status(200).json({
			status: "success",
			data: results.rows[0],
			messages: ["Totais obtidos com sucesso"]
		});
	});
}

module.exports = {
	RequerimentoPorDistrito,
	RequerimentoPorConcelho,
	RequerimentoPorPeriodo,
	RequerimentoPorEstado,
	RequerimentoPorMesAnual,
	DashboardTotais,
	DashboardTotaisPorUtilizador,
	DashboardTotaisPorUtente
};
