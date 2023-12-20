// Definir as tags da Documentação
/**
 * @swagger
 * tags:
 *   name: Utilizadores
 *   description: Gestão de Utilizadores
 */
/**
 * @swagger
 * /api/users/user:
 *  get:
 *      tags: [Utilizadores]
 *      summary: Ver Nome do Utilizador
 *      description: Retorna o Nome do Utilizador
 *      responses:
 *          '200':
 *              description: Sucesso
 */

const NameUser = ("/user", (req, res) => {
    res.send("João Correia");
  });

module.exports = {
  NameUser,
};
