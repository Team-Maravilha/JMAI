function handleLogin(event) {
  event.preventDefault();

  var form = document.getElementById("login-form");
  const formData = new FormData();

  formData.append("action", "login");
  formData.append("email", form.email.value);
  formData.append("palavra_passe", form.palavra_passe.value);

  const requestOptions = {
    method: "POST",
    body: formData,
  };

  fetch("../../api/auth.php", requestOptions)
    .then((response) => response.json())
    .then((data) => {
      if (data.status === "success") {
        toastr.success(data.messages[0], "Sucesso!");
        setTimeout(() => {
          window.location.href = data.redirect;
        }, 1000);
      } else {
        toastr.error(data.messages[0], "Erro!");
      }
    })
    .catch((error) => {
      toastr.error(error, "Erro!");
    });
}
