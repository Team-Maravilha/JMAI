const { Router } = require("express");
const controller = require("./controller");

const router = Router();

router.post("/login", controller.Login);

router.delete("/logout", controller.Logout);

module.exports = router;