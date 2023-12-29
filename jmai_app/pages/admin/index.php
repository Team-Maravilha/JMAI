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

							<div class="row d-flex mb-7 mt-2 gy-7 ">
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
												<span class="fw-semibold fs-3x text-gray-800 lh-1 ls-n2">370</span>
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
												<span class="fw-semibold fs-3x text-gray-800 lh-1 ls-n2">450</span>
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
												<span class="fw-semibold fs-3x text-gray-800 lh-1 ls-n2">149</span>
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
												<span class="fw-semibold fs-3x text-gray-800 lh-1 ls-n2">149</span>
												<div class="m-0">
													<span class="fw-semibold fs-6 text-gray-500">Total - Importação de Veículo</span>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>

							<div class="row gx-5 gx-xl-10">
								<div class="col-12 mb-5 mb-xl-10">
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
								<div class="col-12 col-lg-6 mb-5 mb-xl-10">

									<div class="card card-bordered card-flush">
										<div class="card-header pt-5">

											<!--begin::Title-->
											<h3 class="card-title align-items-start flex-column">
												<span class="card-label fw-bold text-gray-900">Nº de Requerimentos por por Data</span>
												<span class="text-gray-500 mt-1 fw-semibold fs-6">Nº de Requerimentos por Data</span>
											</h3>
											<!--end::Title-->
										</div>
										<div class="card-body">
											<div id="" style="height: 350px;"></div>
										</div>
									</div>
								</div>
								<div class="col-12 col-lg-6 mb-5 mb-xl-10">

									<div class="card card-bordered card-flush">
										<div class="card-header pt-5">

											<!--begin::Title-->
											<h3 class="card-title align-items-start flex-column">
												<span class="card-label fw-bold text-gray-900">Nº de Requerimentos por por Data</span>
												<span class="text-gray-500 mt-1 fw-semibold fs-6">Nº de Requerimentos por Data</span>
											</h3>
											<!--end::Title-->

											<!--begin::Toolbar-->
											<div class="card-toolbar">
												<div class="btn btn-sm btn-light d-flex align-items-center px-4" id="date_range_picker_requerimentos_data">
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
											<div id="kt_apexcharts_3" style="height: 350px;"></div>
										</div>
									</div>
								</div>
							</div>



							<div class="card card-bordered">
								<div class="card-body">
									<h3 class="card-title">Nº de Requerimentos por Estado</h3>
									<div id="kt_apexcharts_2" style="height: 350px;"></div>
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

	<!-- Chart de barras -->
	<script>
		var element = document.getElementById('kt_apexcharts_1');
		var barColors = [
			'#FF7A66', // Vermelho suave
			'#66FF7A', // Verde suave
			'#6680FF', // Azul suave
			'#FF66F2', // Magenta suave
			'#66FFF0', // Ciano suave
			'#FFD966', // Amarelo suave
			'#B366FF', // Roxo suave
			'#FFA366', // Laranja suave
			'#66FFAA', // Verde Claro suave
			'#6699FF', // Azul Claro suave
			'#FF66C9', // Rosa suave
			'#66FFEB', // Turquesa suave
			'#FFE366', // Amarelo Claro suave
			'#C266FF', // Violeta suave
			'#FF7A66', // Coral suave
			'#66FFE1', // Verde Água suave
			'#FF66F9', // Rosa Choque suave
			'#66A3FF' // Azul Royal suave
		];


		var height = parseInt(KTUtil.css(element, 'height'));
		var labelColor = '#7E8299';
		var borderColor = '#e3242b';
		var secondaryColor = '#E5EAEE';

		if (!element) {

		}

		var options = {
			series: [{
				name: 'Nº Pedidos',
				data: [76, 85, 101, 98, 87, 105, 91, 114, 94, 76, 85, 101, 98, 87, 105, 91, 114, 94]
			}],
			chart: {
				fontFamily: 'inherit',
				type: 'bar',
				height: 350,
				toolbar: {
					show: false
				}
			},
			plotOptions: {
				bar: {
					horizontal: false,
					columnWidth: ['30%'],
					borderRadius: 6,
					endingShape: 'rounded',
					distributed: true,
				},
			},

			legend: {
				show: false
			},
			dataLabels: {
				enabled: false
			},
			stroke: {
				show: true,
				width: 2,
				colors: ['transparent']
			},
			xaxis: {
				categories: ['Aveiro', 'Beja', 'Braga', 'Bragança', 'Castelo Branco', 'Coimbra', 'Évora', 'Faro', 'Guarda', 'Leiria', 'Lisboa', 'Portalegre', 'Porto', 'Santarém', 'Setúbal', 'Viana do Castelo', 'Vila Real', 'Viseu'],
				axisBorder: {
					show: false,
				},
				axisTicks: {
					show: false
				},
				labels: {
					style: {
						colors: labelColor,
						fontSize: '12px'
					}
				}
			},
			yaxis: {
				labels: {
					style: {
						colors: labelColor,
						fontSize: '12px'
					}
				}
			},
			fill: {
				opacity: 1
			},
			states: {
				normal: {
					filter: {
						type: 'none',
						value: 0
					}
				},
				hover: {
					filter: {
						type: 'none',
						value: 0
					}
				},
				active: {
					allowMultipleDataPointsSelection: false,
					filter: {
						type: 'none',
						value: 0
					}
				}
			},
			tooltip: {
				style: {
					fontSize: '12px'
				},
				y: {
					formatter: function(val) {
						return val
					}
				}
			},
			colors: barColors,
			grid: {
				borderColor: borderColor,
				strokeDashArray: 4,
				yaxis: {
					lines: {
						show: true
					}
				}
			}
		};

		//var chart = new ApexCharts(element, options);
		//chart.render();
	</script>

	<!-- Chart de linhas -->
	<script>
		var element = document.getElementById('kt_apexcharts_3');

		var height = parseInt(KTUtil.css(element, 'height'));
		var labelColor = '#7E8299';
		var borderColor = '#e3242b';
		var baseColor = '#729cd4';
		var lightColor = '#ffffff';

		if (!element) {

		}

		var options = {
			series: [{
				name: 'Nº Pedidos',
				data: [300, 400, 400, 900, 900, 700, 700, 230, 330, 210, 400, 530]
			}],
			chart: {
				fontFamily: 'inherit',
				type: 'area',
				height: height,
				toolbar: {
					show: false
				}
			},
			plotOptions: {

			},
			legend: {
				show: false
			},
			dataLabels: {
				enabled: false
			},
			fill: {
				type: 'solid',
				opacity: 1
			},
			stroke: {
				curve: 'smooth',
				show: true,
				width: 3,
				colors: [baseColor]
			},
			xaxis: {
				categories: ['Jan', 'Fev', 'Mar', 'Abr', 'Mai', 'Jun', 'Jul', 'Ago', 'Set', 'Out', 'Nov', 'Dez'],
				axisBorder: {
					show: false,
				},
				axisTicks: {
					show: false
				},
				labels: {
					style: {
						colors: labelColor,
						fontSize: '12px'
					}
				},
				crosshairs: {
					position: 'front',
					stroke: {
						color: baseColor,
						width: 1,
						dashArray: 3
					}
				},
				tooltip: {
					enabled: true,
					formatter: undefined,
					offsetY: 0,
					style: {
						fontSize: '12px'
					}
				}
			},
			yaxis: {
				labels: {
					style: {
						colors: labelColor,
						fontSize: '12px'
					}
				}
			},
			states: {
				normal: {
					filter: {
						type: 'none',
						value: 0
					}
				},
				hover: {
					filter: {
						type: 'none',
						value: 0
					}
				},
				active: {
					allowMultipleDataPointsSelection: false,
					filter: {
						type: 'none',
						value: 0
					}
				}
			},
			tooltip: {
				style: {
					fontSize: '12px'
				},
				y: {
					formatter: function(val) {
						return val
					}
				}
			},
			colors: [lightColor],
			grid: {
				borderColor: borderColor,
				strokeDashArray: 4,
				yaxis: {
					lines: {
						show: true
					}
				}
			},
			markers: {
				strokeColor: baseColor,
				strokeWidth: 3
			}
		};

		var chart = new ApexCharts(element, options);
		chart.render();
	</script>

	<!-- Chart Requerimentos Por estado -->
	<script>
		var barColors = [
			'#FF7A66', // Vermelho suave
			'#66FF7A', // Verde suave
			'#6680FF', // Azul suave
			'#FF66F2', // Magenta suave
			'#66FFF0', // Ciano suave
			'#FFD966', // Amarelo suave
			'#B366FF', // Roxo suave
			'#FFA366', // Laranja suave
		];
		var element = document.getElementById('kt_apexcharts_2');
		var options = {
			series: [{
				name: 'Nº Pedidos',
				data: [400, 430, 448, 470, 540, 580]
			}],
			chart: {
				type: 'bar',
				height: 350
			},
			plotOptions: {
				bar: {
					borderRadius: 4,
					horizontal: true,
					distributed: true
				}
			},
			colors: barColors,
			dataLabels: {
				enabled: false
			},
			xaxis: {
				categories: ['Pendente', 'Aguarda Avaliação', 'A Agendar', 'Agendado', 'Inválido', 'Cancelado'],
			}
		};

		var chart = new ApexCharts(document.querySelector("#kt_apexcharts_2"), options);
		chart.render();
	</script>
</body>