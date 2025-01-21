document.addEventListener("scroll", () => {
    const mainMenu = document.querySelector(".mainMenu");
    if (window.scrollY > 50) { // Si la page est défilée de plus de 50px
        mainMenu.classList.add("scrolled");
    } else {
        mainMenu.classList.remove("scrolled");
    }
});
