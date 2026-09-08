// Seleciona os elementos do formulário
const formulario = document.getElementById("cadastroForm");

const email = document.getElementById("email");
const senha = document.getElementById("senha");
const confirmarSenha = document.getElementById("confirmarSenha");

const erroEmail = document.getElementById("erroEmail");
const erroSenha = document.getElementById("erroSenha");

// Validação em tempo real do e-mail
email.addEventListener("input", () => {

    if(email.validity.valid){
        erroEmail.textContent = "";
    }else{
        erroEmail.textContent = "Digite um e-mail válido.";
    }

});

// Validação em tempo real das senhas
function validarSenha(){

    if(confirmarSenha.value === ""){
        erroSenha.textContent = "";
        return;
    }

    if(senha.value !== confirmarSenha.value){
        erroSenha.textContent = "As senhas não coincidem.";
    }else{
        erroSenha.textContent = "";
    }

}

senha.addEventListener("input", validarSenha);
confirmarSenha.addEventListener("input", validarSenha);

// Ao enviar o formulário
formulario.addEventListener("submit", function(event){

    let formularioValido = true;

    erroEmail.textContent = "";
    erroSenha.textContent = "";

    // Validação do e-mail
    if(!email.validity.valid){
        erroEmail.textContent = "Digite um e-mail válido.";
        formularioValido = false;
    }

    // Validação das senhas
    if(senha.value !== confirmarSenha.value){
        erroSenha.textContent = "As senhas não coincidem.";
        formularioValido = false;
    }

    // Impede o envio caso exista algum erro
    if(!formularioValido){
        event.preventDefault();
        return;
    }

    // Apenas demonstração
    alert("Cadastro realizado com sucesso!");

});