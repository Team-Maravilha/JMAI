const inputPais = $('[name="pais"]'); // ? Input Paises Naturalidade
const inputDistrito = $('[name="distrito_naturalidade"]'); // ? Input Distritos Naturalidade
const inputConcelho = $('[name="concelho_naturalidade"]'); // ? Input Concelhos Naturalidade
const inputFreguesia = $('[name="freguesia_naturalidade"]'); // ? Input Freguesias Naturalidade

const inputDistrito1 = $('[name="distrito_residencia"]'); // ? Input Distritos Naturalidade
const inputConcelho1 = $('[name="concelho_residencia"]'); // ? Input Concelhos Naturalidade
const inputFreguesia1 = $('[name="freguesia_residencia"]'); // ? Input Freguesias Naturalidade

const carregarPaisesNaturalidade = async () => {
  fetch(`${api_base_url}geo/paises/lista?${new URLSearchParams({})}`, {
    method: "GET",
    headers: {
      "Content-Type": "application/json",
      Authorization: token,
    },
  })
    .then((response) => response.json())
    .then((data) => {
      if (data.status === "error") {
        toastr.error(data.messages[0]);
      } else if (data.status === "success") {
        data.data.forEach((pais) => {
          let option = document.createElement("option");
          option.value = pais.id_pais;
          option.text = pais.nome;
          $(inputPais).append(option);
        });
        //REINICIALIZAR SELECT2
        $(inputPais).select2();
      }
    });
};

const carregarDistritosNaturalidade = async (id_pais) => {
  fetch(`${api_base_url}geo/paises/${id_pais}/distritos/lista?${new URLSearchParams()}`, {
    method: "GET",
    headers: {
      "Content-Type": "application/json",
      Authorization: token,
    },
  })
    .then((response) => response.json())
    .then((data) => {
      if (data.status === "error") {
        toastr.error(data.messages[0]);
      } else if (data.status === "success") {
        data.data.forEach((distrito) => {
          let option = document.createElement("option");
          option.value = distrito.id_distrito;
          option.text = distrito.nome;
          $(inputDistrito).append(option);
        });
        //REINICIALIZAR SELECT2
        $(inputDistrito).select2();
      }
    });
};

const carregarConcelhosNaturalidade = async (id_distrito) => {
  fetch(`${api_base_url}geo/distritos/${id_distrito}/concelhos/lista?${new URLSearchParams()}`, {
    method: "GET",
    headers: {
      "Content-Type": "application/json",
      Authorization: token,
    },
  })
    .then((response) => response.json())
    .then((data) => {
      if (data.status === "error") {
        toastr.error(data.messages[0]);
      } else if (data.status === "success") {
        data.data.forEach((concelho) => {
          let option = document.createElement("option");
          option.value = concelho.id_concelho;
          option.text = concelho.nome;
          $(inputConcelho).append(option);
        });
        //REINICIALIZAR SELECT2
        $(inputConcelho).select2();
      }
    });
};

const carregarFreguesiasNaturalidade = async (id_concelho) => {
  fetch(`${api_base_url}geo/concelhos/${id_concelho}/freguesias/lista?${new URLSearchParams()}`, {
    method: "GET",
    headers: {
      "Content-Type": "application/json",
      Authorization: token,
    },
  })
    .then((response) => response.json())
    .then((data) => {
      if (data.status === "error") {
        toastr.error(data.messages[0]);
      } else if (data.status === "success") {
        data.data.forEach((freguesia) => {
          let option = document.createElement("option");
          option.value = freguesia.id_freguesia;
          option.text = freguesia.nome;
          $(inputFreguesia).append(option);
        });
        //REINICIALIZAR SELECT2
        $(inputFreguesia).select2();
      }
    });
};

const carregarDistritosResidencia = async (id_pais) => {
  fetch(`${api_base_url}geo/paises/${id_pais}/distritos/lista?${new URLSearchParams()}`, {
    method: "GET",
    headers: {
      "Content-Type": "application/json",
      Authorization: token,
    },
  })
    .then((response) => response.json())
    .then((data) => {
      if (data.status === "error") {
        toastr.error(data.messages[0]);
      } else if (data.status === "success") {
        data.data.forEach((distrito) => {
          let option = document.createElement("option");
          option.value = distrito.id_distrito;
          option.text = distrito.nome;
          $(inputDistrito1).append(option);
        });
        //REINICIALIZAR SELECT2
        $(inputDistrito1).select2();
      }
    });
};

const carregarConcelhosResidencia = async (id_distrito) => {
  fetch(`${api_base_url}geo/distritos/${id_distrito}/concelhos/lista?${new URLSearchParams()}`, {
    method: "GET",
    headers: {
      "Content-Type": "application/json",
      Authorization: token,
    },
  })
    .then((response) => response.json())
    .then((data) => {
      if (data.status === "error") {
        toastr.error(data.messages[0]);
      } else if (data.status === "success") {
        data.data.forEach((concelho) => {
          let option = document.createElement("option");
          option.value = concelho.id_concelho;
          option.text = concelho.nome;
          $(inputConcelho1).append(option);
        });
        //REINICIALIZAR SELECT2
        $(inputConcelho1).select2();
      }
    });
};

const carregarFreguesiasResidencia = async (id_concelho) => {
  fetch(`${api_base_url}geo/concelhos/${id_concelho}/freguesias/lista?${new URLSearchParams()}`, {
    method: "GET",
    headers: {
      "Content-Type": "application/json",
      Authorization: token,
    },
  })
    .then((response) => response.json())
    .then((data) => {
      if (data.status === "error") {
        toastr.error(data.messages[0]);
      } else if (data.status === "success") {
        data.data.forEach((freguesia) => {
          let option = document.createElement("option");
          option.value = freguesia.id_freguesia;
          option.text = freguesia.nome;
          $(inputFreguesia1).append(option);
        });
        //REINICIALIZAR SELECT2
        $(inputFreguesia1).select2();
      }
    });
};

window.addEventListener("DOMContentLoaded", () => {
  carregarPaisesNaturalidade();
  $(inputPais).change(function () {
    $(inputDistrito).empty();
    $(inputDistrito).append("<option></option>");
    $(inputConcelho).empty();
    $(inputConcelho).append("<option></option>");
    $(inputFreguesia).empty();
    $(inputFreguesia).append("<option></option>");
    carregarDistritosNaturalidade($(this).val());
  });
  $(inputDistrito).change(function () {
    $(inputConcelho).empty();
    $(inputConcelho).append("<option></option>");
    $(inputFreguesia).empty();
    $(inputFreguesia).append("<option></option>");
    carregarConcelhosNaturalidade($(this).val());
  });
  $(inputConcelho).change(function () {
    $(inputFreguesia).empty();
    $(inputFreguesia).append("<option></option>");
    carregarFreguesiasNaturalidade($(this).val());
  });

  carregarDistritosResidencia(2);
  $(inputDistrito1).change(function () {
    $(inputConcelho1).empty();
    $(inputConcelho1).append("<option></option>");
    $(inputFreguesia1).empty();
    $(inputFreguesia1).append("<option></option>");
    carregarConcelhosResidencia($(this).val());
  });
  $(inputConcelho1).change(function () {
    $(inputFreguesia1).empty();
    $(inputFreguesia1).append("<option></option>");
    carregarFreguesiasResidencia($(this).val());
  });
});
