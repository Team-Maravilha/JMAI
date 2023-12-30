<?php require_once($_SERVER["DOCUMENT_ROOT"] . "/head.php") ?>
<?php $page_name = "Dashboard - Administrador" ?>

<body id="kt_app_body" data-kt-app-header-fixed="true" data-kt-app-header-fixed-mobile="true" data-kt-app-sidebar-enabled="false" data-kt-app-sidebar-fixed="false" data-kt-app-sidebar-push-toolbar="true" data-kt-app-sidebar-push-footer="true" data-kt-app-toolbar-enabled="true" class="app-default">
	<div class="d-flex flex-column flex-root app-root" id="kt_app_root">
		<div class="app-page flex-column flex-column-fluid" id="kt_app_page">
			<?php require_once($_SERVER["DOCUMENT_ROOT"] . "/header.php") ?>
			<div class="app-wrapper d-flex" id="kt_app_wrapper">
				<div class="app-container container-xxl">
					<div class="app-main flex-column flex-row-fluid" id="kt_app_main">
						<div class="d-flex flex-column flex-column-fluid">
							<?php require_once($_SERVER["DOCUMENT_ROOT"] . "/toolbar.php") ?>

							<!-- Conteudo AQUI! -->

							<div class="row d-flex mb-7 mt-1 gy-7 ">
								<div class="col-sm-6 col-xl-3">
									<div class="card h-lg-100">
										<div class="card-body d-flex justify-content-between align-items-start flex-column">
											<!--begin::Icon-->
											<div class="m-0">
												<i class="ki-duotone ki-some-files fs-2hx text-gray-600">
													<span class="path1"></span>
													<span class="path2"></span>
												</i>
											</div>
											<!--end::Icon-->
											<div class="d-flex flex-column my-7">
												<span class="fw-semibold fs-3x text-gray-800 lh-1 ls-n2" data-element="total_requerimentos">0</span>
												<div class="m-0">
													<span class="fw-semibold fs-6 text-gray-500">Total de Requerimentos</span>
												</div>
											</div>
										</div>
									</div>
								</div>

								<div class="col-sm-6 col-xl-3">
									<div class="card h-lg-100">
										<div class="card-body d-flex justify-content-between align-items-start flex-column">
											<!--begin::Icon-->
											<div class="m-0">
												<i class="ki-duotone ki-file-added fs-2hx text-gray-600">
													<span class="path1"></span>
													<span class="path2"></span>
													<span class="path3"></span>
													<span class="path4"></span>
												</i>
											</div>
											<!--end::Icon-->
											<div class="d-flex flex-column my-7">
												<span class="fw-semibold fs-3x text-gray-800 lh-1 ls-n2" data-element="total_requerimentos_agendados">0</span>
												<div class="m-0">
													<span class="fw-semibold fs-6 text-gray-500">Total de Agendados</span>
												</div>
											</div>
										</div>
									</div>
								</div>

								<div class="col-sm-6 col-xl-3">
									<div class="card h-lg-100">
										<div class="card-body d-flex justify-content-between align-items-start flex-column">
											<!--begin::Icon-->
											<div class="m-0">
												<i class="ki-duotone ki-file-deleted fs-2hx text-gray-600">
													<span class="path1"></span>
													<span class="path2"></span>
												</i>
											</div>
											<!--end::Icon-->
											<div class="d-flex flex-column my-7">
												<span class="fw-semibold fs-3x text-gray-800 lh-1 ls-n2" data-element="total_requerimentos_tipo_multiuso">0</span>
												<div class="m-0">
													<span class="fw-semibold fs-6 text-gray-500">Total - Multiusos</span>
												</div>
											</div>
										</div>
									</div>
								</div>

								<div class="col-sm-6 col-xl-3">
									<div class="card h-lg-100">
										<div class="card-body d-flex justify-content-between align-items-start flex-column">
											<!--begin::Icon-->
											<div class="m-0">
												<i class="ki-duotone ki-file-deleted fs-2hx text-gray-600">
													<span class="path1"></span>
													<span class="path2"></span>
												</i>
											</div>
											<!--end::Icon-->
											<div class="d-flex flex-column my-7">
												<span class="fw-semibold fs-3x text-gray-800 lh-1 ls-n2" data-element="total_requerimentos_tipo_importacao">0</span>
												<div class="m-0">
													<span class="fw-semibold fs-6 text-gray-500">Total - Importação de Veículo</span>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>

							<div class="row g-7">
								<div class="col-12">
									<div class="card card-bordered card-flush">
										<div class="card-header pt-5">

											<!--begin::Title-->
											<h3 class="card-title align-items-start flex-column">
												<span class="card-label fw-bold text-gray-900">Nº de Requerimentos por Distrito</span>
												<span class="text-gray-500 mt-1 fw-semibold fs-6">Nº Total de Requerimentos por Distrito de Portugal</span>
											</h3>
											<!--end::Title-->
											<!--begin::Toolbar-->
											<div class="card-toolbar">
												<div class="btn btn-sm btn-light d-flex align-items-center px-4" id="date_range_picker_requerimentos_distrito">
													<!--begin::Display range-->
													<div class="text-gray-600 fw-bold">A Carregar...</div>
													<!--end::Display range-->
													<i class="ki-duotone ki-calendar-search fs-1 ms-2 me-0">
														<span class="path1"></span>
														<span class="path2"></span>
														<span class="path3"></span>
														<span class="path4"></span>
													</i>
												</div>
											</div>
											<!--end::Toolbar-->

										</div>
										<div class="card-body">
											<!-- <div id="kt_apexcharts_1" style="height: 350px;"></div> -->
											<div id="chart_requerimentos_distrito" style="height: 350px;"></div>
										</div>
									</div>
								</div>
								<div class="col-12">

									<div class="card card-bordered card-flush">
										<div class="card-header pt-5">

											<!--begin::Title-->
											<h3 class="card-title align-items-start flex-column">
												<span class="card-label fw-bold text-gray-900">Nº de Requerimentos por Data</span>
												<span class="text-gray-500 mt-1 fw-semibold fs-6">Nº Total de de Requerimentos por Data</span>
											</h3>
											<!--end::Title-->

											<!--begin::Toolbar-->
											<div class="card-toolbar">
												<div class="btn btn-sm btn-light d-flex align-items-center px-4" id="date_range_picker_requerimentos_periodo">
													<!--begin::Display range-->
													<div class="text-gray-600 fw-bold">A Carregar...</div>
													<!--end::Display range-->
													<i class="ki-duotone ki-calendar-search fs-1 ms-2 me-0">
														<span class="path1"></span>
														<span class="path2"></span>
														<span class="path3"></span>
														<span class="path4"></span>
													</i>
												</div>
											</div>
											<!--end::Toolbar-->

										</div>
										<div class="card-body">
											<div id="chart_requerimentos_periodo" style="height: 350px;"></div>
										</div>
									</div>
								</div>
								<div class="col-12 col-lg-4">
									<div class="card card-bordered card-flush">
										<div class="card-header pt-5">
											<!--begin::Title-->
											<h3 class="card-title align-items-start flex-column">
												<span class="card-label fw-bold text-gray-900">Nº de Requerimentos por Estado</span>
												<span class="text-gray-500 mt-1 fw-semibold fs-6">Nº Total de Requerimentos por Estado</span>
											</h3>
											<!--end::Title-->
										</div>
										<div class="card-body">
											<div id="chart_requerimentos_estado" style="height: 350px;"></div>
										</div>
									</div>
								</div>
								<div class="col-12 col-lg-8">
									<div class="card card-bordered card-flush">
										<div class="card-header pt-5">
											<!--begin::Title-->
											<h3 class="card-title align-items-start flex-column">
												<span class="card-label fw-bold text-gray-900">Evolução do Nº de Requerimentos por Ano</span>
												<span class="text-gray-500 mt-1 fw-semibold fs-6">Evolução Total do Nº de Requerimentos por Ano distribuido por Mês</span>
											</h3>
											<!--end::Title-->
										</div>
										<div class="card-body">
											<div id="chart_evolucao_requerimentos_ano" style="height: 350px;"></div>
										</div>
									</div>
								</div>
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

	<script src="index.js"></script>

	<script>
		function handleCarregarDadosDashboard() {

			const requestOptions = {
				method: "GET",
				headers: {
					"Content-Type": "application/json",
					"Authorization": "<?php echo $_SESSION['token'] ?>"
				},
			};

			fetch(`${api_base_url}graficos/dashboard_totais`, requestOptions)
				.then((response) => response.json())
				.then((data) => {
					if (data.status === "success") {
						const kt_countup_1 = new countUp.CountUp(document.querySelector("[data-element='total_requerimentos']"));
						kt_countup_1.update(data.data.total_requerimentos);
						
						const kt_countup_2 = new countUp.CountUp(document.querySelector("[data-element='total_requerimentos_agendados']"));
						kt_countup_2.update(data.data.total_requerimentos_agendados);

						const kt_countup_3 = new countUp.CountUp(document.querySelector("[data-element='total_requerimentos_tipo_multiuso']"));
						kt_countup_3.update(data.data.total_requerimentos_tipo_multiuso);

						const kt_countup_4 = new countUp.CountUp(document.querySelector("[data-element='total_requerimentos_tipo_importacao']"));
						kt_countup_4.update(data.data.total_requerimentos_tipo_importacao);
					} else {
						toastr.error(data.messages[0], "Erro!");
					}
				})
				.catch((error) => {
					toastr.error(error, "Erro!");
				})
				.finally(() => {

				});
		}

		window.addEventListener("DOMContentLoaded", () => {
			setTimeout(function() {
				handleCarregarDadosDashboard();
			}, 1000)
		});

	</script>

</body>