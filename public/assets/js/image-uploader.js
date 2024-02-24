function previewImage(event) {
    let input = event.target;

    if (input.files && input.files[0]) {
        let reader = new FileReader();
        reader.onload = function (e) {
            let previewElement = document.getElementById(
                input.id + "_preview_div"
            );

            previewElement.setAttribute("src", e.target.result);
            let removeButton = document.getElementById(
                input.id + "_remove_btn"
            );
            removeButton.style.display = "block";

            document.getElementById(input.id + "_ex").value = "0"; // set deleted as 0
        };
        reader.readAsDataURL(input.files[0]);
    }
}

document
    .querySelectorAll('[id$="_remove_btn"]')
    .forEach(function (removeButton) {
        removeButton.addEventListener("click", function () {
            console.log("remove button clicked");
            let main_id = removeButton.id.replace("_remove_btn", "");
            let preview_image_id = main_id + "_preview_div";

            let previewElement = document.getElementById(preview_image_id);
            previewElement.setAttribute(
                "src",
                "/assets/images/camera-icon.jpg"
            );
            removeButton.style.display = "none";

            document.getElementById(main_id + "_ex").value = 1; // set deleted as 1
        });
    });
