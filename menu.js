function tendina(event){
    let var1 = event.currentTarget.parentNode.querySelector('#tendina');

    if(menu.style.display === ''){
        menu.style.display = 'none';
        var1.classList.remove('hidden');
        var1.classList.add('flex');
    }
}

function chiudi(event){
    let var2 = event.currentTarget.parentNode.parentNode.querySelector('#menu');
    let var3 = event.currentTarget.parentNode.parentNode.querySelector('#tendina');
    

    var3.classList.remove('flex');
    var3.classList.add('hidden');
    var2.style.display = '';
}

const client_id = '602186831812-l3rqtum4ltrbn5q80589nrmddtj2ae4t.apps.googleusercontent.com';
const link = "https://accounts.google.com/o/oauth2/v2/auth?client_id="+client_id+"&redirect_uri=http://localhost/mhw4//video.php&response_type=token&scope=https://www.googleapis.com/auth/youtube.force-ssl&include_granted_scopes=true&state=pass-through%20value";
const a = document.querySelectorAll('.token');
const close1 = document.querySelector('#close');
const menu = document.querySelector('#menu');
for(c of a){
   c.setAttribute('href', link); 
}

menu.addEventListener('click', tendina);
close1.addEventListener('click', chiudi);