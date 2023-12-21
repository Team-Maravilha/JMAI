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

const RegistarMedico = (req, res) => {
    const { nome, email, palavra_passe, estado } = req.body;
    pool.query("SELECT inserir_utilizador($1, $2, $3, $4, $5)", [nome, email, palavra_passe, 1, estado], (error, results) => {
        if (error) {
            res.status(400).json({
                status: 'error',
                data: null,
                messages: [error.message]
            });
            return;
        }
        res.status(200).json({
            status: 'success',
            data: {
                hashed_id: results.rows[0].inserir_utilizador
            },
            messages: ["Médico registado com sucesso!"],
        });
    });
}



module.exports = {
    ListarUtilizadoresDataTable,
    RegistarMedico
};
