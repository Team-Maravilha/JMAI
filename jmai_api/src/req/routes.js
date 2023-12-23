const { Router } = require("express");
const controller = require("./controller");
const authMiddleware = require("../../authMiddleware");

const router = Router();

router.post("/registar", authMiddleware, controller.RegistarRequerimento);

router.post("/listar", authMiddleware, controller.ListarRequerimentosDataTable);

router.get("/ver/:hashed_id", authMiddleware, controller.VerInformacaoRequerimentoByHashedID)

module.exports = router;