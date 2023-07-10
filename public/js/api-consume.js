async function sendRequest(document, token) {
    var success = document.getElementById("success");
    var form = document.getElementById("form-id");
    var pass = document.getElementById("password");
    var confirmPass = document.getElementById("confirm_password");
    if (pass.value != confirmPass.value) {
        alert("Password dan konfirmasi password tidak sama!");
        return false;
    }
    await fetch("/api/reset-password", {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
        },
        body: JSON.stringify({
            token: token,
            password: pass.value,
        }),
    })
        .then((response) => {
            console.log(response);
            return response.json();
        })
        .then((data) => {
            console.log(data);
            success.classList.toggle("hidden");
            if (form) form.classList.toggle("hidden");
        })
        .catch((error) => {
            console.log(error);
            alert(error.message);
        });
}
