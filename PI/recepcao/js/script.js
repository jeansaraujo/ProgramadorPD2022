window.addEventListener('load', () => chamaTela());

document.addEventListener('mousemove', () => {
    if (timeout !== null) {            
        document.querySelector("#protecaoTela").style.visibility = "hidden";
        clearTimeout(timeout);
    }
    chamaTela();
});

const chamaTela = () => {     
    timeout = setTimeout(() => {
        window.scroll(0,0);
        document.querySelector("#protecaoTela").style.visibility = "visible";
    }, 60000);
};