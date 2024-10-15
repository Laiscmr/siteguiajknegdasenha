let slideIndex = 1;
showSlides(slideIndex);

function currentSlide(n) {
    showSlides(slideIndex = n);
}

function changeSlide(n) {
    showSlides(slideIndex += n);
}

function showSlides(n) {
    let i;
    let slides = document.getElementsByClassName("carousel-slide");
    let thumbnails = document.getElementsByClassName("thumbnail");
    let description = document.getElementById("carousel-description");
    
    if (n > slides.length) { slideIndex = 1 }
    if (n < 1) { slideIndex = slides.length }
    
    for (i = 0; i < slides.length; i++) {
        slides[i].style.transform = `translateX(-${(slideIndex-1) * 100}%)`;
    }
    
    for (i = 0; i < thumbnails.length; i++) {
        thumbnails[i].style.opacity = "0.6";  
    }
    
    thumbnails[slideIndex-1].style.opacity = "1";
    description.textContent = slides[slideIndex-1].getAttribute("data-text");
}