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



module.exports = {
	RequerimentoPorDistrito,
};
