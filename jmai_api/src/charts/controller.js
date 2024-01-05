const pool = require("../../db");
// Definir as tags da Documentação
/**
 * @swagger
 * tags:
 *   name: Dados para Gráficos
 *   description: EndPoint para obter dados para os gráficos
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

module.exports = {
	RequerimentoPorDistrito,
	RequerimentoPorConcelho,
	RequerimentoPorPeriodo,
	RequerimentoPorEstado,
	RequerimentoPorMesAnual,
	DashboardTotais,
	DashboardTotaisPorUtilizador
};
