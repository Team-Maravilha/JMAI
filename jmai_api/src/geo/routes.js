const { Router } = require("express");
const controller = require("./controller");
const authMiddleware = require('../../authMiddleware');

const router = Router();

router.get("/paises/lista", authMiddleware, controller.ListarPaises);

router.get("/paises/:id_pais", authMiddleware, controller.ListarInformacaoPais);

router.get("/paises/:id_pais/distritos/lista", authMiddleware, controller.ListarDistritosPais);

router.get("/paises/:id_pais/distritos/:id_distrito", authMiddleware, controller.ListarInformacaoDistrito);

router.get("/distritos/:id_distrito/concelhos/lista", authMiddleware, controller.ListarConcelhosDistrito);

router.get("/distritos/:id_distrito/concelhos/:id_concelho", authMiddleware, controller.ListarInformacaoConcelho);

router.get("/concelhos/:id_concelho/freguesias/lista", authMiddleware, controller.ListarFreguesiasConcelho);

router.get("/concelhos/:id_concelho/freguesias/:id_freguesia", authMiddleware, controller.ListarInformacaoFreguesia);

module.exports = router;