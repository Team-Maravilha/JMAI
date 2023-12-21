const { Router } = require('express');
const controller = require('./controller');
const authMiddleware = require('../../authMiddleware');

const router = Router();

router.get('/listar/tabela', authMiddleware, controller.ListarUtilizadoresDataTable);
router.get('/registar/administrador', authMiddleware, controller.RegistarAdministrador);
router.post('/registar/medico', authMiddleware, controller.RegistarMedico);
router.post('/registar/rececionista', authMiddleware, controller.RegistarRececionista);


module.exports = router;