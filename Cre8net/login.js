const formulario = document.getElementById("loginForm");

const email = document.getElementById("email");
const senha = document.getElementById("senha");

const erroEmail = document.getElementById("erroEmail");
const erroSenha = document.getElementById("erroSenha");


// Validação do e-mail enquanto digita
email.addEventListener("input", function(){

    if(email.value === ""){
        erroEmail.textContent = "";
        return;
    }


    if(!email.validity.valid){

        erroEmail.textContent =
        "Digite um e-mail válido.";

    }else{

        erroEmail.textContent = "";

    }

});


// Remove mensagem de erro quando começa a digitar senha
senha.addEventListener("input", function(){

    if(senha.value !== ""){

        erroSenha.textContent = "";

    }

});


// Envio do formulário
formulario.addEventListener("submit", function(event){

    let valido = true;


    // Limpa mensagens antigas
    erroEmail.textContent = "";
    erroSenha.textContent = "";



    // Verifica e-mail

    if(email.value === ""){

        erroEmail.textContent =
        "Digite seu e-mail.";

        valido = false;

    }
    else if(!email.validity.valid){

        erroEmail.textContent =
        "Digite um e-mail válido.";

        valido = false;

    }



    // Verifica senha

    if(senha.value === ""){

        erroSenha.textContent =
        "Digite sua senha.";

        valido = false;

    }



    // Impede login se houver erro

    if(!valido){

        event.preventDefault();

        return;

    }



    // Demonstração
    alert("Login realizado com sucesso!");

});