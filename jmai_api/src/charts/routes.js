const { Router } = require("express");
const controller = require("./controller");
const authMiddleware = require("../../authMiddleware");

const router = Router();

router.get("/requerimentos_por_distrito", authMiddleware, controller.RequerimentoPorDistrito);

router.get("/requerimentos_por_periodo", authMiddleware, controller.RequerimentoPorPeriodo);

router.get("/requerimentos_por_estado", authMiddleware, controller.RequerimentoPorEstado);

router.get("/requerimentos_por_mes_anual", authMiddleware, controller.RequerimentoPorMesAnual);

router.get("/dashboard_totais", authMiddleware, controller.DashboardTotais);

router.get("/dashboard_totais_por_utilizador", authMiddleware, controller.DashboardTotaisPorUtilizador);

module.exports = router;