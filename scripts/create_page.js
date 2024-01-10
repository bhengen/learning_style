// script to load the images from a folder and generate cards
// called from assessment_page.php

// load the images from the folder into an array
let imagePaths = [];
for (let i = 1; i <= 28; i++) {
    const imageName = (i < 10) ? "0" + i : "" + i;
    imagePaths.push("images/" + imageName + ".jpg");
}


$(document).ready(function () {

    // Flag to track if the user has been warned
    let warned = false;

    // Show a warning when the user tries to leave or close the page
    $(window).on('beforeunload', function () {
        if (!warned) {
            warned = true;
            return 'Are you sure you want to leave?';
        }
    });

    // Reset the warning flag if the user interacts with the page again
    $(document).on('visibilitychange', function () {
        if (document.visibilityState === 'visible') {
            warned = false;
        }
    });

    // Function to create radio buttons with labels
    function createRadioGroup(index) {
        const container = document.createElement("div");
        container.classList.add("radio-group"); // Add "with-radio" class
    
        const radioA = createRadioButton(imagePaths[index], "A");
        const labelA = createLabel(imagePaths[index], "A");

        const radioB = createRadioButton(imagePaths[index], "B");
        const labelB = createLabel(imagePaths[index], "B");

        container.appendChild(radioA);
        container.appendChild(labelA);
        container.appendChild(radioB);
        container.appendChild(labelB);

        return container;
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
 
        // Assign radioA and radioB within the loop
        radioA = radioGroup.querySelector('input[value="A"]');
        radioB = radioGroup.querySelector('input[value="B"]');
        
        imageContainer.appendChild(image);
        imageContainer.appendChild(radioGroup);

        // Append the image container to the current row
        currentRow.appendChild(imageContainer);
    }

    // Fetch previous selections from the database after creating the page
    for (let i = 0; i < imagePaths.length; i++) {
        fetchPreviousSelection(i);
    }

    function fetchPreviousSelection(idx) {
        // get the student id
        let student_id = document.getElementById('student_id').value;
        let school_year = document.getElementById('schoolYear').value;

        //console.log("index: " + idx);
        $.ajax({
            type: 'POST',
            url: 'php/fetch_previous_selections.php',
            data: { studentId: student_id, pictureNumber: idx + 1, school_year: school_year },
            //async: false, // Make the call synchronous
            success: function (response) {
                // Process the response to determine if the button was previously selected
                const radioContainer = $(`.image-container:eq(${idx}) .radio-group`);
                 if (response.trim() === (idx+1)+"A".trim()) {
                    radioContainer.find('input[value="A"]').prop("checked", true);
                } else if (response.trim() === (idx+1)+'B'.trim()) {
                    radioContainer.find('input[value="B"]').prop("checked", true);
                } else {
                    //console.log('error setting the button');
                }
            },
            error: function (error) {
                console.error('Error fetching previous selections:', error);
            }
        });
    }

    $('input[type="radio"]').on('click', function() {
        // Get the selected radio button's value
        const buttonValue = $(this).val();

        // Get the picture number from the radio button's name attribute
        const pictureNumber = parseInt($(this).attr('name').match(/\d+/)[0], 10);
        console.log('Picture Number:', pictureNumber);
        
        // Concatenate picture number, option, and student ID
        const question_number = pictureNumber.toString() + buttonValue;
        console.log('Question Number:', question_number);
        
        let student_id = $('#studentId').text();
        console.log("Student Id:". student_id);

        let completed_day  = document.getElementById('completedDay').value;
        console.log("Completed Day:" .completed_day);

        let completed_month = document.getElementById('completedMonth').value;
        console.log("Completed Month: ". completed_month);

        let completed_hour = document.getElementById('completedHour').value;
        console.log("Completed Hour: " .completed_hour);

        let completed_min = document.getElementById('completedMin').value;
        console.log("Completed_Min: ". completed_min);

        let completed_sec = document.getElementById('completedSec').value;
        console.log("Completed Sec: ". completed_sec);
        
        let school_year = document.getElementById('schoolYear').value;
        console.log('school_year:', school_year);

        let matchResult = student_id.match(/[^\D]+/);
        if(matchResult) {
            student_id = matchResult[0];
        } else {
            console.log('error extracting student id');
        }

        // Use AJAX to send the selected value to the server
        $.ajax({
            type: 'POST',
            url: 'php/track_questions_completed.php', // Adjust the path to your PHP script
            data: { 
                studentId: student_id, 
                question_number: question_number,
                completed_day: completed_day,
                completed_month: completed_month, 
                completed_year: school_year,
                completed_hour: completed_hour,
                completed_min: completed_min,
                completed_sec: completed_sec    
            },
            success: function(response) {
                console.log('Data sent to server successfully');
                console.log(response); // Log any response from the server
                // Update UI or perform other actions as needed
            },
            error: function(error) {
                console.error('Error sending data to server:', error);
            }
        });
    })

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
            //console.log(itemSelected);

            selectedValues.push(itemSelected);
        });
       

        // append the selected items to the hidden input tag
        hiddenSelections.value = selectedValues.join(",");
        console.log(selectedValues.length);

        if (selectedValues.length != 28) {
            alert("You need to select all 28 to continue");
        } else if (selectedValues.length === 28) {
           // submit the form
           $('form').submit();
        } else {
            sendSelectedValuesToServer(selectedValues);
        }
    });
    /*
    function sendSelectedValuesToServer(selectedValues) {
        // Use AJAX to send the data to the server
        $.ajax({
            type: 'POST',
            url: 'path/to/your/server-script.php', // Adjust the path to your PHP script
            data: { selectedValues: selectedValues },
            success: function(response) {
                console.log('Data sent to server successfully');
                console.log(response); // Log any response from the server
                // Redirect or perform other actions as needed
            },
            error: function(error) {
                console.error('Error sending data to server:', error);
            }
        });
    }
    */
});
