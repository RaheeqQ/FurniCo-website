let slideIndex = 0;
showSlides(slideIndex);

function changeSlide(n) {
    showSlides(slideIndex += n);
}

function showSlides(n) {
    let slides = document.querySelectorAll('.slide');
    if (n >= slides.length) {
        slideIndex = 0;
    }
    if (n < 0) {
        slideIndex = slides.length - 1;
    }
    slides.forEach((slide, index) => {
        slide.classList.remove('show');
        slide.style.display = 'none';
        if (index === slideIndex) {
            slide.style.display = 'block';
            setTimeout(() => {
                slide.classList.add('show');
            }, 50);  // Slight delay to ensure CSS transition
        }
    });
}