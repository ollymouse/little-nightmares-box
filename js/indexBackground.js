const images = [
    "./images/fundo1.jpg",
    "./images/fundo2.jpg",
    "./images/fundo3.jpg"
];

let current = 0;
const background = document.querySelector('.cont'); 

function trocaImagem(){
    background.style.backgroundImage = `url(${images[current]})`;
    current = (current + 1) % images.length;
}

trocaImagem();
setInterval(trocaImagem, 5000);