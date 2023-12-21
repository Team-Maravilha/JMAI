const { Router } = require("express");
const controller = require("./controller");

const router = Router();

router.post("/login-utilizador", controller.LoginUtilizador);

router.post("/login-utente", controller.LoginUtente);

module.exports = router;