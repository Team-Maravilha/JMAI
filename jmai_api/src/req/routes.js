const { Router } = require("express");
const controller = require("./controller");
const authMiddleware = require("../../authMiddleware");

const router = Router();

router.post("/registar", authMiddleware, controller.RegistarRequerimento);

module.exports = router;