function notizie(json){

    for(let c in json){
        let pref = document.createElement('a');
        pref.style.backgroundImage = "url('Immagini/Star1.png')";
        for(let a in prefe){
            if(prefe[a].link === json[c].link){
                pref.style.backgroundImage = "url('Immagini/Star2.png')";
            }
        }
        let box = document.createElement('div');
        box.setAttribute('class', 'sez');
        let topside = document.createElement('div');
        topside.setAttribute('id', 'topside');
        let titolo = document.createElement('h1');
        let txtT = document.createTextNode(json[c].nome);        
        let cittaP = document.createElement('p');
        let citta= document.createTextNode(json[c].citta);
        cittaP.style.display = 'none';
        let link =document.createElement('a');
        link.setAttribute('href', json[c].link);
        let img = document.createElement('img');
        img.setAttribute('src', json[c].pic);
        img.setAttribute('class', 'linkNews');
        let divDe = document.createElement('div');
        divDe.setAttribute('class', 'divDe');
        let descr = document.createElement('span');
        let descrTxt = document.createTextNode(json[c].descrizione);
        let meteo = document.createElement('div');
        meteo.setAttribute('class', 'meteo');
        meteo.style.display = 'none';

        let dettagli =document.createElement('a');
        dettagli.setAttribute('class', 'botton')
        let iconMe = document.createElement('img');
        iconMe.setAttribute('src', 'Immagini/weather.png')
        let dettagliSez = document.createElement('span');
        dettagliSez.setAttribute('class', 'mostraMeteo');
        let dettagliTxt = document.createTextNode('Mostra meteo');
        titolo.appendChild(txtT);
        topside.appendChild(titolo);
        topside.appendChild(pref);
        box.appendChild(topside);
        cittaP.appendChild(citta);
        box.appendChild(cittaP)
        link.appendChild(img);
        box.appendChild(link);
        descr.appendChild(descrTxt);
        divDe.appendChild(descr);
        box.appendChild(divDe);
        box.appendChild(meteo);

        dettagliSez.appendChild(dettagliTxt);
        dettagli.appendChild(iconMe);
        dettagli.appendChild(dettagliSez);
        dettagli.addEventListener('click', mostraMeteo);
        box.appendChild(dettagli);
        pref.addEventListener('click', aggPref);

        
        weather1.appendChild(box);
    }

}

function aggPref(event){
    let title = event.currentTarget.parentNode.querySelector('#topside h1').textContent;
    let but = event.currentTarget.style.backgroundImage;
    
    if(but === 'url("Immagini/Star1.png")'){
        fetch('http://localhost/mhw4//aggPref.php?q=' + title)
        but = 'url("Immagini/Star2.png")';
        
    }
}

function mostraMeteo(event){
  
    let citta1 = event.currentTarget.parentNode.querySelector('p').textContent;
    let divMeteo = event.currentTarget.parentNode.querySelector('.meteo');
    let txt = event.currentTarget.parentNode.querySelector('.mostraMeteo');
    if(divMeteo.style.display === 'none'){
        fetch('http://localhost/mhw4/search_api.php?q=' + citta1
        ).then(onResponse, onError).then(json=>{
            console.log(json);
            let icon = document.createElement('img');
            icon.setAttribute('src', json.weather_icons);
            let nuvolosita = document.createElement('p');
            let nuvTxt = document.createTextNode('Nuvolosità: ' + json.cloudcover + '%');
            let umidita = document.createElement('p');
            let umTxt = document.createTextNode('Umidità: ' + json.humidity + '%');
            let Precipitazioni = document.createElement('p');
            let preciTxt = document.createTextNode('Precipitazioni: ' + json.precip + '%');

            divMeteo.appendChild(icon);
            nuvolosita.appendChild(nuvTxt);
            divMeteo.appendChild(nuvolosita);
            umidita.appendChild(umTxt);
            divMeteo.appendChild(umidita);
            Precipitazioni.appendChild(preciTxt);
            divMeteo.appendChild(Precipitazioni);

        });
        divMeteo.style.display = '';
        txt.textContent = 'Nascondi Meteo';
    }else{
        divMeteo.style.display = 'none';
        txt.textContent = 'Mostra Meteo';
    }
    
}

function jsonPref(json){
    prefe = json;

}


function onError(error){
    console.log('Error: ' + error);
}

function onResponse(response) {
    return response.json();
  }

  function jsonNews(json){
    notizie(json);

  }

function preferiti(){
    fetch('http://localhost/mhw4//preferiti.php').then(onResponse, onError).then(jsonPref).catch(onError);
}


  function list(){
      let gif = document.getElementById('loading');
      gif.style.display = 'none';
    fetch('http://localhost/mhw4/listaNews.php').then(onResponse, onError).then(jsonNews);
    
}

function jsonSerch(json){
    let cat = document.querySelectorAll('.sez');
    for(let c of cat){
        
            c.style.display = 'none';
        
    }
    for(let a of json){

        for(let d of cat){
        let tit = d.querySelector('h1').textContent;
        if(tit.indexOf(a)>-1){
            d.style.display = '';
            }
        }
    }
}

function ricerca(event){

    
    let filtro = event.currentTarget.value;

    fetch('http://localhost/mhw4/ricercaEventi.php?q=' + encodeURIComponent(filtro)).then(onResponse, onError).then(jsonSerch).catch(onError);

}

const weather1 = document.querySelector('.weather');
const input = document.getElementById('search').addEventListener('blur', ricerca);
let prefe;
preferiti();
setTimeout(list, 2000);
