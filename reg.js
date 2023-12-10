const container = document.querySelector(".container"),
    pwShowHide = document.querySelectorAll(".showHidePw"),
    pwFields = document.querySelectorAll(".password"),
    signUp = document.querySelector(".signup-link"),
    login = document.querySelector(".login-link");
document.getElementById('login-btn').addEventListener('click', login_user)
var validEmail = /^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/;

pwShowHide.forEach(eyeIcon => {
    eyeIcon.addEventListener("click", () => {
        pwFields.forEach(pwField => {
            if (pwField.type === "password") {
                pwField.type = "text";

                pwShowHide.forEach(icon => {
                    icon.classList.replace("uil-eye-slash", "uil-eye");
                })
            } else {
                pwField.type = "password";

                pwShowHide.forEach(icon => {
                    icon.classList.replace("uil-eye", "uil-eye-slash");
                })
            }
        })
    })
})

signUp.addEventListener("click", () => {
    container.classList.add("active");
    document.getElementById('signup-btn').addEventListener('click', register)
});
login.addEventListener("click", () => {
    container.classList.remove("active");
    document.getElementById('login-btn').addEventListener('click', login_user)
});
function register() {
    const email = document.getElementById("s-email").value
    const name = document.getElementById("s-name").value
    const password1 = document.getElementById("password1").value
    const password2 = document.getElementById("password2").value
    if (isValidDetail(name, email, password1, password2)) {
        var formData = new FormData();
        formData.append("name", name)
        formData.append("email", email)
        formData.append("password", password1)
        var xhr = new XMLHttpRequest();
        xhr.open("POST", "register.php", true);

        xhr.onreadystatechange = function () {
            if (xhr.readyState == 4 && xhr.status == 200) {
                var res = xhr.responseText;
                console.log(res)
                if (res.trim() == "success") {
                    console.log(res)
                    window.location = "profile.php"
                }
                if (res.trim() == "exist") {
                    alert("The email you have entered already exist ")

                }
            }
        }
        xhr.send(formData);
    }
}
function login_user() {
    const email = document.getElementById("l-email").value
    const password = document.getElementById("l-password").value
    if (isValidLog(email, password)) {
        var formData = new FormData();
        formData.append("email", email)
        formData.append("password", password)
        var xhr = new XMLHttpRequest();
        xhr.open("POST", "login.php", true);

        xhr.onreadystatechange = function () {
            if (xhr.readyState == 4 && xhr.status == 200) {
                var res = xhr.responseText;
                console.log(res)
                if (res.trim() == "success") {
                    window.location = "profile.php";
                }
                if (res.trim() == "fail") {
                    alert("Details did not match, try again")
                }
            }
        }
        xhr.send(formData);
    }
}
function isValidDetail(name, email, password1, password2) {
    if (name == "") {
        alert("Please enter your name")
        return false;
    }
    if (!email.match(validEmail)) {
        alert("Please enter a valid email")
        return false;
    }

    if (password1 == "" || password2 == "") {
        alert("Password is required")
        return false;
    }
    if (password1 != password2) {
        alert("passwords did not match")
        return false;
    }
    return true;

}
function isValidLog(email, password) {
    if (!email.match(validEmail)) {
        alert("Please enter a valid email")
        return false;
    }
    if (password == "") {
        alert("Password is required")
        return false;
    }
    return true
}