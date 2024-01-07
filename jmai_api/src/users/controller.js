const pool = require("../../db");
// Definir as tags da Documentação
/**
 * @swagger
 * tags:
 *   name: Utilizadores
 *   description: Gestão de Utilizadores
 */


/**
 * @swagger
 * /api/utilizadores/listar/tabela:
 *  get:
 *      tags: [Utilizadores]
 *      summary: Lista de Utilizadores DataTable
 *      description: Obter Lista de Utilizadores para a DataTable
 *      responses:
 *          '200':
 *              description: Sucesso
 *          '400':
 *              description: Erro
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

/**
 * @swagger
 * /api/utilizadores/listar:
 *  get:
 *      tags: [Utilizadores]
 *      summary: Lista de Utilizadores
 *      description: Obter Lista de Utilizadores
 *      responses:
 *          '200':
 *              description: Sucesso
 *          '400':
 *              description: Erro
 */
const ListarUtilizadores = (req, res) => {
    const { cargo, estado } = req.query;
    pool.query("SELECT * FROM listar_utilizadores(NULL, NULL, $1, $2)", [cargo, estado], (error, results) => {
        if (error) {
            res.status(400).json({
                status: 'error',
                data: null,
                messages: [error.message],
            });
            return;
        }
        res.status(200).json({
            status: 'success',
            data: results.rows,
            messages: [],
        });
    });
};

/**
 * @swagger
 * /api/utilizadores/registar/administrador:
 *  post:
 *      tags: [Utilizadores]
 *      summary: Registar Novo Administrador
 *      description: Permite inserir um novo Administrador
 *      responses:
 *          '201':
 *              description: Sucesso
 *          '400':
 *              description: Erro
 */
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

/**
 * @swagger
 * /api/utilizadores/registar/medico:
 *  post:
 *      tags: [Utilizadores]
 *      summary: Registar Novo Médico
 *      description: Permite inserir um novo Médico
 *      responses:
 *          '201':
 *              description: Sucesso
 *          '400':
 *              description: Erro
 */
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

/**
 * @swagger
 * /api/utilizadores/registar/rececionista:
 *  post:
 *      tags: [Utilizadores]
 *      summary: Registar Nova Rececionista
 *      description: Permite inserir uma nova Rececionista
 *      responses:
 *          '201':
 *              description: Sucesso
 *          '400':
 *              description: Erro
 */
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
            messages: ["Rececionista registada com sucesso!"],
        });
    });
}

/**
 * @swagger
 * /api/utilizadores/informacao/{hashed_id}:
 *  get:
 *      tags: [Utilizadores]
 *      summary: Obter Informação do Utilizador por Id
 *      description: Obter Informação Completa do Utilizador por Id
 *      responses:
 *          '200':
 *              description: Sucesso
 *          '400':
 *              description: Erro
 */
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

/**
 * @swagger
 * /api/utilizadores/editar/{hashed_id}:
 *  put:
 *      tags: [Utilizadores]
 *      summary: Editar Informação do Utilizador por Id
 *      description: Editar Informação Completa do Utilizador por Id
 *      responses:
 *          '200':
 *              description: Sucesso
 *          '400':
 *              description: Erro
 */
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
                    messages: ["Rececionista editada com sucesso!"],
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

/**
 * @swagger
 * /api/utilizadores/desativar/{hashed_id}:
 *  put:
 *      tags: [Utilizadores]
 *      summary: Desativar Utilizador
 *      description: Desativar um Utilizador
 *      responses:
 *          '200':
 *              description: Sucesso
 *          '400':
 *              description: Erro
 */
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
                    messages: ["Administrador desativado com sucesso!"],
                });
                break;
            case 1:
                res.status(200).json({
                    status: 'success',
                    data: null,
                    messages: ["Médico desativado com sucesso!"],
                });
                break;
            case 2:
                res.status(200).json({
                    status: 'success',
                    data: null,
                    messages: ["Rececionista desativada com sucesso!"],
                });
                break;
            default:
                res.status(200).json({
                    status: 'success',
                    data: null,
                    messages: ["Utilizador desativado com sucesso!"],
                });
                break;
        }
    });
}

/**
 * @swagger
 * /api/utilizadores/ativar/{hashed_id}:
 *  put:
 *      tags: [Utilizadores]
 *      summary: Ativar Utilizador
 *      description: Ativar uma Utilizador
 *      responses:
 *          '200':
 *              description: Sucesso
 *          '400':
 *              description: Erro
 */
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
                    messages: ["Rececionista ativada com sucesso!"],
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
    ListarUtilizadores,
    RegistarAdministrador,
    RegistarMedico,
    RegistarRececionista,
    InformacaoUtilizador,
    EditarUtilizador,
    DesativarUtilizador,
    AtivarUtilizador
    
};
