const pool = require("../../db");
const axios = require('axios').default;
// Definir as tags da Documentação
/**
 * @swagger
 * tags:
 *   name: Utentes
 *   description: Gestão de Utentes
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

module.exports = {
    RegistarUtente,
};
