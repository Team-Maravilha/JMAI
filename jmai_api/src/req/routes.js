const { Router } = require("express");
const controller = require("./controller");
const authMiddleware = require("../../authMiddleware");

const router = Router();

router.post("/registar", authMiddleware, controller.RegistarRequerimento);

router.post("/listar", authMiddleware, controller.ListarRequerimentosDataTable);

router.get("/ver/:hashed_id", authMiddleware, controller.VerInformacaoRequerimentoByHashedID)

router.post("/acessos/registar", authMiddleware, controller.RegistarAcesso);

router.get("/acessos/listar/", authMiddleware, controller.ListarAcessosRequerimento);

router.post("/validar", authMiddleware, controller.ValidarRequerimento);

router.post("/invalidar", authMiddleware, controller.InvalidarRequerimento);

router.post("/avaliar", authMiddleware, controller.AvaliarRequerimento);


module.exports = router;