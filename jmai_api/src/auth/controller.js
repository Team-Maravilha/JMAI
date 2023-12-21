const jwt = require("jsonwebtoken");
const pool = require("../../db");
// Definir as tags da Documentação
/**
 * @swagger
 * tags:
 *   name: Autenticação
 *   description: Gestão de Autenticações
 */
/**
 * @swagger
 * /api/auth/login:
 *  get:
 *      tags: [Autenticação]
 *      summary: Verifica o Login
 *      description: Permite o Login no Software ou Recusa
 *      responses:
 *          '200':
 *              description: Sucesso
 *          '400':
 *              description: Erro
 */

const LoginUtilizador = ((req, res) => {
    const { email, palavra_passe } = req.body;
    const user = req.body;

    pool.query("SELECT * FROM autenticar_utilizador($1, $2)", [email, palavra_passe], (error, results) => {
        if (error) {
            res.status(400).json({
                status: "error",
                data: null,
                messages: [error.message],
            });
            return;
        }
        const token = jwt.sign(user, process.env.SECRET, { expiresIn: "1w" });
        results.rows[0].token = token;
        res.status(201).json({
            status: "success",
            data: results.rows[0],
            messages: ["Credenciais Válidas!"],
        });
    })
});

const LoginUtente = (req, res) => {
    const { email, palavra_passe } = req.body;
    const user = req.body;

    pool.query("SELECT * FROM autenticar_utente($1, $2)", [email, palavra_passe], (error, results) => {
        if (error) {
            res.status(400).json({
                status: "error",
                data: null,
                messages: [error.message],
            });
            return;
        }
        const token = jwt.sign(user, process.env.SECRET, { expiresIn: "1w" });
        results.rows[0].token = token;
        res.status(201).json({
            status: "success",
            data: results.rows[0],
            messages: ["Credenciais Válidas!"],
        });
    })
}



module.exports = {
    LoginUtilizador,
    LoginUtente
};
