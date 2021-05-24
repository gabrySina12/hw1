function checkName(event) {
    const input = document.querySelector('.nome');;
    
    if(!/^[a-zA-Z]{1,}$/.test(input.value)){
        document.querySelector('.nome').classList.add('errorj');
        input.parentNode.parentNode.parentNode.querySelector('.nome_err').textContent = "Sono ammesse solo lettere";
        formStatus.Name = false;
    }else
    {   
        document.querySelector('.nome').classList.remove('errorj');
        input.parentNode.parentNode.parentNode.querySelector('.nome_err').textContent = "";
        formStatus.Name = true;
    }
    checkSubmit();
    
}

function checkSurname(event) {
    const input = document.querySelector('.cognome');
    
    if(!/^[a-zA-Z]{1,}$/.test(input.value)){
        document.querySelector('.cognome').classList.add('errorj');
        input.parentNode.parentNode.parentNode.querySelector('.cognome_err').textContent = "Sono ammesse solo lettere";
        formStatus.Surname = false;
    }else
    {   
        document.querySelector('.cognome').classList.remove('errorj');
        input.parentNode.parentNode.parentNode.querySelector('.cognome_err').textContent = "";
        formStatus.Surname = true;
    }
    checkSubmit();
    
}


function jsonCheckEmail(json){
     // Controllo il campo exists ritornato dal JSON
     if (!json.exists) {

        document.querySelector('.email input').classList.remove('errorj');
    } else {
        document.querySelector('.email_err').textContent = "Email già utilizzata";
        document.querySelector('.email input').classList.add('errorj');
    }
}

function checkEmail(event) {

    const emailInput = document.querySelector('.email input');
    console.log(emailInput);
    if(!/^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,})){1,}$/.test(String(emailInput.value).toLowerCase())) {
        emailInput.parentNode.parentNode.parentNode.querySelector('.email_err').textContent = "Email non valida";
        document.querySelector('.email input').classList.add('errorj');
        formStatus.email = false;
    } else {
        emailInput.parentNode.parentNode.parentNode.querySelector('.email_err').textContent = "";
        document.querySelector('.email input').classList.remove('errorj');
        formStatus.email = true;
        fetch("check_email.php?q="+encodeURIComponent(String(emailInput.value).toLowerCase())).then(fetchResponse).then(jsonCheckEmail);
    }
    checkSubmit();
}

function jsonCheckUsername(json){
    
    if(!json.exists){
        document.querySelector('.username input').classList.remove('errorj'); 
    }else
    {
        document.querySelector('.username_err').textContent = "Nome utente già utilizzato";
        document.querySelector('.username input').classList.add('errorj');
    }
    checkSubmit();
}

function fetchResponse(response){
    if(!response.ok) return null;
    return response.json();
}

function checkUsername(event){
    
    const input = document.querySelector('.username input');
    
    if(!/^[a-zA-Z0-9_]{1,15}$/.test(input.value)){
        document.querySelector('.username input').classList.add('errorj');
        input.parentNode.parentNode.parentNode.querySelector('.username_err').textContent = "Sono ammesse lettere, numeri e underscore. Massimo 15 caratteri";
        formStatus.Username = false;
    }else
    {   
        input.parentNode.parentNode.parentNode.querySelector('.username_err').textContent = "";
        formStatus.Username = true;
        fetch("check_username.php?q="+encodeURIComponent(input.value)).then(fetchResponse).then(jsonCheckUsername);
    }
    checkSubmit();
}

function checkPassword(event) {
    const passwordInput = document.querySelector('.password input');
    if (passwordInput.value.length >= 8) {
        passwordInput.parentNode.parentNode.parentNode.querySelector('.password_err').textContent = "";
        document.querySelector('.password').classList.remove('errorj');
        formStatus.password = true;
    } else {
        passwordInput.parentNode.parentNode.parentNode.querySelector('.password_err').textContent = "La password deve avere almeno 8 caratteri";
        document.querySelector('.password input').classList.add('errorj');
        formStatus.password = false;
    }
    checkSubmit();
}

function checkDate(event){
    const dateInput = document.querySelector('.data');
    console.log(dateInput.value);
    let today = new Date();
    let magg = today.setFullYear(today.getFullYear()-18);
    let dataNascita = new Date(dateInput.value);
    let eta = today.getFullYear() - dataNascita.getFullYear();
    let mese = today.getMonth() - dataNascita.getMonth();
    let giorno =  today.getDate() - dataNascita.getDate();

    if(eta>0 || eta == 0 && mese >0 || eta == 0 && mese == 0 && giorno >= 0){
        dateInput.parentNode.parentNode.parentNode.querySelector('.data_err').textContent = "";
        document.querySelector('.data').classList.remove('errorj');
        formStatus.maggiorenne = true;
    }else
    {
        dateInput.parentNode.parentNode.parentNode.querySelector('.data_err').textContent = "Devi essere maggiorenne per iscriverti";
        document.querySelector('.data').classList.add('errorj');
        formStatus.maggiorenne = false;
    }

    checkSubmit();

}

function checkSubmit(){
    let err = document.querySelectorAll('.errorj');
    let message = document.querySelector('.submit_err');
    document.getElementById('submit').disabled = Object.values(formStatus).includes(false) || Object.keys(formStatus).length !== 6 || !document.querySelector('.allow input').checked;
}

function showPwd() {
    let input = document.querySelector('.password input');
    let click = document.getElementById('showpw');
    if (input.type === "password") {
      input.type = "text";
      click.style.backgroundImage = "url('Immagini/nascondi.png')"
    } else {
      input.type = "password";
      click.style.backgroundImage = "url('Immagini/mostra.png')"
    }
  }

  function checkConfirm(event){
    checkSubmit();
  }

const formStatus = {};
document.querySelector('.nome').addEventListener('blur', checkName);
document.querySelector('.cognome').addEventListener('blur', checkSurname);
document.querySelector('.email input').addEventListener('blur', checkEmail);
document.querySelector('.password input').addEventListener('blur', checkPassword);
document.querySelector('.username input').addEventListener('blur', checkUsername);
document.querySelector('.data').addEventListener('blur', checkDate);
document.querySelector('.allow input').addEventListener('click', checkConfirm);