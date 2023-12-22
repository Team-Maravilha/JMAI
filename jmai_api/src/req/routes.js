const { Router } = require("express");
const controller = require("./controller");
const authMiddleware = require("../../authMiddleware");

const router = Router();

router.post("/registar", authMiddleware, controller.RegistarRequerimento);

router.post("/listar", authMiddleware, controller.ListarRequerimentosDataTable);

module.exports = router;