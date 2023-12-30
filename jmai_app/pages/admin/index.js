const colorsPastel = [
	"#FFD1DC",
	"#FFABAB",
	"#FFC3A0",
	"#FF677D",
	"#D4A5A5",
	"#392F5A",
	"#31A2AC",
	"#61C0BF",
	"#6B4226",
	"#D9BF77",
	"#ACD8AA",
	"#FFE156",
	"#6A0572",
	"#AB83A1",
	"#F15BB5",
	"#F7A399",
	"#1A1B41",
	"#6B4226",
	"#D9BF77",
	"#ACD8AA",
	"#FFE156",
	"#6A0572",
	"#AB83A1",
	"#F15BB5",
	"#F7A399",
	"#5BBA6F",
	"#F0C987",
	"#B3C2CF",
	"#A3D2CA",
	"#B3CC57",
	"#FFFF7E",
	"#7FFF00",
	"#66FF66",
	"#98FB98",
	"#2E8B57",
	"#E6A8D7",
	"#F091A9",
	"#FF92A0",
	"#FFADA7",
	"#FFC3A0",
	"#B2FEFA",
	"#6DECAF",
	"#E9D985",
	"#F0C987",
	"#DBD4D3",
	"#DCB0AB",
	"#DD7596",
	"#7A9E7E",
	"#7389AE",
	"#AAA1C8",
	"#A8DADC",
	"#79A3B1",
	"#4A6D7C",
	"#2660A4",
	"#1A5E63",
];
const labelColor = "#6E6E6E";
moment.locale("pt");

/**
 * Charts
 */

//Chart Requerimentos por Distrito
const dateRangeSelectorRequerimentosDistrito = document.getElementById(
	"date_range_picker_requerimentos_distrito"
);
const startRequerimentosDistrito = moment().startOf("year");
const todayRequerimentosDistrito = moment();
let chartRequerimentosDistrito = {
	self: null,
	rendered: false,
};
let chartElementRequerimentosDistrito = document.getElementById(
	"chart_requerimentos_distrito"
);
let blockUIRequerimentosDistrito = new KTBlockUI(
	chartElementRequerimentosDistrito,
	{
		message: '<div class="blockui-message bg-white"><span class="spinner-border text-primary"></span>A Carregar Dados...</div>',
	}
);

//Chart Requerimentos por Periodo
const dateRangeSelectorRequerimentosPeriodo = document.getElementById(
	"date_range_picker_requerimentos_periodo"
);
const startRequerimentosPeriodo = moment().startOf("year");
const todayRequerimentosPeriodo = moment();
let chartRequerimentosPeriodo = {
	self: null,
	rendered: false,
};
let chartElementRequerimentosPeriodo = document.getElementById(
	"chart_requerimentos_periodo"
);
let blockUIRequerimentosPeriodo = new KTBlockUI(
	chartElementRequerimentosPeriodo,
	{
		message: '<div class="blockui-message bg-white"><span class="spinner-border text-primary"></span>A Carregar Dados...</div>',
	}
);

//Chart Requerimentos por Estado
let chartRequerimentosEstado = {
	self: null,
	rendered: false,
};
let chartElementRequerimentosEstado = document.getElementById(
	"chart_requerimentos_estado"
);
let blockUIRequerimentosEstado = new KTBlockUI(
	chartElementRequerimentosEstado,
	{
		message: '<div class="blockui-message bg-white"><span class="spinner-border text-primary"></span>A Carregar Dados...</div>',
	}
);

//Chart Requerimentos por Mes Anual
let chartRequerimentosMesAnual = {
	self: null,
	rendered: false,
};
let chartElementRequerimentosMesAnual = document.getElementById(
	"chart_evolucao_requerimentos_ano"
);
let blockUIRequerimentosMesAnual = new KTBlockUI(
	chartElementRequerimentosMesAnual,
	{
		message: '<div class="blockui-message bg-white"><span class="spinner-border text-primary"></span>A Carregar Dados...</div>',
	}
);

/**
 * Date Range PickerS
 */
//Chart Requerimentos por Distrito
$(dateRangeSelectorRequerimentosDistrito).daterangepicker(
	{
		startDate: startRequerimentosDistrito,
		endDate: todayRequerimentosDistrito,
		ranges: {
			Hoje: [moment(), moment()],
			Ontem: [
				moment().subtract(1, "days"),
				moment().subtract(1, "days"),
			],
			"Ultimos 7 Dias": [moment().subtract(6, "days"), moment()],
			"Este Mês": [moment().startOf("month"), moment()],
			"Mês Passado": [
				moment().subtract(1, "month").startOf("month"),
				moment().subtract(1, "month").endOf("month"),
			],
			"Este Ano": [moment().startOf("year"), moment()],
		},
		locale: {
			format: "DD/MM/YYYY",
			separator: " - ",
			applyLabel: "Aplicar",
			cancelLabel: "Cancelar",
			fromLabel: "De",
			toLabel: "Até",
			customRangeLabel: "Personalizado",
			daysOfWeek: ["Dom", "Seg", "Ter", "Qua", "Qui", "Sex", "Sáb"],
			monthNames: [
				"Janeiro",
				"Fevereiro",
				"Março",
				"Abril",
				"Maio",
				"Junho",
				"Julho",
				"Agosto",
				"Setembro",
				"Outubro",
				"Novembro",
				"Dezembro",
			],
			firstDay: 1,
		},
	},
	GetDataRequerimentosDistrito
);

//Chart Requerimentos por Periodo
$(dateRangeSelectorRequerimentosPeriodo).daterangepicker(
	{
		startDate: startRequerimentosPeriodo,
		endDate: todayRequerimentosPeriodo,
		ranges: {
			Hoje: [moment(), moment()],
			Ontem: [
				moment().subtract(1, "days"),
				moment().subtract(1, "days"),
			],
			"Ultimos 7 Dias": [moment().subtract(6, "days"), moment()],
			"Este Mês": [moment().startOf("month"), moment()],
			"Mês Passado": [
				moment().subtract(1, "month").startOf("month"),
				moment().subtract(1, "month").endOf("month"),
			],
			"Este Ano": [moment().startOf("year"), moment()],
		},
		locale: {
			format: "DD/MM/YYYY",
			separator: " - ",
			applyLabel: "Aplicar",
			cancelLabel: "Cancelar",
			fromLabel: "De",
			toLabel: "Até",
			customRangeLabel: "Personalizado",
			daysOfWeek: ["Dom", "Seg", "Ter", "Qua", "Qui", "Sex", "Sáb"],
			monthNames: [
				"Janeiro",
				"Fevereiro",
				"Março",
				"Abril",
				"Maio",
				"Junho",
				"Julho",
				"Agosto",
				"Setembro",
				"Outubro",
				"Novembro",
				"Dezembro",
			],
			firstDay: 1,
		},
	},
	GetDataRequerimentosPeriodo
);

/**
 * Render Charts
 */
//Chart Requerimentos por Distrito
const renderChartRequerimentosDistrito = (start, end) => {
	const GatherData = async () => {
		try {
			let response = await fetch(
				`${api_base_url}graficos/requerimentos_por_distrito?id_pais=2&data_inicio=${start}&data_fim=${end}`,
				{
					method: "GET",
					headers: {
						"Content-Type": "application/json",
						Authorization: token,
					},
				}
			);
			let dados = await response.json();
			if (dados.status == "success") {
				let labels = [];
				let series = [];
				dados.data.forEach((item) => {
					labels.push(item.nome_distrito);
					series.push(parseInt(item.total_requerimentos));
				});
				return {
					status: "success",
					data: {
						labels,
						series,
					},
					messages: [
						"Lista de Requerimentos por Distrito obtida com sucesso",
					],
				};
			} else {
				return {
					status: "error",
					data: null,
					messages: [dados.messages],
				};
			}
		} catch (err) {
			return {
				status: "error",
				data: null,
				messages: [err.message],
			};
		}
	};

	const loadChart = async () => {
		if (!chartElementRequerimentosDistrito) return;

		if (chartRequerimentosDistrito.rendered) {
			chartRequerimentosDistrito.self.destroy();
			chartRequerimentosDistrito.rendered = false;
		}

		blockUIRequerimentosDistrito.block();

		try {
			let dados = await GatherData();
			if (dados.status == "success") {
				let options = {
					series: [
						{
							name: "Nº de Requerimentos",
							data: dados.data.series,
						},
					],
					chart: {
						fontFamily: "inherit",
						type: "bar",
						height: 350,
						toolbar: {
							show: true,
							offsetX: 0,
							offsetY: 0,
							tools: {
								download: true,
								selection: true,
								zoom: true,
								zoomin: true,
								zoomout: true,
								pan: true,
								reset:
									true |
									'<img src="/static/icons/reset.png" width="20">',
								customIcons: [],
							},
							export: {
								csv: {
									filename:
										"Requerimentos por Distrito",
									columnDelimiter: ",",
									headerCategory: "Distrito",
									headerValue: "value",
									dateFormatter(timestamp) {
										return new Date(
											timestamp
										).toDateString();
									},
								},
								svg: {
									filename:
										"Requerimentos por Distrito",
								},
								png: {
									filename:
										"Requerimentos por Distrito",
								},
							},
						},
					},
					plotOptions: {
						bar: {
							horizontal: false,
							columnWidth: ["30%"],
							borderRadius: 6,
							endingShape: "rounded",
							distributed: true,
						},
					},

					legend: {
						show: false,
					},
					dataLabels: {
						enabled: false,
					},
					stroke: {
						show: true,
						width: 2,
						colors: ["transparent"],
					},
					xaxis: {
						categories: dados.data.labels,
						axisBorder: {
							show: false,
						},
						axisTicks: {
							show: false,
						},
						labels: {
							style: {
								colors: labelColor,
								fontSize: "12px",
							},
						},
					},
					yaxis: {
						labels: {
							style: {
								colors: labelColor,
								fontSize: "12px",
							},
							formatter: function (val) {
								return Math.floor(val);
							},
						},
					},
					fill: {
						opacity: 1,
					},
					states: {
						normal: {
							filter: {
								type: "none",
								value: 0,
							},
						},
						hover: {
							filter: {
								type: "none",
								value: 0,
							},
						},
						active: {
							allowMultipleDataPointsSelection: false,
							filter: {
								type: "none",
								value: 0,
							},
						},
					},
					tooltip: {
						style: {
							fontSize: "12px",
						},
						y: {
							formatter: function (val) {
								return val;
							},
						},
						x: {
							show: true,
						},
					},
					colors: colorsPastel,
					grid: {
						borderColor: "#d7d7e7",
						strokeDashArray: 4,
						yaxis: {
							lines: {
								show: true,
							},
						},
					},
				};

				chartRequerimentosDistrito.self = new ApexCharts(
					chartElementRequerimentosDistrito,
					options
				);

				setTimeout(() => {
					chartRequerimentosDistrito.self.render();
					chartRequerimentosDistrito.rendered = true;
					blockUIRequerimentosDistrito.release();
				}, 1000);
			} else {
				toastr.error(
					"Erro ao obter dados para o gráfico de Requerimentos por Distrito"
				);
			}
		} catch (err) {
			console.log(err.message);
		}
	};

	return {
		init: async () => {
			await loadChart();

			KTThemeMode.on("kt.thememode.change", function () {
				if (chartRequerimentosDistrito.rendered) {
					chartRequerimentosDistrito.self.destroy();
				}
				loadChart();
			});
		},
	};
};

//Chart Requerimentos por Periodo
const renderChartRequerimentosPeriodo = (start, end) => {
	const GatherData = async () => {
		try {
			let response = await fetch(
				`${api_base_url}graficos/requerimentos_por_periodo?data_inicio=${start}&data_fim=${end}`,
				{
					method: "GET",
					headers: {
						"Content-Type": "application/json",
						Authorization: token,
					},
				}
			);
			let dados = await response.json();
			if (dados.status == "success") {
				let categories = [];
				let series = [];

				dados.data.forEach((item) => {
					categories.push(item.texto_periodo);
					series.push(parseInt(item.total_requerimentos));
				});

				return {
					status: "success",
					data: {
						labels: categories,
						series,
					},
					messages: [
						"Lista de Requerimentos por Periodo obtida com sucesso",
					],
				};
			} else {
				return {
					status: "error",
					data: null,
					messages: [dados.messages],
				};
			}
		} catch (err) {
			return {
				status: "error",
				data: null,
				messages: [err.message],
			};
		}
	};

	const loadChart = async () => {
		if (!chartElementRequerimentosPeriodo) return;

		if (chartRequerimentosPeriodo.rendered) {
			chartRequerimentosPeriodo.self.destroy();
			chartRequerimentosPeriodo.rendered = false;
		}

		blockUIRequerimentosPeriodo.block();

		try {
			let dados = await GatherData();
			if (dados.status == "success") {
				let options = {
					series: [
						{
							name: "Nº de Requerimentos",
							data: dados.data.series,
						},
					],
					chart: {
						fontFamily: "inherit",
						type: "bar",
						height: 350,
						toolbar: {
							show: true,
							offsetX: 0,
							offsetY: 0,
							tools: {
								download: true,
								selection: true,
								zoom: true,
								zoomin: true,
								zoomout: true,
								pan: true,
								reset:
									true |
									'<img src="/static/icons/reset.png" width="20">',
								customIcons: [],
							},
							export: {
								csv: {
									filename:
										"Requerimentos por Periodo",
									columnDelimiter: ",",
									headerCategory: "Periodo",
									headerValue: "value",
									dateFormatter(timestamp) {
										return new Date(
											timestamp
										).toDateString();
									},
								},
								svg: {
									filename:
										"Requerimentos por Periodo",
								},
								png: {
									filename:
										"Requerimentos por Periodo",
								},
							},
						},
					},
					plotOptions: {
						bar: {
							horizontal: false,
							columnWidth: ["30%"],
							borderRadius: 6,
							endingShape: "rounded",
							distributed: true,
						},
					},
					legend: {
						show: false,
					},
					dataLabels: {
						enabled: false,
					},
					xaxis: {
						categories: dados.data.labels,
						axisBorder: {
							show: false,
						},
						axisTicks: {
							show: true,
						},
						labels: {
							style: {
								colors: labelColor,
								fontSize: "12px",
								margin: 10,

							},
						},
					},
					yaxis: {
						labels: {
							style: {
								colors: labelColor,
								fontSize: "12px",
							},
							formatter: function (val) {
								return Math.floor(val);
							},
						},
					},
					fill: {
						opacity: 1,
					},
					states: {
						normal: {
							filter: {
								type: "none",
								value: 0,
							},
						},
						hover: {
							filter: {
								type: "none",
								value: 0,
							},
						},
						active: {
							allowMultipleDataPointsSelection: false,
							filter: {
								type: "none",
								value: 0,
							},
						},
					},
					tooltip: {
						style: {
							fontSize: "12px",
						},
						y: {
							formatter: function (val) {
								return val;
							},
						},
						x: {
							show: true,
						},
					},
					colors: colorsPastel,
					grid: {
						borderColor: "#d7d7e7",
						strokeDashArray: 4,
						yaxis: {
							lines: {
								show: true,
							},
						},
					},
				};

				chartRequerimentosPeriodo.self = new ApexCharts(
					chartElementRequerimentosPeriodo,
					options
				);

				setTimeout(() => {
					chartRequerimentosPeriodo.self.render();
					chartRequerimentosPeriodo.rendered = true;
					blockUIRequerimentosPeriodo.release();
				}, 1000);
			} else {
				toastr.error(
					"Erro ao obter dados para o gráfico de Requerimentos por Periodo"
				);
			}
		} catch (err) {
			console.log(err.message);
		}
	};

	return {
		init: async () => {
			await loadChart();

			KTThemeMode.on("kt.thememode.change", function () {
				if (chartRequerimentosPeriodo.rendered) {
					chartRequerimentosPeriodo.self.destroy();
				}
				loadChart();
			});
		},
	};
};

//Chart Requerimentos por Estado
const renderChartRequerimentosEstado = () => {
	const GatherData = async () => {
		try {
			let response = await fetch(
				`${api_base_url}graficos/requerimentos_por_estado`,
				{
					method: "GET",
					headers: {
						"Content-Type": "application/json",
						Authorization: token,
					},
				}
			);
			let dados = await response.json();
			if (dados.status == "success") {
				let total = 0;
				dados.data.forEach((item) => {
					total += parseInt(item.total_requerimentos);
				});
				let data = [];
				dados.data.forEach((item, index) => {
					data.push({
						category: item.texto_estado,
						value: item.total_requerimentos,
						full: total,
						columnSettings: {
							fillOpacity: 1,
							fill: am5.color(colorsPastel[index]),
						},
					});
				});

				return {
					status: "success",
					data: {
						data,
						total,
					},
					messages: [
						"Lista de Requerimentos por Estado obtida com sucesso",
					],
				};
			} else {
				return {
					status: "error",
					data: null,
					messages: [dados.messages],
				};
			}
		} catch (err) {
			return {
				status: "error",
				data: null,
				messages: [err.message],
			};
		}
	};

	const loadChart = async () => {
		if (!chartElementRequerimentosEstado) return;

		if (chartRequerimentosPeriodo.rendered) {
			chartRequerimentosPeriodo.self.destroy();
			chartRequerimentosPeriodo.rendered = false;
		}

		blockUIRequerimentosEstado.block();

		try {
			let dados = await GatherData();
			if (dados.status == "success") {
				let data = dados.data.data;
				let total = dados.data.total;
				chartRequerimentosEstado.self = am5.Root.new(
					chartElementRequerimentosEstado
				);
				chartRequerimentosEstado.self.setThemes([
					am5themes_Animated.new(chartRequerimentosEstado.self),
				]);

				let chart = chartRequerimentosEstado.self;
				chartRequerimentosEstado.self =
					chart.container.children.push(
						am5radar.RadarChart.new(chart, {
							panX: false,
							panY: false,
							wheelX: "panX",
							wheelY: "zoomX",
							innerRadius: am5.percent(20),
							startAngle: -90,
							endAngle: 180,
						})
					);

				var cursor = chartRequerimentosEstado.self.set(
					"cursor",
					am5radar.RadarCursor.new(chart, {
						
					})
				);

				cursor.lineY.set("visible", false);

				var xRenderer = am5radar.AxisRendererCircular.new(chart, {
					//minGridDistance: 50
				});

				xRenderer.labels.template.setAll({
					radius: 10,
				});

				xRenderer.grid.template.setAll({
					forceHidden: true,
				});

				var xAxis = chartRequerimentosEstado.self.xAxes.push(
					am5xy.ValueAxis.new(chart, {
						renderer: xRenderer,
						min: 0,
						max: total,
						strictMinMax: true,
						numberFormat: "#",
						tooltip: am5.Tooltip.new(chart, {}),
					})
				);

				var yRenderer = am5radar.AxisRendererRadial.new(chart, {
					minGridDistance: 14,
				});

				yRenderer.labels.template.setAll({
					centerX: am5.p100,
					fontWeight: "500",
					fontSize: 12,
					fill: am5.color(
						KTUtil.getCssVariableValue("--bs-gray-500")
					),
					templateField: "columnSettings",
				});

				var yAxis = chartRequerimentosEstado.self.yAxes.push(
					am5xy.CategoryAxis.new(chart, {
						categoryField: "category",
						renderer: yRenderer,
					})
				);

				// Create series
				// https://www.amcharts.com/docs/v5/charts/radar-chart/#Adding_series
				var series1 = chartRequerimentosEstado.self.series.push(
					am5radar.RadarColumnSeries.new(chart, {
						xAxis: xAxis,
						yAxis: yAxis,
						clustered: false,
						valueXField: "full",
						categoryYField: "category",
						fill: chart.interfaceColors.get(
							"alternativeBackground"
						),
					})
				);

				series1.columns.template.setAll({
					width: am5.p100,
					fillOpacity: 0.08,
					strokeOpacity: 0,
					cornerRadius: 20,
				});

				var series2 = chartRequerimentosEstado.self.series.push(
					am5radar.RadarColumnSeries.new(chart, {
						xAxis: xAxis,
						yAxis: yAxis,
						clustered: false,
						valueXField: "value",
						categoryYField: "category",
					})
				);

				series2.columns.template.setAll({
					width: am5.p100,
					strokeOpacity: 0,
					tooltipText: `{category}: {valueX} Requerimentos`,
					cornerRadius: 20,
					templateField: "columnSettings",
				});

				// https://www.amcharts.com/docs/v5/concepts/animations/#Initial_animation

				setTimeout(() => {
					yRenderer.grid.template.setAll({
						forceHidden: true,
					});
					yAxis.data.setAll(data);
					series1.data.setAll(data);
					series2.data.setAll(data);
					series1.appear(1000);
					series2.appear(1000);
					chartRequerimentosEstado.self.appear(1000, 100);
					chartRequerimentosEstado.rendered = true;
					blockUIRequerimentosEstado.release();
				}, 1000);
			} else {
				toastr.error(
					"Erro ao obter dados para o gráfico de Requerimentos por Estado"
				);
			}
		} catch (err) {
			console.log(err.message);
		}
	};

	return {
		init: async () => {
			await loadChart();

			KTThemeMode.on("kt.thememode.change", function () {
				if (chartRequerimentosEstado.rendered) {
					chartRequerimentosEstado.self.destroy();
				}
				loadChart();
			});
		},
	};
};
renderChartRequerimentosEstado().init();

//Chart Requerimentos por Mes Anual
const renderChartRequerimentosMesAnual = () => {
	const GatherData = async () => {
		try {
			let response = await fetch(
				`${api_base_url}graficos/requerimentos_por_mes_anual`,
				{
					method: "GET",
					headers: {
						"Content-Type": "application/json",
						Authorization: token,
					},
				}
			);
			let dados = await response.json();
			if (dados.status == "success") {
				let categories = [];
				let series = [];
				let innerSeries = [];

				dados.data.forEach((item, index) => {
					innerSeries = [];
					item.dados.forEach((mes) => {
						if (index == 0) {
							categories.push(mes.mes);
						}
						innerSeries.push(parseInt(mes.total_requerimentos));
					});
					series.push({
						name: item.periodo,
						data: innerSeries,
						color: colorsPastel[index],
					});
				});

				return {
					status: "success",
					data: {
						labels: categories,
						series,
					},
					messages: [
						"Lista de Requerimentos por Periodo obtida com sucesso",
					],
				};
			} else {
				return {
					status: "error",
					data: null,
					messages: [dados.messages],
				};
			}
		} catch (err) {
			return {
				status: "error",
				data: null,
				messages: [err.message],
			};
		}
	};

	const loadChart = async () => {
		if (!chartElementRequerimentosMesAnual) return;

		if (chartRequerimentosMesAnual.rendered) {
			chartRequerimentosMesAnual.self.destroy();
			chartRequerimentosMesAnual.rendered = false;
		}

		blockUIRequerimentosMesAnual.block();

		try {
			let dados = await GatherData();
			if (dados.status == "success") {
				let options = {
					series: dados.data.series,
					chart: {
						fontFamily: "inherit",
						type: "bar",
						height: 335,
						toolbar: {
							show: true,
							offsetX: 0,
							offsetY: 0,
							tools: {
								download: true,
								selection: true,
								zoom: true,
								zoomin: true,
								zoomout: true,
								pan: true,
								reset:
									true |
									'<img src="/static/icons/reset.png" width="20">',
								customIcons: [],
							},
							export: {
								csv: {
									filename:
										"Requerimentos por Mês Anual",
									columnDelimiter: ",",
									headerCategory: "Periodo",
									headerValue: "value",
									dateFormatter(timestamp) {
										return new Date(
											timestamp
										).toDateString();
									},
								},
								svg: {
									filename:
										"Requerimentos por Mês Anual",
								},
								png: {
									filename:
										"Requerimentos por Mês Anual",
								},
							},
						},
					},
					plotOptions: {
						bar: {
							horizontal: false,
							columnWidth: ["80%"],
							borderRadius: 5,
							dataLabels: {
								position: "top", // top, center, bottom
							},
							startingShape: "flat",
							endingShape: "rounded",
						},
					},
					legend: {
						show: true,
						position: "bottom",
						horizontalAlign: "center",
						fontSize: "13px",
						markers: {
							width: 15,
							height: 15,
							radius: 5
						},
						itemMargin: {
							horizontal: 10,
							vertical: 20
						}
					},
					dataLabels: {
						enabled: false,
						style: {
							fontSize: "13px",
							colors: [labelColor]
						},
					},
					stroke: {
						show: true,
						width: 2,
						colors: ["transparent"],
					},
					xaxis: {
						categories: dados.data.labels,
						axisBorder: {
							show: false,
						},
						axisTicks: {
							show: false,
						},
						labels: {
							style: {
								fontSize: "13px",
							},
						},
						crosshairs: {
							fill: {
								gradient: {
									opacityFrom: 0,
									opacityTo: 0,
								},
							},
						},
					},
					yaxis: {
						labels: {
							style: {
								fontSize: "13px",
							},
							formatter: function (val) {
								return Math.floor(val);
							},
						},
					},
					fill: {
						opacity: 1,
					},
					tooltip: {
						style: {
							fontSize: "12px",
						},
						y: {
							formatter: function (val) {
								return val;
							},
						},
						x: {
							show: true,
						},
					},
					colors: [colorsPastel[0]],
					grid: {
						borderColor: "#d7d7e7",
						strokeDashArray: 4,
						yaxis: {
							lines: {
								show: true,
							},
						},
					},
				};

				chartRequerimentosMesAnual.self = new ApexCharts(
					chartElementRequerimentosMesAnual,
					options
				);

				setTimeout(() => {
					chartRequerimentosMesAnual.self.render();
					chartRequerimentosMesAnual.rendered = true;
					blockUIRequerimentosMesAnual.release();
				}, 1000);
			} else {
				toastr.error(
					"Erro ao obter dados para o gráfico de Requerimentos por Mês Anual"
				);
			}
		} catch (err) {
			console.log(err.message);
		}
	};

	return {
		init: async () => {
			await loadChart();

			KTThemeMode.on("kt.thememode.change", function () {
				if (chartRequerimentosMesAnual.rendered) {
					chartRequerimentosMesAnual.self.destroy();
				}
				loadChart();
			});
		},
	};
};
renderChartRequerimentosMesAnual().init();

/**
 * Get Data
 */
//Chart Requerimentos por Distrito
function GetDataRequerimentosDistrito(start, end) {
	$(dateRangeSelectorRequerimentosDistrito).html(
		start.format("LL") +
			" - " +
			end.format("LL") +
			`<i class="ki-duotone ki-calendar-search fs-1 ms-2 me-0">
                <span class="path1"></span>
                <span class="path2"></span>
                <span class="path3"></span>
                <span class="path4"></span>
            </i>`
	);

	renderChartRequerimentosDistrito(
		start.format("YYYY-MM-DD"),
		end.format("YYYY-MM-DD")
	).init();
}
GetDataRequerimentosDistrito(
	startRequerimentosDistrito,
	todayRequerimentosDistrito
);

//Chart Requerimentos por Periodo
function GetDataRequerimentosPeriodo(start, end) {
	$(dateRangeSelectorRequerimentosPeriodo).html(
		start.format("LL") +
			" - " +
			end.format("LL") +
			`<i class="ki-duotone ki-calendar-search fs-1 ms-2 me-0">
                <span class="path1"></span>
                <span class="path2"></span>
                <span class="path3"></span>
                <span class="path4"></span>
            </i>`
	);

	renderChartRequerimentosPeriodo(
		start.format("YYYY-MM-DD"),
		end.format("YYYY-MM-DD")
	).init();
}
GetDataRequerimentosPeriodo(
	startRequerimentosPeriodo,
	todayRequerimentosPeriodo
);
