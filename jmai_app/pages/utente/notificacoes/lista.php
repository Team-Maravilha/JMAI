<?php require_once($_SERVER["DOCUMENT_ROOT"] . "/head.php") ?>
<?php require_once($_SERVER["DOCUMENT_ROOT"] . "/api/api.php") ?>
<?php
$api = new Api();
$requerimentos = $api->post("requerimentos/ver_requerimentos", ["hashed_id_utente" => $id_user], null);
$notificacoes = $requerimentos["response"]["data"];
$page_name = "As Minhas Notificações";
?>

<body id="kt_app_body" data-kt-app-header-fixed="true" data-kt-app-header-fixed-mobile="true" data-kt-app-sidebar-enabled="false" data-kt-app-sidebar-fixed="false" data-kt-app-sidebar-push-toolbar="true" data-kt-app-sidebar-push-footer="true" data-kt-app-toolbar-enabled="true" class="app-default">
	<div class="d-flex flex-column flex-root app-root" id="kt_app_root">
		<div class="app-page flex-column flex-column-fluid" id="kt_app_page">
			<?php require_once($_SERVER["DOCUMENT_ROOT"] . "/header.php") ?>
			<div class="app-wrapper d-flex" id="kt_app_wrapper">
				<div class="app-container container-xxl">
					<div class="app-main flex-column flex-row-fluid" id="kt_app_main">
						<div class="d-flex flex-column flex-column-fluid">
							<?php require_once($_SERVER["DOCUMENT_ROOT"] . "/toolbar.php") ?>
							<div id="kt_app_content" class="app-content">
								<!-- Conteudo AQUI! -->

								<div class="row">

									<?php foreach ($notificacoes as $key => $value) { ?>
										<div class="col-12 col-lg-4">
											<div class="card card-flush h-md-100">
												<div class="card-body py-9">
													<div class="row gx-9 h-100">

														<div class="col-12">
															<div class="d-flex flex-column h-100">
																<div class="mb-7">
																	<div class="d-flex flex-stack mb-6">
																		<div class="flex-shrink-0 me-5">
																			<span class="text-gray-500 fs-7 fw-bold me-2 d-block lh-1 pb-1"><?php echo $value["informacao_utente"]["nome"] ?></span>

																			<span class="text-gray-800 fs-1 fw-bold"><?php echo $value["numero_requerimento"] ?></span>
																		</div>
																		<span class="badge badge-light-primary flex-shrink-0 align-self-center py-3 px-4 fs-7"><?php echo $value["texto_estado"] ?></span>
																	</div>

																	<div class="d-flex align-items-center flex-wrap d-grid gap-2">
																		<div class="d-flex align-items-center me-5 me-xl-13">
																			<div class="m-0">
																				<span class="fw-semibold text-gray-500 d-block fs-8">Tipo Requerimento</span>
																				<?php if ($value["tipo_requerimento"] === 0) { ?>
																					<span class="badge badge-primary me-2">Multiuso</span>
																				<?php } else if ($value["tipo_requerimento"] === 1) { ?>
																					<span class="badge badge-primary me-2">Importação de Veículo</span>
																				<?php } else { ?>
																					<span class="badge badge-light-dark me-2">Sem Informação Tipo</span>
																				<?php } ?>
																			</div>
																		</div>

																		<div class="d-flex align-items-center">
																			<div class="m-0">
																				<span class="fw-semibold text-gray-500 d-block fs-8">Tipo Submissão</span>
																				<?php if ($value["primeira_submissao"] === 1) { ?>
																					<span class="badge badge-success me-2">Primeira Submissão</span>
																				<?php } else if ($value["primeira_submissao"] === 0) { ?>
																					<span class="badge badge-danger me-2">ReAvaliação -<span class="ms-1"><?php echo "Data Última Submissão: " . $value["data_submissao_anterior"] ?></span></span>
																				<?php } else { ?>
																					<span class="badge badge-light-dark me-2">Sem Informação</span>
																				<?php } ?>
																			</div>
																		</div>
																	</div>
																</div>

																<div class="mb-6">
																	<span class="fw-semibold text-gray-600 fs-6 mb-8 d-block"><?php echo isset($value["avalicao"]["notas"]) && !empty($value["avalicao"]["notas"]) ? $value["avalicao"]["notas"] : "Sem Notas/Observações a Apresentar!" ?></span>

																	<div class="d-flex">
																		<div class="border border-gray-300 border-dashed rounded min-w-100px w-100 py-2 px-4 me-6 mb-3">
																			<span class="fs-6 text-gray-700 fw-bold"><?php echo $value["avaliacao"]["data_avaliacao"] ?></span>

																			<div class="fw-semibold text-gray-500">Data Avaliação</div>
																		</div>

																		<div class="border border-gray-300 border-dashed rounded min-w-100px w-100 py-2 px-4 mb-3">
																			<span class="fs-6 text-gray-700 fw-bold"><?php echo $value["avaliacao"]["grau_avaliacao"] ?></span>

																			<div class="fw-semibold text-gray-500">Grau Avaliação</div>
																		</div>
																	</div>
																</div>

																<div class="d-flex flex-stack mt-auto bd-highlight">
																	<div class="symbol-group symbol-hover flex-nowrap">
																		<div class="m-0">
																			<span class="fw-semibold text-gray-500 d-block fs-8">Submissão Requerimento</span>
																			<span class="fw-bold text-gray-800 text-hover-primary fs-7"><?php echo $value["data_criacao"] ?></span>
																		</div>
																	</div>
																	<?php 
																	$hashed_id_requerimento = $value["hashed_id"];
																	?>
																	<div class="d-flex my-4">
																		<a class="btn btn-sm btn-danger me-3" onclick="rejectRequest('<?php echo $hashed_id_requerimento ?>')">Recusar</a>
																		<a class="btn btn-sm btn-success me-3" onclick="acceptRequest('<?php echo $hashed_id_requerimento ?>')">Confirmar</a>
																	</div>

																</div>
															</div>
														</div>

													</div>
												</div>
											</div>
										</div>
									<?php } ?>

								</div>

								<!-- Fecha Conteudo AQUI! -->
							</div>
						</div>
						<?php require_once($_SERVER["DOCUMENT_ROOT"] . "/footer.php") ?>
					</div>
				</div>
			</div>
		</div>
	</div>
	<?php require_once($_SERVER["DOCUMENT_ROOT"] . "/foo.php") ?>

	<script>
		var acceptRequest = (hashed_id_requerimento) => {
			Swal.fire({
				title: 'Aceitar Junta Médica',
				text: "Tem a certeza que pretende se submeter à Junta Médica?",
				icon: 'success',
				showCancelButton: true,
				showConfirmButton: true,
				confirmButtonText: 'Sim, submeter!',
				cancelButtonText: 'Cancelar!',
				reverseButtons: true,
				buttonsStyling: false,
				allowOutsideClick: false,
				didOpen: () => {
					const confirmButton = Swal.getConfirmButton();
					confirmButton.blur();
				},
				customClass: {
					confirmButton: "btn fw-bold btn-success",
					cancelButton: "btn fw-bold btn-active-light-warning",
				},
			}).then((result) => {
				if (result.isConfirmed) {
					Swal.fire({
						title: 'A submeter o pedido!',
						text: 'Por favor aguarde...',
						icon: 'info',
						allowOutsideClick: false,
						showConfirmButton: false,
						willOpen: () => {
							Swal.showLoading()
						},
					});
					fetch(api_base_url + "requerimentos/resposta_utente/aceitar/" + hashed_id_requerimento, {
							method: "PUT",
							headers: {
								"Content-Type": "application/json",
								"Authorization": token,
							},
						})
						.then(response => response.json())
						.then(data => {
							if (data.status === "success") {
								Swal.fire({
									title: data.messages[0],
									text: 'Por Favor Aguarde...',
									icon: 'success',
									allowOutsideClick: false,
									showConfirmButton: false,
									willOpen: () => {
										Swal.showLoading()
									},
								});
								setTimeout(() => {
									location.reload();
								}, 1500);
							} else {
								Swal.fire({
									title: 'Erro ao confirmar o pedido!',
									text: data.messages[0],
									icon: 'error',
									allowOutsideClick: false,
									showConfirmButton: false,
									willOpen: () => {
										Swal.showLoading()
									},
								});
								setTimeout(() => {
									location.reload();
								}, 3000);
							}
						})
						.catch(error => {
							Swal.fire({
								title: 'Erro ao confirmar o pedido!',
								text: 'Por favor tente novamente...',
								icon: 'error',
								allowOutsideClick: false,
								showConfirmButton: false,
								willOpen: () => {
									Swal.showLoading()
								},
							});
							setTimeout(() => {
									location.reload();
								},
								3000);
						});
				} else if (result.dismiss === Swal.DismissReason.cancel) {
					toastr.warning('Cancelou a operação que realizava!', 'Cancelado!');
				}
			})
		}

		var rejectRequest = () => {
			Swal.fire({
				title: 'Recusar Requerimento',
				text: "Tem a certeza que pretende recusar o Requerimento?",
				icon: 'error',
				showCancelButton: true,
				showConfirmButton: true,
				confirmButtonText: 'Sim, recusar!',
				cancelButtonText: 'Não, cancelar!',
				reverseButtons: true,
				buttonsStyling: false,
				allowOutsideClick: false,
				didOpen: () => {
					const confirmButton = Swal.getConfirmButton();
					confirmButton.blur();
				},
				customClass: {
					confirmButton: "btn fw-bold btn-danger",
					cancelButton: "btn fw-bold btn-active-light-warning",
				},
			}).then((result) => {
				if (result.isConfirmed) {
					Swal.fire({
						title: 'A recusar o requerimento!',
						text: 'Por favor aguarde...',
						icon: 'info',
						allowOutsideClick: false,
						showConfirmButton: false,
						willOpen: () => {
							Swal.showLoading()
						},
					});
					fetch(api_url + path + "invalidar", {
							method: "POST",
							headers: {
								"Content-Type": "application/json",
								"Authorization": token,
							},
							body: JSON.stringify({
								hashed_id_requerimento: "<?php echo $hashed_id_requerimento ?>",
								hashed_id_utilizador: "<?php echo $id_user ?>"
							}),
						})
						.then(response => response.json())
						.then(data => {
							if (data.status === "success") {
								Swal.fire({
									title: data.messages[0],
									text: 'A redirecionar para a lista de requerimentos...',
									icon: 'success',
									allowOutsideClick: false,
									showConfirmButton: false,
									willOpen: () => {
										Swal.showLoading()
									},
								});
								setTimeout(() => {
									window.location = "<?php echo $link_home ?>pages/rececionista/requerimentos/lista";
								}, 1500);
							} else {
								Swal.fire({
									title: 'Erro ao recusar o requerimento!',
									text: data.messages[0],
									icon: 'error',
									allowOutsideClick: false,
									showConfirmButton: false,
									willOpen: () => {
										Swal.showLoading()
									},
								});
								setTimeout(() => {
									window.location = "<?php echo $link_home ?>pages/rececionista/requerimentos/lista";
								}, 1500);
							}
						})
						.catch(error => {
							Swal.fire({
								title: 'Erro ao recusar o requerimento!',
								text: 'Por favor tente novamente...',
								icon: 'error',
								allowOutsideClick: false,
								showConfirmButton: false,
								willOpen: () => {
									Swal.showLoading()
								},
							});
							setTimeout(() => {
									window.location.href = "<?php echo $link_home ?>pages/rececionista/requerimentos/lista";
								},
								1500);
						});
				} else if (result.dismiss === Swal.DismissReason.cancel) {
					toastr.warning('Cancelou a operação que realizava!', 'Cancelado!');
				}
			})
		}
	</script>
</body>