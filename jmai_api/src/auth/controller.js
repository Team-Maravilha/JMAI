const jwt = require("jsonwebtoken");
const pool = require("../../db");
const SendEmail = require("../send_email/send_email");
// Definir as tags da Documentação
/**
 * @swagger
 * tags:
 *   name: Autenticação
 *   description: Gestão de Autenticações
 */
/**
 * @swagger
 * /api/auth/login:
 *  get:
 *      tags: [Autenticação]
 *      summary: Verifica o Login
 *      description: Permite o Login no Software ou Recusa
 *      responses:
 *          '200':
 *              description: Sucesso
 *          '400':
 *              description: Erro
 */

const LoginUtilizador = (req, res) => {
	const { email, palavra_passe } = req.body;
	const user = req.body;

	pool.query(
		"SELECT * FROM autenticar_utilizador($1, $2)",
		[email, palavra_passe],
		(error, results) => {
			if (error) {
				res.status(400).json({
					status: "error",
					data: null,
					messages: [error.message],
				});
				return;
			}
			const token = jwt.sign(user, process.env.SECRET, {
				expiresIn: "1w",
			});
			results.rows[0].token = token;
			res.status(201).json({
				status: "success",
				data: results.rows[0],
				messages: ["Credenciais Válidas!"],
			});
		}
	);
};

const LoginUtente = (req, res) => {
	const { email, palavra_passe } = req.body;
	const user = req.body;

	pool.query(
		"SELECT * FROM autenticar_utente($1, $2)",
		[email, palavra_passe],
		(error, results) => {
			if (error) {
				res.status(400).json({
					status: "error",
					data: null,
					messages: [error.message],
				});
				return;
			}
			const token = jwt.sign(user, process.env.SECRET, {
				expiresIn: "1w",
			});
			results.rows[0].token = token;
			res.status(201).json({
				status: "success",
				data: results.rows[0],
				messages: ["Credenciais Válidas!"],
			});
		}
	);
};

const RecuperarPalavraPasseUtente = (req, res) => {
	console.log(req.body);
	const { email } = req.body;
	console.log(email);
	pool.query(
		"SELECT * FROM registar_pedido_recuperacao_palavra_passe($1)",
		[email],
		(error, results) => {
			if (error) {
				res.status(400).json({
					status: "error",
					data: null,
					messages: [error.message],
				});
				return;
			}

            const nome = results.rows[0].nome;
            const token = results.rows[0].token;
            const codigo_recuperacao = results.rows[0].codigo_recuperacao;
            const data_expiracao = results.rows[0].data_expiracao;
            const corpo_email = `
                <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Inter:300,400,500,600,700">
                <link href="https://preview.keenthemes.com/metronic8/demo1/assets/plugins/global/plugins.bundle.css" rel="stylesheet" type="text/css">
                <link href="https://preview.keenthemes.com/metronic8/demo1/assets/css/style.bundle.css" rel="stylesheet" type="text/css">
                <style>
                    html,
                    body {
                        padding: 0;
                        margin: 0;
                        font-family: Inter, Helvetica, "sans-serif";
                    }

                    a {
                        color: #009ef7;
                        text-decoration: none;
                    }

                    a:hover {
                        color: #009ef7;
                    }
                </style>
                <div id="#kt_app_body_content" style="background-color:#D5D9E2; font-family:Arial,Helvetica,sans-serif; line-height: 1.5; min-height: 100%; font-weight: normal; font-size: 15px; color: #2F3044; margin:0; padding:0; padding-top: 40px; padding-bottom: 40px; width:100%;">
                    <div style="background-color:#ffffff; padding: 45px 0 34px 0; border-radius: 24px; margin:auto; max-width: 600px;">
                        <table align="center" border="0" cellpadding="0" cellspacing="0" width="100%" height="auto" style="border-collapse:collapse">
                            <tbody>
                                <tr>
                                    <td align="center" valign="center" style="text-align:center; padding-bottom: 10px">

                                        <!--begin:Email content-->
                                        <div style="text-align:center; margin:0 15px 34px 15px">
                                            <!--begin:Logo-->
                                            <div style="margin-bottom: 10px">
                                                <a href="" rel="noopener" target="_blank">
                                                    <img alt="Logo" src="https://firebasestorage.googleapis.com/v0/b/jmai-docs.appspot.com/o/imagens_templates_email%2Flogo.png?alt=media&token=108e658e-4147-49ad-a362-a5f4fbc6caec" style="height: 35px">
                                                </a>
                                            </div>
                                            <!--end:Logo-->

                                            <!--begin:Media-->
                                            <div style="margin-bottom: 15px">
                                                <img alt="Logo" src="https://firebasestorage.googleapis.com/v0/b/jmai-docs.appspot.com/o/imagens_templates_email%2F17.png?alt=media&token=054a999a-71e6-41a0-94bd-a55d28f5447e" width="150px">
                                            </div>
                                            <!--end:Media-->

                                            <!--begin:Text-->
                                            <div style="font-size: 14px; font-weight: 500; margin-bottom: 27px; font-family:Arial,Helvetica,sans-serif;">
                                                <p style="margin-bottom:9px; color:#181C32; font-size: 22px; font-weight:700">Pedido de Recuperação de Palavra-Passe</p>
                                                <p style="margin-bottom:2px; color:#7E8299">Olá, <span style="color:#181C32; font-weight:700">${nome}</span></p>
                                                <p style="margin-bottom:2px; color:#7E8299">Recebemos um pedido de recuperação de palavra-passe para a sua conta.</p>
                                            </div>
                                            <!--end:Text-->

                                            <!-- CODE -->
                                            <div style="margin-bottom: 15px">
                                                <p style="font-size: 14px; font-weight: 500; font-family:Arial,Helvetica,sans-serif;margin-bottom:2px; color:#7E8299">Código de Recuperação:</p>
                                                <p style="font-family:Arial,Helvetica,sans-serif;margin-bottom: 25px;color:#181C32;font-weight:700;margin-top: 20px;font-size: 20px;">${codigo_recuperacao}</p>
                                            </div>

                                            <!--begin:Action-->
                                            <a href="http://jmai.localhost/pages/auth/recover-password?token=${token}" target="_blank" style="background-color:#49beb7; border-radius:6px;display:inline-block; padding:11px 19px; color: #FFFFFF; font-size: 14px; font-weight:500;">
                                                Recuperar Palavra-Passe
                                            </a>
                                            <!--begin:Action-->
                                        </div>
                                        <!--end:Email content-->
                                    </td>
                                </tr>

                                <!--begin:Footer-->
                                <tr>
                                    <td align="center" valign="center" style="text-align:center; padding-bottom: 10px">
                                        <div style="text-align:center; margin:0 15px 34px 15px">
                                            <div style="font-size: 14px; font-weight: 500; margin-bottom: 27px; font-family:Arial,Helvetica,sans-serif;">
                                                <p style="margin-bottom:2px; color:#7E8299">Se não solicitou uma recuperação de palavra-passe, pode ignorar este email.</p>
                                                <p style="margin-bottom:2px; color:#7E8299">Se tiver alguma dúvida, entre em contacto connosco.</p>
                                                <p style="margin-bottom:2px; color:#7E8299">O pedido de recuperação de palavra-passe expira em: ${data_expiracao}</p>
                                            </div>
                                        </div>
                                    </td>
                                </tr>

                                <tr>
                                    <td align="center" valign="center" style="text-align:center">
                                        <a href="#"><img alt="Logo" src="https://firebasestorage.googleapis.com/v0/b/jmai-docs.appspot.com/o/imagens_templates_email%2Frodape.png?alt=media&token=c3a94df4-e26d-4ad7-9f7b-96ae03f0e542" height="50px"></a>
                                    </td>
                                </tr>

                            </tbody>
                        </table>
                    </div>
                </div>
            `;

            SendEmail(email, "Recuperação de Palavra-Passe", "", corpo_email);

			res.status(201).json({
				status: "success",
				data: {
					token: results.rows[0].token,
				},
				messages: ["Email enviado com sucesso!"],
			});
		}
	);
};

const VerificarTokenRecuperacaoPalavraPasseUtente = (req, res) => {
	const { token } = req.params;

	pool.query(
		"SELECT * FROM verificar_pedido_recuperacao_palavra_passe($1)",
		[token],
		(error, results) => {
			if (error) {
				res.status(400).json({
					status: "error",
					data: null,
					messages: [error.message],
				});
				return;
			}
            console.log(results.rows);
			res.status(201).json({
				status: `${results.rows[0].verificar_pedido_recuperacao_palavra_passe === true ? "success" : "warning"}`,
				data: {
					token: token,
				},
				messages: [`${results.rows[0].verificar_pedido_recuperacao_palavra_passe === true ? "Token Válido!" : "Insira o Código de Verificação!"}`],
			});
		}
	);
};

const ValidarTokenRecuperacaoPalavraPasseUtente = (req, res) => {
	const { token, codigo_verificacao } = req.body;

	pool.query(
		"SELECT * FROM validar_pedido_recuperacao_palavra_passe($1, $2)",
		[token, codigo_verificacao],
		(error, results) => {
			if (error) {
				res.status(400).json({
					status: "error",
					data: null,
					messages: [error.message],
				});
				return;
			}

			res.status(201).json({
				status: "success",
				data: {
					token: token,
				},
				messages: ["Código de Verificação Válido!"],
			});
		}
	);
};

const AlterarPalavraPasseUtente = (req, res) => {
	const { token, palavra_passe } = req.body;

	pool.query(
		"SELECT * FROM alterar_palavra_passe($1, $2)",
		[token, palavra_passe],
		(error, results) => {
			if (error) {
				res.status(400).json({
					status: "error",
					data: null,
					messages: [error.message],
				});
				return;
			}

			//Send Email a Informar que a Palavra-Passe foi Alterada
            const nome = results.rows[0].nome;
            const email = results.rows[0].email;
            const corpo_email = `
                <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Inter:300,400,500,600,700">
                <link href="https://preview.keenthemes.com/metronic8/demo1/assets/plugins/global/plugins.bundle.css" rel="stylesheet" type="text/css">
                <link href="https://preview.keenthemes.com/metronic8/demo1/assets/css/style.bundle.css" rel="stylesheet" type="text/css">
                <style>
                    html,
                    body {
                        padding: 0;
                        margin: 0;
                        font-family: Inter, Helvetica, "sans-serif";
                    }

                    a {
                        color: #009ef7;
                        text-decoration: none;
                    }

                    a:hover {
                        color: #009ef7;
                    }
                </style>
                <div id="#kt_app_body_content" style="background-color:#D5D9E2; font-family:Arial,Helvetica,sans-serif; line-height: 1.5; min-height: 100%; font-weight: normal; font-size: 15px; color: #2F3044; margin:0; padding:0; padding-top: 40px; padding-bottom: 40px; width:100%;">
                    <div style="background-color:#ffffff; padding: 45px 0 34px 0; border-radius: 24px; margin:auto; max-width: 600px;">
                        <table align="center" border="0" cellpadding="0" cellspacing="0" width="100%" height="auto" style="border-collapse:collapse">
                            <tbody>
                                <tr>
                                    <td align="center" valign="center" style="text-align:center; padding-bottom: 10px">

                                        <!--begin:Email content-->
                                        <div style="text-align:center; margin:0 15px 34px 15px">
                                            <!--begin:Logo-->
                                            <div style="margin-bottom: 10px">
                                                <a href="" rel="noopener" target="_blank">
                                                    <img alt="Logo" src="https://firebasestorage.googleapis.com/v0/b/jmai-docs.appspot.com/o/imagens_templates_email%2Flogo.png?alt=media&token=108e658e-4147-49ad-a362-a5f4fbc6caec" style="height: 35px">
                                                </a>
                                            </div>
                                            <!--end:Logo-->

                                            <!--begin:Media-->
                                            <div style="margin-bottom: 15px">
                                                <img alt="Logo" src="https://firebasestorage.googleapis.com/v0/b/jmai-docs.appspot.com/o/imagens_templates_email%2F17.png?alt=media&token=054a999a-71e6-41a0-94bd-a55d28f5447e" width="150px">
                                            </div>
                                            <!--end:Media-->

                                            <!--begin:Text-->
                                            <div style="font-size: 14px; font-weight: 500; margin-bottom: 27px; font-family:Arial,Helvetica,sans-serif;">
                                                <p style="margin-bottom:9px; color:#181C32; font-size: 22px; font-weight:700">Palavra-Passe Alterada</p>
                                                <p style="margin-bottom:2px; color:#7E8299">Olá, <span style="color:#181C32; font-weight:700">${nome}</span></p>
                                                <p style="margin-bottom:2px; color:#7E8299">A sua palavra-passe foi alterada com sucesso.</p>
                                            </div>
                                            <!--end:Text-->

                                        </div>
                                        <!--end:Email content-->
                                    </td>
                                </tr>

                                <!--begin:Footer-->
                                <tr>
                                    <td align="center" valign="center" style="text-align:center; padding-bottom: 10px">
                                        <div style="text-align:center; margin:0 15px 34px 15px">
                                            <div style="font-size: 14px; font-weight: 500; margin-bottom: 27px; font-family:Arial,Helvetica,sans-serif;">
                                                <p style="margin-bottom:2px; color:#7E8299">Se não solicitou a alteração da sua palavra-passe, contacte-nos de imediato.</p>
                                            </div>
                                        </div>
                                    </td>
                                </tr>

                                <tr>
                                    <td align="center" valign="center" style="text-align:center">
                                        <a href="#"><img alt="Logo" src="https://firebasestorage.googleapis.com/v0/b/jmai-docs.appspot.com/o/imagens_templates_email%2Frodape.png?alt=media&token=c3a94df4-e26d-4ad7-9f7b-96ae03f0e542" height="50px"></a>
                                    </td>
                                </tr>

                            </tbody>
                        </table>
                    </div>
                </div>
            `;

            SendEmail(email, "Palavra-Passe Alterada", "", corpo_email);

			res.status(201).json({
				status: "success",
				data: {
					token: token,
				},
				messages: ["Palavra-Passe Alterada com Sucesso!"],
			});
		}
	);
};

module.exports = {
	LoginUtilizador,
	LoginUtente,
	RecuperarPalavraPasseUtente,
	VerificarTokenRecuperacaoPalavraPasseUtente,
	ValidarTokenRecuperacaoPalavraPasseUtente,
	AlterarPalavraPasseUtente,
};
