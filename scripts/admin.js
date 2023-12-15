
//get the name of the page to by dynaically loaded into the main section
//called from admin_index.php
const menu = document.getElementById('menu');
const mainContent = document.getElementById('main_section');

menu.addEventListener('click', async function (event) {
 
    event.preventDefault(); // Prevent the default behavior of the link

    const targetPage = event.target.dataset.page;

    if (targetPage) {
        try {
            // Fetch HTML content from the server
            const response = await fetch(`${targetPage}.php`);
            const content = await response.text();

            // Insert the HTML content into the main-content div
            //console.log(content);
            mainContent.innerHTML = content;
            
            // Dynamically create and append a script tag
            const script = document.createElement('script');
            script.src = '../scripts/alert.js';
             document.head.appendChild(script);
             
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

// Event listener for menu clicks
document.addEventListener('DOMContentLoaded', function () {

    menu.addEventListener('click', async function (event) {
        const targetPage = event.target.dataset.page;
    
        if (targetPage) {
            try {
                // Dynamically load JavaScript files
                loadScript('../scripts/admin.js');
    
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
});

function loadScript(src) {
    const script = document.createElement('script');
    script.src = src;
    //script.type = 'text/javascript';
    script.onload = function () {
        // Script has loaded
        console.log(`Script ${src} has been loaded.`);
    };
    document.head.appendChild(script);
}