const jwt = require("jsonwebtoken");
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
 */
const user = {
    id: "1",
    username: "João Correia",
    cc_num: "12345678",
};

const Login = ("/login",
    (req, res) => {
        const token = jwt.sign(user, process.env.SECRET, { expiresIn: "1w" });

        res.json({
            auth: true,
            token: token,
        });
    });

const Logout =
    ("/logout",
        (req, res) => {
            const token = req.headers.authorization;
        });

module.exports = {
    Login,
    Logout
};
