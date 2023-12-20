const { Router } = require('express');
const controller = require('./controller');
const authMiddleware = require('../../authMiddleware');

const router = Router();

router.get('/user', authMiddleware, controller.NameUser);

module.exports = router;