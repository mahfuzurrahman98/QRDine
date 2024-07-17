import "flowbite";
import "flowbite/dist/datepicker";
import "./bootstrap";

if (
    localStorage.getItem("color-theme") === "dark" ||
    (!("color-theme" in localStorage) &&
        window.matchMedia("(prefers-color-scheme: dark)").matches)
) {
    document.documentElement.classList.add("dark");
    document.getElementById("theme-toggle-light-icon").style.display = "none";
    document.getElementById("theme-toggle-dark-icon").style.display = "block";
} else {
    document.documentElement.classList.remove("dark");
    document.getElementById("theme-toggle-dark-icon").style.display = "none";
    document.getElementById("theme-toggle-light-icon").style.display = "block";
}

document.getElementById("theme-toggle").addEventListener("click", function () {
    let htmlClasses = document.documentElement.classList;
    if (htmlClasses.contains("dark")) {
        htmlClasses.remove("dark");
        // hide element with id theme-toggle-dark-icon
        // show element with id theme-toggle-light-icon
        document.getElementById("theme-toggle-dark-icon").style.display =
            "none";
        document.getElementById("theme-toggle-light-icon").style.display =
            "block";
        localStorage.setItem("color-theme", "light");
    } else {
        htmlClasses.add("dark");
        document.getElementById("theme-toggle-light-icon").style.display =
            "none";
        document.getElementById("theme-toggle-dark-icon").style.display =
            "block";
        localStorage.setItem("color-theme", "dark");
    }
});

// if any form is submitted, disable the submit button and show the spinner
document.querySelectorAll("form").forEach((form) => {
    form.addEventListener("submit", (e) => {
        form.querySelector("button[type=submit]").setAttribute(
            "disabled",
            true
        );
    });
});
