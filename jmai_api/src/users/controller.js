const pool = require("../../db");
// Definir as tags da Documentação
/**
 * @swagger
 * tags:
 *   name: Utilizadores
 *   description: Gestão de Utilizadores
 */

const ListarUtilizadoresDataTable = (req, res) => {
    const cargo = req.get("Cargo");
    pool.query("SELECT * FROM listar_utilizadores(NULL, NULL, $1)", [cargo], (error, results) => {
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
    });
};

module.exports = {
    ListarUtilizadoresDataTable,
};
