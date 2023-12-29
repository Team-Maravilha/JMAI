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
// 


/**
 * Date Range PickerS
 */

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

/**
 * Render Charts
 */

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
			console.log(dados);
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

/**
 * Get Data
 */

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
