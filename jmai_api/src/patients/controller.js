const pool = require("../../db");
const axios = require('axios').default;
// Definir as tags da Documentação
/**
 * @swagger
 * tags:
 *   name: Utentes
 *   description: Gestão de Utentes
 */

/**
 * @swagger
 * /api/utentes/registar:
 *  post:
 *      tags: [Utentes]
 *      summary: Registar Novo Utente (+RNU)
 *      description: Permite inserir um novo Utente com Ligação ao RNU
 *      responses:
 *          '201':
 *              description: Sucesso
 *          '400':
 *              description: Erro
 */
const RegistarUtente = async (req, res) => {
    const { nome, numero_utente, genero, email, palavra_passe } = req.body;

    try {
        const UtenteInfo = await axios.get('http://localhost:4000/api/patients/num_utente/' + numero_utente);
        //CHECK CONNECTION ERROR
        if (UtenteInfo.error) {
            res.status(400).json({
                status: "error",
                data: null,
                messages: ["Erro ao Validar Número do Utente no Registo Nacional de Utentes"],
            });
        }
        const id_utente_rnu = UtenteInfo.data[0].id_utente;

        pool.query("SELECT * FROM inserir_utente($1, $2, $3, $4, $5, $6)", [nome, id_utente_rnu, email, palavra_passe, genero, numero_utente], (error, results) => {
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
                messages: ["Registo efetuado com Sucesso!"],
            });
        })
    } catch {
        res.status(400).json({
            status: "error",
            data: null,
            messages: ["Erro ao Validar Número do Utente no Registo Nacional de Utentes"],
        });
    }
};

/**
 * @swagger
 * /api/utentes/listar/tabela:
 *  get:
 *      tags: [Utentes]
 *      summary: Lista de Utentes DataTable
 *      description: Obter Lista de Utentes para a DataTable
 *      responses:
 *          '200':
 *              description: Sucesso
 *          '400':
 *              description: Erro
 */
const ListarUtentesDataTable = async (req, res) => {
    pool.query(
        "SELECT * FROM listar_utentes()",
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
 * /api/utentes/ver/{hashed_id}:
 *  get:
 *      tags: [Utentes]
 *      summary: Ver Informação do Utente por Id
 *      description: Ver Informação Total do Utente por Id
 *      responses:
 *          '200':
 *              description: Sucesso
 *          '400':
 *              description: Erro
 */
const VerInformacaoUtenteByHashedID = (req, res) => {
    const hashed_id = req.params.hashed_id;
    pool.query("SELECT * FROM listar_utentes($1)", [hashed_id], (error, results) => {
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
            messages: ["Informação do Utente"],
        });
    })
}

module.exports = {
    RegistarUtente,
    ListarUtentesDataTable,
    VerInformacaoUtenteByHashedID
};
