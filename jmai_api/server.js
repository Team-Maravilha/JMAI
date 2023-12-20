require("dotenv").config(); 

const express = require("express");
const cors = require("cors");
const swaggerJsDoc = require("swagger-jsdoc");
const swaggerUi = require("swagger-ui-express");

const usersRoutes = require("./src/users/routes");
const authRoutes = require("./src/auth/routes");

const app = express();
const port = 8888;
const swaggerOptions = {
  swaggerDefinition: {
    openapi: "3.0.0",
    info: {
      title: "SNS | JMAI",
        description: "Juntas Médicas para Avaliação de Incapacidade <p> Desenvolvido por: João Correia, Rui Cruz e Thays Souza",
      contact: {
        name: "João Correia | Rui Cruz | Thays Souza",
      },
      version: "1.0",
      servers: ["http://localhost:8888/"],
    },
  },
  apis: ["src/*/*.js"],
};

const swaggerDocs = swaggerJsDoc(swaggerOptions);
app.use("/api-doc", swaggerUi.serve, swaggerUi.setup(swaggerDocs));

app.use(cors());
app.use(express.json());

app.get("/", (req, res) => {
  res.send("Bem-Vindo(a) à API do SNS | JMAI !");
});

app.use("/api/users", usersRoutes);
app.use("/api/auth", authRoutes);

app.listen(port, () => console.log(`Servidor ativo na porta: ${port}`));
