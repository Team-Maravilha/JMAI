const pool = require("../../db");
// Definir as tags da Documentação
/**
 * @swagger
 * tags:
 *   name: Geolocalização
 *   description: Gestão de Geolocalização
 */

const ListarPaises = (req, res) => {
    const { id_pais, nome_pais } = req.query;
    pool.query("SELECT * FROM listar_paises($1, $2)", [id_pais, nome_pais], (error, results) => {
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
            messages: ["Lista de Países"],
        });
    });
};

const ListarInformacaoPais = (req, res) => {
    const { id_pais } = req.params;
    pool.query("SELECT * FROM listar_paises($1)", [id_pais], (error, results) => {
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
            messages: ["País encontrado com sucesso"],
        });
    });
}

const ListarDistritosPais = (req, res) => {
    const { id_pais } = req.params;
    pool.query("SELECT * FROM listar_distritos(NULL, NULL, $1)", [id_pais], (error, results) => {
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
            messages: ["Distritos do País encontrados com sucesso"],
        });
    });
}

const ListarInformacaoDistrito = (req, res) => {
    const { id_pais, id_distrito } = req.params;
    pool.query("SELECT * FROM listar_distritos($1, NULL, $2)", [id_distrito, id_pais], (error, results) => {
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
            messages: ["Distrito encontrado com sucesso"],
        });
    });
}

const ListarConcelhosDistrito = (req, res) => {
    const { id_distrito } = req.params;
    pool.query("SELECT * FROM listar_concelhos(NULL, NULL, $1)", [id_distrito], (error, results) => {
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
            messages: ["Concelhos do Distrito encontrados com sucesso"],
        });
    });
}

const ListarInformacaoConcelho = (req, res) => {
    const { id_distrito, id_concelho } = req.params;
    pool.query("SELECT * FROM listar_concelhos($1, NULL, $2)", [id_concelho, id_distrito], (error, results) => {
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
            messages: ["Concelho encontrado com sucesso"],
        });
    });
}

const ListarFreguesiasConcelho = (req, res) => {
    const { id_concelho } = req.params;
    pool.query("SELECT * FROM listar_freguesias(NULL, NULL, $1)", [id_concelho], (error, results) => {
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
            messages: ["Freguesias do Concelho encontradas com sucesso"],
        });
    });
}

const ListarInformacaoFreguesia = (req, res) => {
    const { id_concelho, id_freguesia } = req.params;
    pool.query("SELECT * FROM listar_freguesias($1, NULL, $2)", [id_freguesia, id_concelho], (error, results) => {
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
            messages: ["Freguesia encontrada com sucesso"],
        });
    });
}

module.exports = {
    ListarPaises,
    ListarInformacaoPais,
    ListarDistritosPais,
    ListarInformacaoDistrito,
    ListarConcelhosDistrito,
    ListarInformacaoConcelho,
    ListarFreguesiasConcelho,
    ListarInformacaoFreguesia
};
