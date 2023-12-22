const pool = require("../../db");
// Definir as tags da Documentação
/**
 * @swagger
 * tags:
 *   name: Requerimentos
 *   description: Gestão de Requerimentos
 */

const RegistarRequerimento = async (req, res) => {
    const { id_utente, tipo_documento, numero_documento, data_validade_documento, numero_contribuinte, data_nascimento, freguesia_naturalidade, morada, codigo_postal, freguesia_residencia, numero_telemovel, tipo_requerimento, primeira_submissao, data_submissao_anterior, numero_telefone, email_preferencial, data_emissao_documento, local_emissao_documento, documentos } = req.body;

    pool.query("SELECT * FROM inserir_requerimento($1, $2, $3, $4, $5, $6, $7, $8, $9, $10, $11, $12, $13, $14, $15, $16, $17, $18, $19)", [id_utente, tipo_documento, numero_documento, data_validade_documento, numero_contribuinte, data_nascimento, freguesia_naturalidade, morada, codigo_postal, freguesia_residencia, numero_telemovel, tipo_requerimento, primeira_submissao, data_submissao_anterior, numero_telefone, email_preferencial, data_emissao_documento, local_emissao_documento, documentos], (error, results) => {
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
            messages: ["O seu Requerimento foi registado com Sucesso!"],
        });
    })
};

module.exports = {
  RegistarRequerimento,
};
