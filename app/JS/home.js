
    document.addEventListener("DOMContentLoaded", () => {
    const slides = document.querySelectorAll(".slide");
    const prevBtn = document.querySelector(".prev");
    const nextBtn = document.querySelector(".next");
    const dotsContainer = document.querySelector(".slider-dots");
    let currentIndex = 0;
    let autoSlide;


    slides.forEach((_, i) => {
    const dot = document.createElement("span");
    if (i === 0) dot.classList.add("active");
    dotsContainer.appendChild(dot);
});
    const dots = dotsContainer.querySelectorAll("span");

    function showSlide(index) {
    slides.forEach((slide, i) => {
    slide.classList.toggle("active", i === index);
    dots[i].classList.toggle("active", i === index);
});
}

    function nextSlide() {
    currentIndex = (currentIndex + 1) % slides.length;
    showSlide(currentIndex);
}

    function prevSlide() {
    currentIndex = (currentIndex - 1 + slides.length) % slides.length;
    showSlide(currentIndex);
}

    // Event listeners boutons
    nextBtn.addEventListener("click", () => {
    nextSlide();
    resetAutoSlide();
});

    prevBtn.addEventListener("click", () => {
    prevSlide();
    resetAutoSlide();
});

    // Event listeners dots
    dots.forEach((dot, i) => {
    dot.addEventListener("click", () => {
    currentIndex = i;
    showSlide(currentIndex);
    resetAutoSlide();
});
});

    // Auto défilement
    function startAutoSlide() {
    autoSlide = setInterval(nextSlide, 5000); // toutes les 5s
}

    function resetAutoSlide() {
    clearInterval(autoSlide);
    startAutoSlide();
}

    // Initialisation
    showSlide(currentIndex);
    startAutoSlide();
});