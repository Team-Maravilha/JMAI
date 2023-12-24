const { Router } = require("express");
const controller = require("./controller");

const router = Router();

router.post("/registar", controller.RegistarUtente);
router.get("/ver/:hashed_id", controller.VerInformacaoUtenteByHashedID)

module.exports = router;