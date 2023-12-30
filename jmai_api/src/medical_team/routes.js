const { Router } = require("express");
const controller = require("./controller");

const router = Router();

router.post("/registar", controller.RegistarEquipaMedica);

router.put("/editar/:hashed_id", controller.EditarEquipaMedica);

router.get("/listar", controller.ListarEquipasMedicasDataTable);

router.get("/listar_equipas_medicas", controller.ListarEquipasMedicas);

router.get("/ver/:hashed_id", controller.VerEquipaMedica);

router.put("/desativar/:hashed_id", controller.RemoverEquipaMedica);

router.put("/ativar/:hashed_id", controller.AtivarEquipaMedica);

module.exports = router;