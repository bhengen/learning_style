
// get the name of the page to by dynaically loaded into the main section
// called from admin_index.php
const menu = document.getElementById('menu');
const mainContent = document.getElementById('main_section');

menu.addEventListener('click', async function (event) {
 
    const targetPage = event.target.dataset.page;
    console.log(event.target);

    if (targetPage) {
        try {
            // Fetch HTML content from the server
            const response = await fetch(`${targetPage}.php`);
            const content = await response.text();

            // Insert the HTML content into the main-content div
            mainContent.innerHTML = content;
        } catch (error) {
            console.error(`Error loading content for ${targetPage}:`, error);
        }
    }
});


// process the student record
// called from display_student_data.php
function handleFormSubmit() {
    var submitAction;

    if (document.activeElement.id === 'updateBtn') {
        // Update button clicked
        submitAction = 'update';
    } else if (document.activeElement.id === 'deleteBtn') {
        // Delete button clicked
        var confirmed = confirm("Are you sure you want to delete this record?");
        if (confirmed) {
            submitAction = 'delete';
        } else {
            // Cancel clicked, prevent form submission
            return false;
        }
    }

    // Set the action in a hidden input field
    document.getElementById('submit_action').value = submitAction;

    // Continue with form submission
    return true;
}

// load the page into the main_section div tag on the admin_index.php page

document.addEventListener('DOMContentLoaded', function () {
    // Get all forms with the 'student-form' class
    const studentForms = document.querySelectorAll('.student-form');
    mainContent.innerText = "HELLO WORLD";

    // Attach a submit event listener to each form
    studentForms.forEach(form => {
        form.addEventListener('submit', async function (event) {
            event.preventDefault(); // Prevent the default form submission

            // Get form data
            const formData = new FormData(form);

            try {
                // Fetch data from the server
                const response = await fetch(form.action, {
                    method: 'POST',
                    body: formData,
                });

                // Check if the response is successful
                if (response.ok) {
                    // Update the main section content with the response
                    mainSection.innerHTML = await response.text();
                } else {
                    console.error('Error:', response.statusText);
                }
            } catch (error) {
                console.error('Error:', error);
            }
        });
    });
});
