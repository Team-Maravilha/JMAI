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

const RegistarAdministrador = (req, res) => {
    const { nome, email, palavra_passe, estado } = req.body;
    pool.query("SELECT inserir_utilizador($1, $2, $3, $4, $5)", [nome, email, palavra_passe, 0, estado], (error, results) => {
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
            messages: ["Administrador registado com sucesso!"],
        });
    });
}

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

const RegistarRececionista = (req, res) => {
    const { nome, email, palavra_passe, estado } = req.body;
    pool.query("SELECT inserir_utilizador($1, $2, $3, $4, $5)", [nome, email, palavra_passe, 2, estado], (error, results) => {
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
            messages: ["Rececionista registado com sucesso!"],
        });
    });
}

const InformacaoUtilizador = (req, res) => {
    const hashed_id = req.params.hashed_id;
    pool.query("SELECT * FROM listar_utilizadores($1)", [hashed_id], (error, results) => {
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
            data: results.rows[0],
            messages: ["Informação do utilizador obtida com sucesso!"],
        });
    });
}

const EditarUtilizador = (req, res) => {
    const hashed_id = req.params.hashed_id;
    const { nome, email, cargo, estado } = req.body;
    pool.query("SELECT editar_utilizador($1, $2, $3, $4, $5)", [hashed_id, nome, email, cargo, estado], (error, results) => {
        if (error) {
            res.status(400).json({
                status: 'error',
                data: null,
                messages: [error.message]
            });
            return;
        }
        switch (parseInt(cargo)) {
            case 0:
                res.status(200).json({
                    status: 'success',
                    data: null,
                    messages: ["Administrador editado com sucesso!"],
                });
                break;
            case 1:
                res.status(200).json({
                    status: 'success',
                    data: null,
                    messages: ["Médico editado com sucesso!"],
                });
                break;
            case 2:
                res.status(200).json({
                    status: 'success',
                    data: null,
                    messages: ["Rececionista editado com sucesso!"],
                });
                break;
            default:
                res.status(200).json({
                    status: 'success',
                    data: null,
                    messages: ["Utilizador editado com sucesso!"],
                });
                break;
        }
    });
}

const DesativarUtilizador = (req, res) => {
    const hashed_id = req.params.hashed_id;
    const { cargo } = req.body;
    pool.query("SELECT inativar_utilizador($1)", [hashed_id], (error, results) => {
        if (error) {
            res.status(400).json({
                status: 'error',
                data: null,
                messages: [error.message]
            });
            return;
        }
        switch (parseInt(cargo)) {
            case 0:
                res.status(200).json({
                    status: 'success',
                    data: null,
                    messages: ["Administrador eliminado com sucesso!"],
                });
                break;
            case 1:
                res.status(200).json({
                    status: 'success',
                    data: null,
                    messages: ["Médico eliminado com sucesso!"],
                });
                break;
            case 2:
                res.status(200).json({
                    status: 'success',
                    data: null,
                    messages: ["Rececionista eliminado com sucesso!"],
                });
                break;
            default:
                res.status(200).json({
                    status: 'success',
                    data: null,
                    messages: ["Utilizador eliminado com sucesso!"],
                });
                break;
        }
    });
}

const AtivarUtilizador = (req, res) => {
    const hashed_id = req.params.hashed_id;
    const { cargo } = req.body;
    pool.query("SELECT ativar_utilizador($1)", [hashed_id], (error, results) => {
        if (error) {
            res.status(400).json({
                status: 'error',
                data: null,
                messages: [error.message]
            });
            return;
        }
        switch (parseInt(cargo)) {
            case 0:
                res.status(200).json({
                    status: 'success',
                    data: null,
                    messages: ["Administrador ativado com sucesso!"],
                });
                break;
            case 1:
                res.status(200).json({
                    status: 'success',
                    data: null,
                    messages: ["Médico ativado com sucesso!"],
                });
                break;
            case 2:
                res.status(200).json({
                    status: 'success',
                    data: null,
                    messages: ["Rececionista ativado com sucesso!"],
                });
                break;
            default:
                res.status(200).json({
                    status: 'success',
                    data: null,
                    messages: ["Utilizador ativado com sucesso!"],
                });
                break;
        }
    });
}

module.exports = {
    ListarUtilizadoresDataTable,
    RegistarAdministrador,
    RegistarMedico,
    RegistarRececionista,
    InformacaoUtilizador,
    EditarUtilizador,
    DesativarUtilizador,
    AtivarUtilizador
    
};
