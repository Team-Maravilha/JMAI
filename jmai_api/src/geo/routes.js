const { Router } = require("express");
const controller = require("./controller");
const authMiddleware = require('../../authMiddleware');

const router = Router();

router.get("/paises/lista", authMiddleware, controller.ListarPaises);

router.get("/paises/:id_pais", authMiddleware, controller.ListarInformacaoPais);

router.get("/paises/:id_pais/distritos/lista", authMiddleware, controller.ListarDistritosPais);

router.get("/paises/:id_pais/distritos/:id_distrito", authMiddleware, controller.ListarInformacaoDistrito);

module.exports = router;