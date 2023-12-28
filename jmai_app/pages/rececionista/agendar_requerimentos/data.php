<?php
function isWeekend($date)
{
	$weekend = (intval(date("w", strtotime($date))) === 0 || intval(date("w", strtotime($date))) === 6);
	$weekend_numeric = intval(date("w", strtotime($date)));

	if ($weekend)
		return ["status" => $weekend, "numeric" => $weekend_numeric, "default_date" => $date];
	return false;
}

require $_SERVER["DOCUMENT_ROOT"] . "/api/api.php";
$api = new Api();

if (isset($_SERVER["REQUEST_METHOD"])) {
	switch ($_SERVER["REQUEST_METHOD"]) {
		case "GET":
			if (!isset($_GET["action"]))
				break;

			switch ($_GET["action"]) {
			
				default:
					echo "Método não existe";
					break;
			}

			break;
		case "POST":
			if (!isset($_POST["action"])) {
				echo "Ação não existe";
				break;
			}

			switch ($_POST["action"]) {
				case "holidays":
					$start = isset($_POST["start"]) && !empty(trim($_POST["start"])) ? trim($_POST["start"]) : date('Y');

					$api_url = "https://date.nager.at/api/v3/publicholidays/" . date('Y', strtotime($start)) . "/PT";
					$api_content = json_decode(file_get_contents($api_url));

					$response = [];
					foreach ($api_content as $key => $holiday) {
						if (isset($holiday->counties)) continue;
						$response[] = [
							"title" => $holiday->localName,
							"start" => $holiday->date,
							"color" => "rgba(246, 202, 131, 0.5)",
							"display" => "background"
						];
					}

					echo json_encode($response);
					break;
				case "agendamentos":
					$start = isset($_POST["start"]) && !empty(trim($_POST["start"])) ? trim($_POST["start"]) : null;
					$end = isset($_POST["end"]) && !empty(trim($_POST["end"])) ? trim($_POST["end"]) : null;

                    $start = date("d/m/Y", strtotime($start));
                    $end = date("d/m/Y", strtotime($end));
					
                    $path = 'requerimentos/consultas/listar';
                    $consultas_agendadas = $api->fetch($path, ["data_inicio" => $start, "data_fim" => $end]);

                    if($consultas_agendadas["status"]){
                        $consultas_agendadas_raw = $consultas_agendadas["response"]["data"];

                        $consultas_agendadas = [];

                        foreach($consultas_agendadas_raw as $key => $consulta){
                            $utente = $consulta["utente"];
                            $equipa_medica = $consulta["equipa_medica"];

                            $data_inicio = date("Y-m-d", strtotime(str_replace('/', '-', $consulta["data_agendamento"])));
                            $data_inicio = $data_inicio . 'T' . $consulta["hora_agendamento"];

                            $data_fim = date("Y-m-d", strtotime(str_replace('/', '-', $consulta["data_fim_agendamento"])));
                            $data_fim = $data_fim . 'T' . $consulta["hora_fim_agendamento"];

                            $consultas_agendadas[] = [
                                "id" => $consulta["hashed_id"],
                                "title" => "Consulta de Junta Médica - " . $utente["nome"] . " - " . $utente["numero_utente"],
                                "start" => $data_inicio,
                                "end" => $data_fim,
                                "className" => "bg-primary",
                                "extendedProps" => [
                                    "utente" => $utente,
                                    "equipa_medica" => $equipa_medica,
                                    "event_type" => "agendamento",
									"requerimento" => [
										'tipo_requerimento' => $consulta['texto_tipo_requerimento'],
									]
                                ],
                            ];
                        }

                    }else{
                        $consultas_agendadas = [];
                    }

                    echo json_encode($consultas_agendadas);
					break;
                default:
                    echo "Método não existe";
                    break;
			}

			break;

		default:
			// throw new Exception("Método não suportado . ");
			echo json_encode("Método não suportado . ");
			break;
	}
}