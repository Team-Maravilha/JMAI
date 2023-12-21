const { Router } = require("express");
const controller = require("./controller");

const router = Router();

router.post("/login-utilizador", controller.LoginUtilizador);

module.exports = router;