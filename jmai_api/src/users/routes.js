const { Router } = require('express');
const controller = require('./controller');
const authMiddleware = require('../../authMiddleware');

const router = Router();

router.get('/listar/tabela', authMiddleware, controller.ListarUtilizadoresDataTable);
router.post('/registar/medico', authMiddleware, controller.RegistarMedico);

module.exports = router;