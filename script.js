const lf = document.getElementById("login");
lf.addEventListener("submit", function (e) {
  e.preventDefault();
  fetch("login.php", {
    method: "POST",
    body: new FormData(e.target)
  })
    .then(resp => resp.json())
    .then(data => {
      console.log(data);
      if (data.status === "success") {
        window.location.href = data.redirect;
      } else {
        alert(data.message);
      }
    })
    .catch(err => {
      console.error('Erro:', err);
      alert('Erro na conexão com o servidor');
    });
});