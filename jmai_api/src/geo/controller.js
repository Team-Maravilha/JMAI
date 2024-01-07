const pool = require("../../db");
// Definir as tags da Documentação
/**
 * @swagger
 * tags:
 *   name: GeoLocalização
 *   description: Gestão de GeoLocalização
 */


/**
 * @swagger
 * /api/geo/paises/lista:
 *  get:
 *      tags: [GeoLocalização]
 *      summary: Lista de Países
 *      description: Obter Lista de Países
 *      responses:
 *          '200':
 *              description: Sucesso
 *          '400':
 *              description: Erro
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


/**
 * @swagger
 * /api/geo/paises/{id_pais}:
 *  get:
 *      tags: [GeoLocalização]
 *      summary: Informação por País
 *      description: Obter Informação de um País
 *      responses:
 *          '200':
 *              description: Sucesso
 *          '400':
 *              description: Erro
 */
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

/**
 * @swagger
 * /api/geo/paises/{id_pais}/distritos/lista:
 *  get:
 *      tags: [GeoLocalização]
 *      summary: Lista de Distritos por País
 *      description: Obter Lista de Distritos por País
 *      responses:
 *          '200':
 *              description: Sucesso
 *          '400':
 *              description: Erro
 */
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

/**
 * @swagger
 * /api/geo/paises/{id_pais}/distritos/{id_distrito}:
 *  get:
 *      tags: [GeoLocalização]
 *      summary: Informação por Distrito
 *      description: Obter Informação de um Distrito
 *      responses:
 *          '200':
 *              description: Sucesso
 *          '400':
 *              description: Erro
 */
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

/**
 * @swagger
 * /api/geo/distritos/{id_distrito}/concelhos/lista:
 *  get:
 *      tags: [GeoLocalização]
 *      summary: Lista de Concelhos por Distrito
 *      description: Obter Lista de Concelhos por Distrito
 *      responses:
 *          '200':
 *              description: Sucesso
 *          '400':
 *              description: Erro
 */
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

/**
 * @swagger
 * /api/geo/distritos/{id_distrito}/concelhos/{id_concelho}:
 *  get:
 *      tags: [GeoLocalização]
 *      summary: Informação por Concelho
 *      description: Obter Informação de um Concelho
 *      responses:
 *          '200':
 *              description: Sucesso
 *          '400':
 *              description: Erro
 */
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

/**
 * @swagger
 * /api/geo/concelhos/{id_concelho}/freguesias/lista:
 *  get:
 *      tags: [GeoLocalização]
 *      summary: Lista de Freguesias por Concelho
 *      description: Obter Lista de Freguesias por Concelho
 *      responses:
 *          '200':
 *              description: Sucesso
 *          '400':
 *              description: Erro
 */
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

/**
 * @swagger
 * /api/geo/concelhos/{id_concelho}/freguesias/{id_freguesia}:
 *  get:
 *      tags: [GeoLocalização]
 *      summary: Informação por Freguesia
 *      description: Obter Informação de uma Freguesia
 *      responses:
 *          '200':
 *              description: Sucesso
 *          '400':
 *              description: Erro
 */
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
