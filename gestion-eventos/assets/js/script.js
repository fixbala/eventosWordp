document.addEventListener('DOMContentLoaded', function () {
    const slides = document.querySelectorAll('.slide');
    let currentSlide = 0;

    document.querySelector('.prev-slide').addEventListener('click', function () {
        slides[currentSlide].style.display = 'none';
        currentSlide = (currentSlide > 0) ? currentSlide - 1 : slides.length - 1;
        slides[currentSlide].style.display = 'block';
    });

    document.querySelector('.next-slide').addEventListener('click', function () {
        slides[currentSlide].style.display = 'none';
        currentSlide = (currentSlide < slides.length - 1) ? currentSlide + 1 : 0;
        slides[currentSlide].style.display = 'block';
    });
});
   