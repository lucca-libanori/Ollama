var cadast = document.getElementById("regist");
cadast.addEventListener("submit", function (e) {
    e.preventDefault();
    var data = new FormData(cadast);

    fetch("cadastro.php", {
        method: "POST",
        body: data
    })
        .then(res => res.text())
        .then(res => {
            console.log(res);
            alert(res);
            if (res.trim() === "certo") {
                window.location.href = "index.html";
            }
            cadast.reset();
        })
        .catch(error => {
            console.error('Erro na requisição:', error);
        });
});