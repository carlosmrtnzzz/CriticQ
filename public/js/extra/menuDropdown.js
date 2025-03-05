document.addEventListener("DOMContentLoaded", function () {
    const userMenu = document.getElementById("userMenu");
    const dropdownMenu = document.getElementById("dropdownMenu");
    const arrow = document.getElementById("arrow");

    userMenu.addEventListener("click", function (event) {
        event.stopPropagation();

        userMenu.classList.toggle("active");
        dropdownMenu.classList.toggle("show");

        if (dropdownMenu.classList.contains("show")) {
            dropdownMenu.style.display = "block";
            dropdownMenu.style.opacity = "1";
        } else {
            dropdownMenu.style.display = "none";
            dropdownMenu.style.opacity = "0";
        }
    });

    // Cerrar el menú si se hace clic fuera
    document.addEventListener("click", function (event) {
        if (!userMenu.contains(event.target) && !dropdownMenu.contains(event.target)) {
            userMenu.classList.remove("active");
            dropdownMenu.classList.remove("show");
            dropdownMenu.style.display = "none";
            dropdownMenu.style.opacity = "0";
        }
    });
});
