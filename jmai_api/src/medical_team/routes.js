const { Router } = require("express");
const controller = require("./controller");

const router = Router();

router.post("/registar", controller.RegistarEquipaMedica);

router.get("/listar", controller.ListarEquipasMedicas);

module.exports = router;