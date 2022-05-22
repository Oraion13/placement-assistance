const logout = document.getElementById("logout");

logout.addEventListener("click", logout_form);

function logout_form() {
    console.log("hel");

    const xhr = new XMLHttpRequest();
    xhr.open("GET", "../../api/login/logout.php", true);

    xhr.onreadystatechange = function() {
        if (xhr.readyState == XMLHttpRequest.DONE) {
            const got = JSON.parse(xhr.responseText);

            if (got.error) {
                window.alert(got.error);
            } else {
                console.log(got);
                window.location.replace("./index.php");
            }
        }
    };
    xhr.send();
}