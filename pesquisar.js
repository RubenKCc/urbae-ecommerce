document.addEventListener("DOMContentLoaded", function () {

    const icon = document.getElementById("searchIcon");
    const box = document.getElementById("searchBox");

    icon.addEventListener("click", function (e) {
        e.preventDefault();
        e.stopPropagation();

        box.style.display = (box.style.display === "block") ? "none" : "block";
    });

    document.addEventListener("click", function (e) {
        if (!box.contains(e.target) && e.target !== icon) {
            box.style.display = "none";
        }
    });

});