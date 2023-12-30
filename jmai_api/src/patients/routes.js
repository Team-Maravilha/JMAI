const { Router } = require("express");
const controller = require("./controller");

const router = Router();

router.post("/registar", controller.RegistarUtente);
router.get("/listar/tabela", controller.ListarUtentesDataTable);
router.get("/ver/:hashed_id", controller.VerInformacaoUtenteByHashedID)

module.exports = router;