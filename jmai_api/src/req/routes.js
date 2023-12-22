const { Router } = require("express");
const controller = require("./controller");
const authMiddleware = require("../../authMiddleware");

const router = Router();

router.post("/registar", authMiddleware, controller.RegistarRequerimento);

router.post("/listar", authMiddleware, controller.ListarRequerimentosDataTable);

router.get("/informacao/:hashed_id", authMiddleware, controller.InformacaoRequerimento);

router.post("/acessos/registar", authMiddleware, controller.RegistarAcesso);

router.get("/acessos/listar/", authMiddleware, controller.ListarAcessosRequerimento);

module.exports = router;