const { Router } = require("express");
const controller = require("./controller");

const router = Router();

router.post("/login-utilizador", controller.LoginUtilizador);

router.post("/login-utente", controller.LoginUtente);

router.post("/utente/recuperar-palavra-passe", controller.RecuperarPalavraPasseUtente);

router.get("/utente/recuperar-palavra-passe/verificar/:token", controller.VerificarTokenRecuperacaoPalavraPasseUtente);

router.put("/utente/recuperar-palavra-passe/validar", controller.ValidarTokenRecuperacaoPalavraPasseUtente);

router.put("/utente/recuperar-palavra-passe/alterar", controller.AlterarPalavraPasseUtente);

module.exports = router;