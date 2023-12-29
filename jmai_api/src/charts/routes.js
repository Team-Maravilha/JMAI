const { Router } = require("express");
const controller = require("./controller");
const authMiddleware = require("../../authMiddleware");

const router = Router();

router.get("/requerimentos_por_distrito", authMiddleware, controller.RequerimentoPorDistrito);

module.exports = router;