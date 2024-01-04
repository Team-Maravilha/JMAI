const { parse } = require("dotenv");
const pool = require("../../db");
const SendEmail = require("../send_email/send_email");
const axios = require("axios").default;
// Definir as tags da Documentação
/**
 * @swagger
 * tags:
 *   name: Requerimentos
 *   description: Gestão de Requerimentos
 */

const RegistarRequerimento = async (req, res) => {
  const {
    id_utente,
    tipo_documento,
    numero_documento,
    data_validade_documento,
    numero_contribuinte,
    data_nascimento,
    freguesia_naturalidade,
    morada,
    codigo_postal,
    freguesia_residencia,
    numero_telemovel,
    tipo_requerimento,
    primeira_submissao,
    data_submissao_anterior,
    numero_telefone,
    email_preferencial,
    data_emissao_documento,
    local_emissao_documento,
    documentos,
  } = req.body;

  pool.query(
    "SELECT * FROM inserir_requerimento($1, $2, $3, $4, $5, $6, $7, $8, $9, $10, $11, $12, $13, $14, $15, $16, $17, $18, $19)",
    [
      id_utente,
      parseInt(tipo_documento),
      parseInt(numero_documento) || null,
      data_validade_documento,
      parseInt(numero_contribuinte) || null,
      data_nascimento,
      freguesia_naturalidade,
      morada,
      codigo_postal,
      freguesia_residencia,
      parseInt(numero_telemovel) || null,
      parseInt(tipo_requerimento),
      primeira_submissao,
      data_submissao_anterior,
      parseInt(numero_telefone) || null,
      email_preferencial,
      data_emissao_documento,
      local_emissao_documento,
      documentos,
    ],
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
        data: results.rows[0],
        messages: ["O seu Requerimento foi registado com Sucesso!"],
      });
    }
  );
};

const ListarRequerimentosDataTable = (req, res) => {
  const { hashed_id, hashed_id_utente, data_criacao, estado, tipo_requerimento } = req.body;

  pool.query("SELECT * FROM listar_requerimentos($1, $2, $3, $4, $5)", [hashed_id, hashed_id_utente, data_criacao, estado, tipo_requerimento], (error, results) => {
    if (error) {
      res.status(400).json({
        recordsTotal: 0,
        recordsFiltered: 0,
        data: [],
      });
      return;
    }
    res.status(200).json({
      recordsTotal: results.rows.length,
      recordsFiltered: results.rows.length,
      data: results.rows,
    });
  });
};

const ListarRequerimentos = (req, res) => {
	const { hashed_id, hashed_id_utente, data_criacao, estado, tipo_requerimento } = req.body;
	pool.query("SELECT * FROM listar_requerimentos($1, $2, $3, $4, $5)", [hashed_id, hashed_id_utente, data_criacao, estado, tipo_requerimento], (error, results) => {
		if (error) {
			res.status(400).json({
				status: "error",
				data: null,
				messages: [error.message],
			});
			return;
		}
		res.status(200).json({
			status: "success",
			data: results.rows,
			messages: ["Informações dos Requerimentos obtidas com Sucesso!"],
		});
	});
};

const ListarRequerimentosUtente = (req, res) => {
  const { hashed_id_utente } = req.body;

  pool.query("SELECT * FROM listar_requerimentos(NULL, $1, NULL, 2, NULL)", [hashed_id_utente], (error, results) => {
    if (error) {
      res.status(400).json({
        status: "error",
        data: null,
        messages: [error.message],
      });
      return;
    }
    res.status(200).json({
      status: "success",
      data: results.rows,
      messages: ["Informações dos Requerimentos obtidas com Sucesso!"],
    });
  });
};

const RegistarAcesso = (req, res) => {
  const { hashed_id_requerimento, hashed_id_utilizador } = req.body;

  pool.query("SELECT * FROM inserir_log_acesso_requerimento($1, $2)", [hashed_id_requerimento, hashed_id_utilizador], (error, results) => {
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
      data: results.rows[0],
      messages: ["Acesso registado com Sucesso!"],
    });
  });
};

const ListarAcessosRequerimento = (req, res) => {
  const { hashed_id_requerimento, cargo_utilizador } = req.query;

  pool.query("SELECT * FROM listar_log_acesso_requerimento($1, $2)", [hashed_id_requerimento, cargo_utilizador], (error, results) => {
    if (error) {
      res.status(400).json({
        recordsTotal: 0,
        recordsFiltered: 0,
        data: [],
      });
      return;
    }
    res.status(200).json({
      recordsTotal: results.rows.length,
      recordsFiltered: results.rows.length,
      data: results.rows,
    });
  });
};

const ValidarRequerimento = (req, res) => {
  const { hashed_id_requerimento, hashed_id_utilizador } = req.body;

  pool.query("SELECT * FROM alterar_estado_requerimento($1, $2, $3)", [hashed_id_requerimento, hashed_id_utilizador, 1], (error, results) => {
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
      data: results.rows[0],
      messages: ["Requerimento validado com Sucesso!"],
    });
  });
};

const InvalidarRequerimento = (req, res) => {
  const { hashed_id_requerimento, hashed_id_utilizador } = req.body;

  pool.query("SELECT * FROM alterar_estado_requerimento($1, $2, $3)", [hashed_id_requerimento, hashed_id_utilizador, 5], (error, results) => {
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
      data: results.rows[0],
      messages: ["Requerimento recusado com Sucesso!"],
    });
  });
};

const AvaliarRequerimento = (req, res) => {
	const {
		hashed_id_requerimento,
		hashed_id_utilizador,
		grau_avaliacao,
		notas,
	} = req.body;
	pool.query(
		"SELECT * FROM avaliar_requerimento($1, $2, $3, $4)",
		[hashed_id_requerimento, hashed_id_utilizador, grau_avaliacao, notas],
		(error, results) => {
			if (error) {
				res.status(400).json({
					status: "error",
					data: null,
					messages: [error.message],
				});
				return;
			}
			const id_notificacao = results.rows[0].id_notificacao;

			// Enviar Email
			const email_to = results.rows[0].email_preferencial;
			const nome = results.rows[0].nome;
			const email_subjet = "JMAI | Avaliação de Requerimento";
			const email_text = "O seu requerimento foi avaliado por um dos nossos médicos, com base nas informações fornecidas por sí.";
			const email_html = `
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
													<p style="margin-bottom:9px; color:#181C32; font-size: 22px; font-weight:700">Olá ${nome}, temos novidades!</p>
													<p style="margin-bottom:2px; color:#7E8299">O seu requerimento foi avaliado por um dos nossos</p>
													<p style="margin-bottom:2px; color:#7E8299">médicos, com base nas informações fornecidas por sí.</p>
												</div>
												<!--end:Text-->

												<!--begin:Action-->
												<a href="http://jmai.localhost/" target="_blank" style="background-color:#49beb7; border-radius:6px;display:inline-block; padding:11px 19px; color: #FFFFFF; font-size: 14px; font-weight:500;">
													Verificar
												</a>
												<!--begin:Action-->
											</div>
											<!--end:Email content-->
										</td>
									</tr>


									<tr style="display: flex; justify-content: center; margin:0 60px 35px 60px">
										<td align="start" valign="start" style="padding-bottom: 10px;">
											<p style="color:#181C32; font-size: 18px; font-weight: 600; margin-bottom:13px">Proximos passos?</p>

											<!--begin::Wrapper-->
											<div style="background: #F9F9F9; border-radius: 12px; padding:35px 30px">
												<!--begin::Item-->
												<div style="display:flex">
													<!--begin::Media-->
													<div style="display: flex; justify-content: center; align-items: center; width:40px; height:40px; margin-right:13px">
														<img alt="Logo" src="https://firebasestorage.googleapis.com/v0/b/jmai-docs.appspot.com/o/imagens_templates_email%2F1.png?alt=media&token=91514ce3-69fb-4e69-bd6e-4e2cc27b0743" width="40px" height="40px">
													</div>
													<!--end::Media-->

													<!--begin::Block-->
													<div>
														<!--begin::Content-->
														<div>
															<!--begin::Title-->
															<a href="#" style="color:#181C32; font-size: 14px; font-weight: 600;font-family:Arial,Helvetica,sans-serif">Decidir se pretende continuar</a>
															<!--end::Title-->

															<!--begin::Desc-->
															<p style="color:#5E6278; font-size: 13px; font-weight: 500; padding-top:3px; margin:0;font-family:Arial,Helvetica,sans-serif">Com base na avaliação do médico, você pode decidir se deseja continuar com o processo, submetendo-se a uma Junta Médica de Avaliação de Incapacidade, ou se deseja desistir do processo.</p>
															<!--end::Desc-->
														</div>
														<!--end::Content-->

														<!--begin::Separator-->
														<div class="separator separator-dashed" style="margin:17px 0 15px 0"></div>
														<!--end::Separator-->

													</div>
													<!--end::Block-->
												</div>
												<!--end::Item-->
												<!--begin::Item-->
												<div style="display:flex">
													<!--begin::Media-->
													<div style="display: flex; justify-content: center; align-items: center; width:40px; height:40px; margin-right:13px">
														<img alt="Logo" src="https://firebasestorage.googleapis.com/v0/b/jmai-docs.appspot.com/o/imagens_templates_email%2F2.png?alt=media&token=741e8215-e060-4000-8488-3fef8030c532" width="40px" height="40px">
													</div>
													<!--end::Media-->

													<!--begin::Block-->
													<div>
														<!--begin::Content-->
														<div>
															<!--begin::Title-->
															<a href="#" style="color:#181C32; font-size: 14px; font-weight: 600;font-family:Arial,Helvetica,sans-serif">Esperar pela marcação da Junta Médica</a>
															<!--end::Title-->

															<!--begin::Desc-->
															<p style="color:#5E6278; font-size: 13px; font-weight: 500; padding-top:3px; margin:0;font-family:Arial,Helvetica,sans-serif">Se decidir continuar com o processo, irá receber uma carta a comunicar a convocação para uma Junta Médica de Avaliação de Incapacidade, onde será avaliado por uma equipa de médicos especialistas.</p>
															<!--end::Desc-->
														</div>
														<!--end::Content-->

														<!--begin::Separator-->
														<div class="separator separator-dashed" style="margin:17px 0 15px 0"></div>
														<!--end::Separator-->

													</div>
													<!--end::Block-->
												</div>
												<!--end::Item-->
												<!--begin::Item-->
												<div style="display:flex">
													<!--begin::Media-->
													<div style="display: flex; justify-content: center; align-items: center; width:40px; height:40px; margin-right:13px">
														<img alt="Logo" src="https://firebasestorage.googleapis.com/v0/b/jmai-docs.appspot.com/o/imagens_templates_email%2F3.png?alt=media&token=9ff6dea9-8f72-46c6-ac26-0adb295be863" width="40px" height="40px">
													</div>
													<!--end::Media-->

													<!--begin::Block-->
													<div>
														<!--begin::Content-->
														<div>
															<!--begin::Title-->
															<a href="#" style="color:#181C32; font-size: 14px; font-weight: 600;font-family:Arial,Helvetica,sans-serif">Receber a decisão final</a>
															<!--end::Title-->

															<!--begin::Desc-->
															<p style="color:#5E6278; font-size: 13px; font-weight: 500; padding-top:3px; margin:0;font-family:Arial,Helvetica,sans-serif">Após a avaliação, será notificado da decisão final, que pode ser de deferimento ou indeferimento.</p>
															<!--end::Desc-->
														</div>
														<!--end::Content-->


													</div>
													<!--end::Block-->
												</div>
												<!--end::Item-->

											</div>
											<!--end::Wrapper-->
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

			if (email_to != null) {
				SendEmail(email_to, email_subjet, email_text, email_html);
				pool.query(
					"SELECT * FROM comunicar_utente($1, 1, $2, $3)",
					[id_notificacao, email_subjet, email_text],
					(error, results) => {
						if (error) {
							//console.log(error.message);
						}
					}
				);
			}

			// Enviar SMS
			const numero_telemovel = results.rows[0].numero_telemovel;
			const texto = `Olá ${nome}, temos novidades! \nO seu requerimento foi avaliado por um dos nossos médicos, com base nas informações fornecidas por sí. \n\nConsulte a sua área reservada para dar continuidade ao processo. \nComprometidos com a Verdadeira Medida da Saúde`;

			if (numero_telemovel != null) {
				SendSMS(numero_telemovel, texto);
				pool.query(
					"SELECT * FROM comunicar_utente($1, 0, $2, $3)",
					[id_notificacao, "SMS", texto],
					(error, results) => {
						if (error) {
							//console.log(error.message);
						}
					}
				);
			}

			res.status(201).json({
				status: "success",
				data: results.rows[0],
				messages: ["Requerimento avaliado com Sucesso!"],
			});
		}
	);
};

const VerInformacaoRequerimentoByHashedID = (req, res) => {
  const { hashed_id } = req.params;

  pool.query("SELECT * FROM listar_requerimentos($1)", [hashed_id], (error, results) => {
    if (error) {
      res.status(400).json({
        status: "error",
        data: null,
        messages: [error.message],
      });
      return;
    }
    res.status(200).json({
      status: "success",
      data: results.rows[0],
      messages: ["Informação do Requerimento obtida com Sucesso!"],
    });
  });
};

const HistoricoEstadosRequerimento = (req, res) => {
	const { hashed_id } = req.params;

	pool.query(
		"SELECT * FROM listar_alteracoes_estado_requerimento($1)",
		[hashed_id],
		(error, results) => {
			if (error) {
				res.status(400).json({
					status: "error",
					data: null,
					messages: [error.message],
				});
				return;
			}
			res.status(200).json({
				status: "success",
				data: results.rows,
				messages: [
					"Informação do Requerimento obtida com Sucesso!",
				],
			});
		}
	);
};

const AceitarRespostaUtente = (req, res) => {
	const { hashed_id } = req.params;

	pool.query(
		"SELECT * FROM responder_comunicacao_utente($1, 1)",
		[hashed_id],
		(error, results) => {
			if (error) {
				res.status(400).json({
					status: "error",
					data: null,
					messages: [error.message],
				});
				return;
			}
			res.status(200).json({
				status: "success",
				data: results.rows[0],
				messages: ["Junta Médica aceite com Sucesso!"],
			});
		}
	);
};

const RejeitarRespostaUtente = (req, res) => {
	const { hashed_id } = req.params;

	pool.query(
		"SELECT * FROM responder_comunicacao_utente($1, 0)",
		[hashed_id],
		(error, results) => {
			if (error) {
				res.status(400).json({
					status: "error",
					data: null,
					messages: [error.message],
				});
				return;
			}
			res.status(200).json({
				status: "success",
				data: results.rows[0],
				messages: ["Junta Médica recusada com Sucesso!"],
			});
		}
	);
};

const VerComunicacaoUtente = (req, res) => {
	const { hashed_id } = req.params;

	pool.query(
		"SELECT * FROM listar_comunicacoes_requerimento($1)",
		[hashed_id],
		(error, results) => {
			if (error) {
				res.status(400).json({
					recordsTotal: 0,
					recordsFiltered: 0,
					data: [],
				});
				return;
			}
			res.status(200).json({
				recordsTotal: results.rows.length,
				recordsFiltered: results.rows.length,
				data: results.rows,
			});
		}
	);
}

const AgendarConsulta = (req, res) => {
	const { hashed_id_requerimento, hashed_id_utilizador, data_agendamento, hora_agendamento, hashed_id_equipa_medica } = req.body;
	pool.query(
		"SELECT * FROM  agendar_consulta_requerimento($1, $2, $3, $4, $5)",
		[hashed_id_requerimento, hashed_id_utilizador, data_agendamento, hora_agendamento, hashed_id_equipa_medica],
		(error, results) => {
			if (error) {
				res.status(400).json({
					status: "error",
					data: null,
					messages: [error.message]
				});
				return;
			}
			res.status(201).json({
				status: "success",
				data: results.rows[0],
				messages: ["Consulta agendada com sucesso."],
			});
		}
	);
};

const ListarConsultas = (req, res) => {
	
	const { data_inicio, data_fim } = req.query;

	pool.query(
		"SELECT * FROM listar_agendamentos_consulta(NULL, NULL, $1, $2)",
		[data_inicio, data_fim],
		(error, results) => {
			if (error) {
				res.status(400).json({
					status: "error",
					data: null,
					messages: [error.message]
				});
				return;
			}
			res.status(200).json({
				status: "success",
				data: results.rows,
				messages: ["Consultas obtidas com sucesso."],
			});
		}
	);

};

const TestSendSMS = (req, res) => {
	const numero_telemovel = '915504516';
	const nome = 'João';
	const texto = `Olá ${nome}, temos novidades! \nO seu requerimento foi avaliado por um dos nossos médicos, com base nas informações fornecidas por sí. \n\nConsulte a sua área reservada para dar continuidade ao processo. \n\nComprometidos com a Verdadeira Medida da Saúde`;

	if (numero_telemovel != null) {
		SendSMS(numero_telemovel, texto);
	}

	res.status(200).json({
		status: "success",
		data: null,
		messages: ["SMS enviado com sucesso."],
	});

}

const TestSendPDF = (req, res) => {
	const buildPdf = require("../pdf/pdf");

	const stream = res.writeHead(200, {
		"Content-Type": "application/pdf",
		"Content-Disposition": "attachment; filename=requerimento.pdf",
	});

	buildPdf.buildPdf(
		(data) => {
			stream.write(data);
		},
		() => {
			stream.end();
		}
	);
}

const SendSMS = async (to, text) => {
  try {
    const ClickSend = await axios.post(
      "https://rest.clicksend.com/v3/sms/send",
      {
        messages: [
          {
            source: "sdk",
            from: "JMAI",
            body: text,
            to: `+351${to}`,
          },
        ],
      },
      {
        headers: {
          Authorization: "Basic " + Buffer.from(process.env.CLICKSEND_USERNAME + ":" + process.env.CLICKSEND_API_KEY).toString("base64"),
        },
      }
    );

    console.log(ClickSend);

    return true;
  } catch (error) {
    console.log(error.message);
    return false;
  }
};

module.exports = {
	RegistarRequerimento,
	ListarRequerimentosDataTable,
	ListarRequerimentos,
	VerInformacaoRequerimentoByHashedID,
	RegistarAcesso,
  	ListarRequerimentosUtente,
	ListarAcessosRequerimento,
	ValidarRequerimento,
	InvalidarRequerimento,
	AvaliarRequerimento,
	HistoricoEstadosRequerimento,
	AceitarRespostaUtente,
	RejeitarRespostaUtente,
	VerComunicacaoUtente,
	AgendarConsulta,
	ListarConsultas,
	TestSendSMS,
	TestSendPDF,
};
