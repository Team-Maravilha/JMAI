const pool = require("../../db");
// Definir as tags da Documentação
/**
 * @swagger
 * tags:
 *   name: Requerimentos
 *   description: Gestão de Requerimentos
 */

const RegistarRequerimento = async (req, res) => {
  const {
    id_utente,
    tipo_documento,
    numero_documento,
    data_validade_documento,
    numero_contribuinte,
    data_nascimento,
    freguesia_naturalidade,
    morada,
    codigo_postal,
    freguesia_residencia,
    numero_telemovel,
    tipo_requerimento,
    primeira_submissao,
    data_submissao_anterior,
    numero_telefone,
    email_preferencial,
    data_emissao_documento,
    local_emissao_documento,
    documentos,
  } = req.body;

  pool.query(
    "SELECT * FROM inserir_requerimento($1, $2, $3, $4, $5, $6, $7, $8, $9, $10, $11, $12, $13, $14, $15, $16, $17, $18, $19)",
    [
      id_utente,
      tipo_documento,
      numero_documento,
      data_validade_documento,
      numero_contribuinte,
      data_nascimento,
      freguesia_naturalidade,
      morada,
      codigo_postal,
      freguesia_residencia,
      numero_telemovel,
      tipo_requerimento,
      primeira_submissao,
      data_submissao_anterior,
      numero_telefone,
      email_preferencial,
      data_emissao_documento,
      local_emissao_documento,
      documentos,
    ],
    (error, results) => {
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
    }
  );
};

const ListarRequerimentosDataTable = (req, res) => {
  const { hashed_id, hashed_id_utente, data_criacao, estado, tipo_requerimento } = req.body;

  pool.query("SELECT * FROM listar_requerimentos($1, $2, $3, $4, $5)", [hashed_id, hashed_id_utente, data_criacao, estado, tipo_requerimento], (error, results) => {
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

const InformacaoRequerimento = (req, res) => {
  const { hashed_id } = req.params;

  pool.query("SELECT * FROM listar_requerimentos($1)", [hashed_id], (error, results) => {
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
      messages: [],
    });
  });
}

const RegistarAcesso = (req, res) => {
  const { hashed_id_requerimento, hashed_id_utilizador } = req.body;

  pool.query("SELECT * FROM inserir_log_acesso_requerimento($1, $2)", [hashed_id_requerimento, hashed_id_utilizador], (error, results) => {
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
      messages: ["Acesso registado com Sucesso!"],
    });
  });
}

const ListarAcessosRequerimento = (req, res) => {
  const { hashed_id_requerimento, cargo_utilizador } = req.query;

  pool.query("SELECT * FROM listar_log_acesso_requerimento($1, $2)", [hashed_id_requerimento, cargo_utilizador], (error, results) => {
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
}


module.exports = {
  RegistarRequerimento,
  ListarRequerimentosDataTable,
  InformacaoRequerimento,
  RegistarAcesso,
  ListarAcessosRequerimento
};
