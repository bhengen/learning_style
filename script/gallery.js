// load the images from the folder into an array
let imagePaths = [];
for (let i = 1; i <= 28; i++) {
    if (i < 10) {
        imagePaths.push("images/0" + i + ".jpg");
    } else {
        imagePaths.push("images/" + i + ".jpg");
    }
}

$(document).ready(function () {
    // Function to create radio buttons with labels
    function createRadioGroup(index) {
        const radioGroup = document.createElement("div");

        const radioA = createRadioButton("A", index);
        const labelA = createLabel("A", index);

        const radioB = createRadioButton("B", index);
        const labelB = createLabel("B", index);

        radioGroup.appendChild(radioA);
        radioGroup.appendChild(labelA);
        radioGroup.appendChild(radioB);
        radioGroup.appendChild(labelB);

        return radioGroup;
    }

    function createLabel(value, index) {
        const label = document.createElement("label");
        label.htmlFor = "group" + index + value;
        label.innerText = value;

        return label;
    }

    function createRadioButton(value, index) {
        const radio = document.createElement("input");
        radio.type = "radio";
        radio.name = "group" + index;
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
});
