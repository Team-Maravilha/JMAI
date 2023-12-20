const jwt = require("jsonwebtoken");

module.exports = (req, res, next) => {
  const token = req.headers.authorization;

  if (!token) {
    return res
      .status(401)
      .json({ auth: false, message: "Token não encontrado." });
  }
  
  jwt.verify(token, process.env.SECRET, function (err, user) {
    if (err) {
      return res
        .status(500)
        .json({ auth: false, message: "Falha na autenticação do Token." });
    }
    req.user = user;
    next();
  });
};