require("dotenv").config(); 

const express = require("express");
const cors = require("cors");
const swaggerJsDoc = require("swagger-jsdoc");
const swaggerUi = require("swagger-ui-express");

const usersRoutes = require("./src/users/routes");
const authRoutes = require("./src/auth/routes");
const patientsRoutes = require("./src/patients/routes");
const geoRoutes = require("./src/geo/routes");
const reqRoutes = require("./src/req/routes");
const medicalTeamRoutes = require("./src/medical_team/routes");
const chartsRoutes = require("./src/charts/routes");


const app = express();
const port = 8888;
const swaggerOptions = {
  swaggerDefinition: {
    openapi: "3.0.0",
    info: {
      title: "EIM | JMAI",
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
const DisableTryItOutPlugin = function() {
  return {
    statePlugins: {
      spec: {
        wrapSelectors: {
          allowTryItOutFor: () => () => false
        }
      }
    }
  }
}
const options = {
  swaggerOptions: {
      plugins: [
           DisableTryItOutPlugin
      ]
   }
};

app.use("/api-doc", swaggerUi.serve, swaggerUi.setup(swaggerDocs, options));

app.use(cors());
app.use(express.json());

app.get("/", (req, res) => {
  res.send("Bem-Vindo(a) à API do SNS | JMAI !");
});

app.use("/api/utilizadores", usersRoutes);
app.use("/api/autenticacao", authRoutes);
app.use("/api/utentes", patientsRoutes);
app.use("/api/geo", geoRoutes);
app.use("/api/requerimentos", reqRoutes);
app.use("/api/equipas_medicas", medicalTeamRoutes);
//ROUTE PARA EXPORTAR DADOS PARA GRAFICOS
app.use("/api/graficos", chartsRoutes);

app.listen(port, () => console.log(`Servidor ativo na porta: ${port}`));
