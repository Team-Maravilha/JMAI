const { Router } = require("express");
const controller = require("./controller");
const authMiddleware = require("../../authMiddleware");

const router = Router();

router.post("/registar", authMiddleware, controller.RegistarRequerimento);

router.post("/listar", authMiddleware, controller.ListarRequerimentosDataTable);

router.post("/ver_requerimentos", authMiddleware, controller.ListarRequerimentosUtente);

router.get("/ver/:hashed_id", authMiddleware, controller.VerInformacaoRequerimentoByHashedID)

router.post("/acessos/registar", authMiddleware, controller.RegistarAcesso);

router.get("/acessos/listar/", authMiddleware, controller.ListarAcessosRequerimento);

router.post("/validar", authMiddleware, controller.ValidarRequerimento);

router.post("/invalidar", authMiddleware, controller.InvalidarRequerimento);

router.post("/avaliar", authMiddleware, controller.AvaliarRequerimento);

router.get("/historico_estados/:hashed_id", authMiddleware, controller.HistoricoEstadosRequerimento);

router.put("/resposta_utente/aceitar/:hashed_id", authMiddleware, controller.AceitarRespostaUtente);

router.put("/resposta_utente/rejeitar/:hashed_id", authMiddleware, controller.RejeitarRespostaUtente);

router.get("/comunicacao_utente/:hashed_id", authMiddleware, controller.VerComunicacaoUtente);

router.post("/agendar_consulta", authMiddleware, controller.AgendarConsulta);




module.exports = router;