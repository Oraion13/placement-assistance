const admin_name = document.getElementById("admin_name");
const password = document.getElementById("password");
const login_form = document.getElementById("login_form");

login_form.addEventListener("submit", submit_login);

function submit_login(e) {
    e.preventDefault();

    if (!admin_name.value || !password.value) {
        window.alert("please fill all the fields");
        return;
    }

    const login = {
        admin_name: admin_name.value,
        password: password.value,
    };

    const xhr = new XMLHttpRequest();
    xhr.open("POST", "../../api/login/login.php", true);

    xhr.onreadystatechange = function() {
        if (xhr.readyState == XMLHttpRequest.DONE) {
            const got = JSON.parse(xhr.responseText);

            if (got.error) {
                window.alert(got.error);
            } else {
                console.log(got);
                window.location.replace("./home.php");
            }
        }
    };
    xhr.send(JSON.stringify(login));
}