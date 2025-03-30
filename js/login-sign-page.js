const loginForm = document.getElementById("login-form");
const loginButton = document.getElementById("login-form-submit");
const loginErrorMsg = document.getElementById("login-error-msg");

const signForm = document.getElementById("signup-form");
const signButton = document.getElementById("signup-form-submit");
const signupErrorMsg = document.getElementById("signup-error-msg");

const nomes = ["user"];
const pass = ["user"];
if (signButton){
    signButton.addEventListener("click", (e) => {
        e.preventDefault();
        const newname = signForm.newname.value;
        const newpass = signForm.newpass.value;
        if (newname === null || newpass === null){
            alert("Erro");
            signupErrorMsg.style.opacity = 1;
        }
        else if (nomes.includes(newname) || pass.includes(newpass)){
            alert("Username ou password não disponíveis.");
        } else if (newname !== null && newpass !== null){
            nomes.push(newname);
            pass.push(newpass);
            alert("Sign up com sucesso");
            location.href = "login.html";
        }
    })
}

if(loginButton){
    loginButton.addEventListener("click", (e) => {
        e.preventDefault();
        const username = loginForm.username.value;
        const password = loginForm.password.value;
        console.log(loginForm);
        if (nomes.includes(username) && pass.includes(password)) {
            alert("You have successfully logged in.");
            location.href="index.html";
        }
        else {
            alert("Erro");
            loginErrorMsg.style.opacity = 1;
        }
    })
}
