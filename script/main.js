// Generate data

let weightsData;
let images = [];
let weightTotals = [];

fetch('data/weights.json')
    .then(response => {
        if (!response.ok) {
            throw new Error('Network response was not ok');
        }
        return response.json();
    })
    .then(data => {
        weightsData = data;
        initializeImages();
    })
    .catch(error => console.error('Error fetching weights:', error));

// Function to initialize images once weights are fetched
function initializeImages() {
    console.log(weightsData);

    // Your existing code for creating images
    for (let i = 1; i <= 28; i++) {
        const imageSet = {
            label: 'image' + (i < 10 ? '0' : '') + i,
            url: 'images/' + (i < 10 ? '0' : '') + i + '.jpg',
            options: [
                { id: i * 2 - 1, label: i + 'A', group: i, weight: 0 }, // Set a default weight
                { id: i * 2, label: i + 'B', group: i, weight: 0 },
            ]
        };

        // Update the weights for each option based on fetched data
        imageSet.options.forEach(option => {
 
            const weightData = weightsData.rows.find(item => item.label.toUpperCase() === option.label.toUpperCase());
            if (weightData) {
                option.weight = weightData.weight;
            }
        });

        images.push(imageSet);
    }

    // create radio buttons dynamically

    const imageContainer = document.getElementById('imageContainer');

    images.forEach((imageSet, index) => {
  
        const containerDiv = document.createElement('div');
        containerDiv.style.display = 'flex';
        containerDiv.style.flexDirection = 'column';
        containerDiv.style.alignItems = 'center';
        containerDiv.style.margin = '0';

        const img = document.createElement('img');
        img.src = imageSet.url;
        img.style.border = "1px solid #000";
        img.style.width = '400px'; // Adjust width as needed
        img.style.height = '250px'; // Maintain aspect ratio
        
        containerDiv.appendChild(img);

        const label = document.createElement('label');
        label.style.display = 'flex';
        label.style.justifyContent = 'center';
    

        imageSet.options.forEach((option) => {

            const input = document.createElement('input');
            input.style.marginRight = '25px';
            input.type = 'radio';
            input.value = `${option.label}`;
            input.name = `${option.group}`;
            input.setAttribute('data-weight', option.weight);

            const labelText = document.createTextNode(`${option.label}`);

            label.appendChild(labelText)     
            label.appendChild(input);

            // Add event listener for each radio button
            input.addEventListener('click', () => tallyScore(option.label, option.weight, option.group));
        
        });

        containerDiv.appendChild(label);
        imageContainer.appendChild(containerDiv);
    });
}

// add event listenter to the submit button
const submitBtn = document.getElementById('submitButton');

// Add event listener to calculate score
submitBtn.addEventListener('click', calculateScore);

// function to calculate and tally scores
function tallyScore(label, weight, group) {
    console.log(label);

    const existingItem = weightTotals.find(item => item.group === group);

    if(existingItem) {
        weightTotals.splice(weightTotals.indexOf(existingItem), 1);
    }
    
    const weightTotal = {
        label:  label,
        weight: weight,
        group: group
    }
    weightTotals.push(weightTotal);
}

function calculateScore() {
    // Extract the weights into an array
    const weightsArray = weightTotals.map(item => item.weight);

    // Calculate the count of each weight
    const weightCounts = weightsArray.reduce((counts, weight) => {
        counts[weight] = (counts[weight] || 0) + 1;
        return counts;
    }, {});

    // Log or display the histogram data
    console.log('Weight Counts:', weightCounts);

    // Calculate the total sum of counts
    const totalSum = Object.values(weightCounts).reduce((sum, count) => sum + count, 0);

    // Log or display the total sum of counts
    console.log('Total Sum of Counts:', totalSum);

    // Optionally, you can create a histogram chart here
    // using a charting library or your preferred method
}