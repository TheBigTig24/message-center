let formIsOpen = false;

document.addEventListener("DOMContentLoaded", function () {
    const addToListDiv = document.getElementById("add-to-list");
    const addToListHeader = document.getElementById("add-to-list-header");
    const addListForm = document.getElementById("add-to-list-form");
    const arrow = document.querySelector("i");
    const forminputs = document.querySelectorAll("input");

    function toggleForm() {
        if (!formIsOpen) {
            // form open
            addToListDiv.style.height = "40vh";
            addToListDiv.style.transition = "height 0.2s ease-in-out";
            addToListDiv.style.flexDirection = "column";

            addToListHeader.style.margin = "1rem 0 auto 0";

            arrow.style.transform = "rotate(180deg)";

            addListForm.style.display = "flex";
            formIsOpen = true;
        } else {
            //form close
            addToListDiv.style.height = "10vh";
            addToListDiv.style.transition = "height 0.2s ease-in-out";
            addToListDiv.style.flexDirection = "row";

            arrow.style.transform = "rotate(180deg)";


            addListForm.style.display = "none";
            formIsOpen = false;
        }
    }
    addToListDiv.addEventListener("click", toggleForm);

    forminputs.forEach((input) => {
        input.addEventListener("click", function(event) {
            event.stopPropagation(); // Prevent the click event from bubbling up to the parent div
        })
    })

    addListForm.addEventListener("click", function(event) {
        event.stopPropagation(); // Prevent the click event from bubbling up to the parent div
    })

    addToListDiv.addEventListener("transitionend", function() {
        if (formIsOpen) {
            addToListHeader.style.margin = "1rem 0 auto 0";
        } else {
            addToListHeader.style.margin = "0 auto";
        }
    })
})