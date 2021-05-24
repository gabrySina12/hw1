function reg_log(event){
    let log = event.currentTarget.parentNode.parentNode.parentNode.parentNode.querySelector('#boxLog');
    let reg = event.currentTarget.parentNode.parentNode.parentNode.parentNode.querySelector('#reg_log');
    if(log.style.display == ''){
        log.style.display = 'none';
        reg.style.display = 'flex';;
    }else
    {
        reg.style.display = 'none';
        log.style.display = '';
    }
}

function log_reg(event){
    let log = event.currentTarget.parentNode.parentNode.parentNode.parentNode.querySelector('#boxLog');
    let reg = event.currentTarget.parentNode.parentNode.parentNode.parentNode.querySelector('#reg_log');
    if(log.style.display == ''){
        log.style.display = 'none';
        reg.style.display = 'flex';;
    }else
    {
        reg.style.display = 'none';
        log.style.display = '';
    }
}

const form = document.forms['registrati'];
const butt = document.querySelector('.but_reg');
const butt2 = document.querySelector('.but_log');
butt.addEventListener('click', reg_log);
butt2.addEventListener('click', log_reg);