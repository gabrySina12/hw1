/*function creaBox(){
    for(c in contenuti){
        let box = document.createElement("div");
        box.setAttribute('class', 'goria');
        let title = document.createElement('h1');
        let textTitle = document.createTextNode(contenuti[c].Categoria);
        title.appendChild(textTitle);
        box.appendChild(title);
        let image = document.createElement("img");
        image.setAttribute('src', contenuti[c].Immagine);
        box.appendChild(image);
        let details = document.createElement('div');
        details.setAttribute('class', 'dettagli');
        let txtAgg = document.createElement('a');
        let icon = document.createElement("img");
        icon.setAttribute('src', RIGHT_ARROW);
        txtAgg.appendChild(icon);
        let span = document.createElement("span");
        let textSpan = document.createTextNode('Mostra di più');
        span.appendChild(textSpan);
        txtAgg.appendChild(span);
        let divPre = document.createElement('div');
        divPre.setAttribute('class', 'aggpre')
        let agg = document.createElement('a');
        let prefe = document.createElement("img");
        prefe.setAttribute('class', 'tasto');
        prefe.setAttribute('src', 'Immagini/icona.png');
        agg.appendChild(prefe); 
        divPre.appendChild(agg); 
        let descr = document.createElement("p");
        let textP = document.createTextNode(contenuti[c].Descrizione);
        descr.appendChild(textP);
        descr.style.display = 'none';
        details.appendChild(descr);
        details.appendChild(txtAgg);
                
        box.appendChild(details);
        box.appendChild(divPre);
        categoria.appendChild(box);
        txtAgg.addEventListener('click', onclick);
        agg.addEventListener('click', favorite);
    }

}*/

/*function onclick(event){
    let paragr = event.currentTarget.parentNode.querySelector('p');
    let text = event.currentTarget.parentNode.querySelector('.dettagli span');
    let img = event.currentTarget.parentNode.querySelector('.dettagli img');
    if(paragr.style.display === 'none'){
        paragr.style.display = "";
        text.textContent = 'Mostra di meno';
        img.setAttribute('src', DOWN_ARROW);
    }else{
        paragr.style.display = "none";
        text.textContent = 'Mostra di più';
        img.setAttribute('src', RIGHT_ARROW);
    }
    
}*/


/*function favorite(event){
    preferiti.classList.remove('hidden');    
    let piu = event.currentTarget.parentNode.querySelector('.tasto').src;
    let catPre = event.currentTarget.parentNode.parentNode.querySelector('h1').textContent;
    let imaPre = event.currentTarget.parentNode.parentNode.querySelector('img').src;
    let boxPre = document.createElement('div');
    boxPre.setAttribute('class', 'goriaPre');
    let titlePre = document.createElement('h1');
    let textTitlePre = document.createTextNode(catPre);
    titlePre.appendChild(textTitlePre);
    boxPre.appendChild(titlePre);
    let imagePre = document.createElement("img");
    imagePre.setAttribute('src', imaPre);
    boxPre.appendChild(imagePre);
    let rmPre = document.createElement('a');
    rmPre.setAttribute('class', 'dettagliPre');
    let spanPre = document.createElement("span");
    let textSpanPre = document.createTextNode('Rimuovi dai preferiti ');
    spanPre.appendChild(textSpanPre);
    rmPre.appendChild(spanPre);
    boxPre.appendChild(rmPre);
    let iconPre = document.createElement("img");
    iconPre.setAttribute('class', 'tastoPre');
    iconPre.setAttribute('src', 'Immagini/meno.png');
    rmPre.appendChild(iconPre);
    event.currentTarget.removeEventListener('click', favorite);    

    preferiti.appendChild(boxPre);
    rmPre.addEventListener('click', remove);
}*/

/*function remove(event){
    let cont = document.querySelectorAll('.goria');
    console.log(cont);
    let clicked = event.currentTarget.parentNode.querySelector('h1').textContent;
    console.log(clicked);
    preferiti.removeChild(event.currentTarget.parentNode);
    let contatore = preferiti.querySelectorAll('.goriaPre').length;

    if(contatore === 0){
        preferiti.classList.add('hidden');
    }

    for(let c of cont){
        let s = c.querySelector('h1').textContent;
        console.log(s);
        if(s.indexOf(clicked)>-1){
            console.log(c.querySelector('.aggpre a'));
            c.querySelector('.aggpre a').addEventListener('click', favorite);
        }
    }
    
}*/


/*function ricerca(event){
    let filtro = event.currentTarget.value.toUpperCase();
    let cat = categoria.querySelectorAll('.goria');
    for(let c of cat){
        let tit = c.querySelector('h1').textContent.toUpperCase();
        if(tit.indexOf(filtro)>-1){
            c.style.display = '';
        }else{
            c.style.display = 'none';
        }
    }

}*/
const client_id = '602186831812-l3rqtum4ltrbn5q80589nrmddtj2ae4t.apps.googleusercontent.com';
function oauthSignIn() {
    // Google's OAuth 2.0 endpoint for requesting an access token
    var oauth2Endpoint = 'https://accounts.google.com/o/oauth2/v2/auth';
    fetch(oauth2Endpoint + '?client_id' + client_id + '&redirect_uri=http://localhost/mhw4//mhw3.html&response_type=token&scope=https://www.googleapis.com/auth/youtube.force-ssl&include_granted_scopes=true&state=pass-through%20value')
    // Create <form> element to submit parameters to OAuth 2.0 endpoint.
    var form = document.createElement('form');
    form.setAttribute('method', 'GET'); // Send as a GET request.
    form.setAttribute('action', oauth2Endpoint);
    // Parameters to pass to OAuth 2.0 endpoint.
    var params = {'client_id': client_id,
                  'redirect_uri': 'http://localhost/mhw4//mhw3.html',
                  'response_type': 'token',
                  'scope': 'https://www.googleapis.com/auth/youtube.force-ssl',
                  'include_granted_scopes': 'true',
                  'state': 'pass-through value'};
    // Add form parameters as hidden input values.
    for (var p in params) {
      var input = document.createElement('input');
      input.setAttribute('type', 'hidden');
      input.setAttribute('name', p);
      input.setAttribute('value', params[p]);
      form.appendChild(input);
      console.log(p);
    }
    // Add form to page and submit it to open the OAuth 2.0 endpoint.
    document.body.appendChild(form);
    form.submit();
  }

const search = document.querySelector('#barra');
search.addEventListener('keyup', ricerca);



oauthSignIn();

