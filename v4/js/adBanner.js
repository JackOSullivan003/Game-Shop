let slideIndex = 0;

function showAd(index) {
    const slides = document.querySelectorAll(".ad");
    if (index >= slides.length) {
        slideIndex = 0;
    } else if (index < 0) {
        slideIndex = slides.length - 1;
    }
    
    for(let slide of slides) {
        slide.style.opacity = 0;
    };

    if (slides[slideIndex] != undefined) {
    slides[slideIndex].style.opacity = 1;
}

function moveSlide(step) {
    slideIndex += step;
    showAd(slideIndex);
}

showAd(slideIndex);

setInterval(() => {
    moveSlide(1);
}, 8000);
}