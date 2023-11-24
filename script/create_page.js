// script to load the images from a folder and generate cards
// called from assessment_page.php

// load the images from the folder into an array
let imagePaths = [];
for (let i = 1; i <= 28; i++) {
    const imageName = (i < 10) ? "0" + i : "" + i;
    imagePaths.push("images/" + imageName + ".jpg");
}

$(document).ready(function () {

    // Function to create radio buttons with labels
    function createRadioGroup(index) {
        const radioGroup = document.createElement("div");

        const radioA = createRadioButton(imagePaths[index], "A");
        const labelA = createLabel(imagePaths[index], "A");

        const radioB = createRadioButton(imagePaths[index], "B");
        const labelB = createLabel(imagePaths[index], "B");

        radioGroup.appendChild(radioA);
        radioGroup.appendChild(labelA);
        radioGroup.appendChild(radioB);
        radioGroup.appendChild(labelB);

        return radioGroup;
    }

    function createLabel(imageName, value) {
        const label = document.createElement("label");
        label.htmlFor = imageName + value;
        label.innerText = value;

        return label;
    }

    function createRadioButton(imageName, value) {
        const radio = document.createElement("input");
        radio.type = "radio";
        radio.name = imageName;
        radio.value = value;

        return radio;
    }

    // Add images dynamically
    const imageGallery = document.getElementById("imageGallery");
    let currentRow;

    for (let i = 0; i < imagePaths.length; i++) {
        // Create a new row container for every fourth image
        if (i % 3 === 0) {
            currentRow = document.createElement("div");
            currentRow.classList.add("image-row");
            imageGallery.appendChild(currentRow);
        }

        const imageContainer = document.createElement("div");
        imageContainer.classList.add("image-container");

        const image = document.createElement("img");
        image.src = imagePaths[i];
        image.alt = "Student Image";

        const radioGroup = createRadioGroup(i);

        imageContainer.appendChild(image);
        imageContainer.appendChild(radioGroup);

        // Append the image container to the current row
        currentRow.appendChild(imageContainer);
    }

    // Submit form when the submit button is clicked
    document.getElementById('submitButton').addEventListener('click', function(event) {
        const exp = /\d+/; // extract the image number from the full image name

        // Prevent the default form submission
        event.preventDefault();
    
        //select hidden selected item
        const hiddenSelections = document.getElementById('selected_items');

        // Collect selected radio buttons
        const selectedButtons = document.querySelectorAll('input[type="radio"]:checked');
    
        // Create an array to store selected values
        const selectedValues = [];
    
        // Add selected radio button values to the array
        selectedButtons.forEach(function(button) {
            const imageName = button.name;
            let itemSelected = parseInt(imageName.match(exp),10).toString() + button.value;
            console.log(itemSelected);

            selectedValues.push(itemSelected);
        });
       

        // append the selected items to the hidden input tag
        hiddenSelections.value = selectedValues.join(",");
        console.log(selectedValues.length);

        //if (selectedValues.length != 28) {
       //     alert("You need to select all 28 to continue");
       // } else {
            // submit the form
            $('form').submit();
        //}
    });
});
