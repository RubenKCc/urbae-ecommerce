const slides = document.querySelectorAll('.promo-slide');
const dots = document.querySelectorAll('.dot');
const nextBtn = document.querySelector('.arrow.right');
const prevBtn = document.querySelector('.arrow.left');

let index = 0;

function showSlide(i) {
  slides.forEach(slide => slide.classList.remove('active'));
  dots.forEach(dot => dot.classList.remove('active'));

  slides[i].classList.add('active');
  dots[i].classList.add('active');  // <-- o dot correspondente fica verde forte
}

function nextSlide() {
  index = (index + 1) % slides.length;
  showSlide(index);
}

function prevSlide() {
  index = (index - 1 + slides.length) % slides.length;
  showSlide(index);
}

/* Automático */
let auto = setInterval(nextSlide, 4000);

/* Setas */
nextBtn.addEventListener('click', () => {
  nextSlide();
  resetAuto();
});

prevBtn.addEventListener('click', () => {
  prevSlide();
  resetAuto();
});

function resetAuto() {
  clearInterval(auto);
  auto = setInterval(nextSlide, 4000);
}

/* Inicializa o slider corretamente */
showSlide(index);

dots.forEach((dot, i) => {
  dot.addEventListener('click', () => {
    index = i;
    showSlide(index);
    resetAuto();
  });
});

/* Fim do slider */
