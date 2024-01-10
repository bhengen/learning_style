// Use the fetch API to make a GET request to the specified URL
fetch('get_data.php')
  .then(response => {
    // Check if the response status is OK (status code 200-299)
    if (!response.ok) {
      throw new Error('Network response was not ok');
    }
    // Parse the response as JSON and return the result
    return response.json();
  })  .then(data => {
    
    // Handle the JSON data here
 
    // get the percentage of questions completed by student completion
    const studentPercentages = JSON.stringify(data.percentCompleted);
    displayStudentPercentage(studentPercentages)
    //document.getElementById('studentPercentages').innerText = studentPercentages;

    // get the questions that the student hasn't completed yet
    const unansweredQuestions = JSON.stringify(data.percentCompleted);
    // build the table for the questions the  studen hasn't answered
    displayUnansweredTable(unansweredQuestions);

    // get the answer frequency
    const questionFrequency = JSON.stringify(data.mostAnsweredQuestions);
    displayQuestionFrequency(questionFrequency);
    //document.getElementById('mostAnsweredQuestions').innerText = mostAnsweredQuestions

    // get the most answered option by student
    const mostAnsweredOptionByStudent = JSON.stringify(data.mostAnsweredOptionByStudent);
    displayMostAnsweredOptionByStudent(mostAnsweredOptionByStudent);
    //document.getElementById('mostAnsweredOptionByStudent').innerText = mostAnsweredOptionByStudent;
    
    // get the most answered option by period
    const mostAnsweredOptionByPeriod = JSON.stringify(data.mostAnsweredOptionByPeriod);
    displayMostAnsweredOptionByPeriod(mostAnsweredOptionByPeriod);
    //document.getElementById('mostAnsweredOptionByPeriod').innerText = mostAnsweredOptionByPeriod;
  })
  .catch(error => {
    // Handle any errors that occurred during the fetch
    console.error('Error fetching data:', error);
  });


function displayStudentPercentage(studentPercentages) {
  
  const jsonData = JSON.parse(studentPercentages);

  // Arrays to store extracted data
  let studentNames = [];
  let pctCompleted = [];
  let unansweredQuestions = [];

  // Extracting data from JSON
  jsonData.forEach(function(item) {
    studentNames.push(item.student_name);
    pctCompleted.push(item.pct_completed);
    unansweredQuestions.push(item.unanswered_questions);

  });

  // build the bar chart
  const trace = {
    x: studentNames,
    y: pctCompleted,
    type: 'bar',
    text: pctCompleted.map(value => value + '%'), // Format as percentage
    texttemplate: '%{text}', // Use the text template
    textposition: 'inside', // Position the text inside the bars
    marker: {
      textfont: { 
        font: {
          family: 'Arial Bold',
        },
        weight: 'bold' }, // Bold the text
    },
  };

  // configure the bar chart, title, size, etc.
  const layout = {
    title: {
      text: '<b>Percentage left for students to complete the assessment</b>',
      font: { 
        family: 'Arial, Serif',
        size: 14,
      },
      title: 'Unanswered Questions',
    },
    margin: { t: 30, b: 30, l: 20, r: 0 }, // Set all margins to zero
    xaxis: {
      family: 'Arial',
      size: 6,
      color: 'red',
    },
    yaxis: {
      family: 'Arial Bold',
      size: 8,
      color: '#000000',
    },
    width: 600,  // Set the width of the chart
    height: 300,  // Set the height of the chart.
  
  };

  const data = [trace];
  Plotly.newPlot('percent-left', data, layout, {displayModeBar: false});
}

// function to build the table for which question not answered by the student
function displayUnansweredTable(unansweredQuestions) {

 const jsonData = JSON.parse(unansweredQuestions);

  // Arrays to store extracted data
  let studentNames = [];
  let questions_not_answered = [];

  // Extracting data from JSON
  jsonData.forEach(function(item) {
    studentNames.push(item.student_name);
    questions_not_answered.push(item.unanswered_questions);
  });
  const layout_table  = {
    
    font: { 
      family: 'Arial, Serif',
      size: 12,
    },
    height: 300,
    width: 450,
    title: 'Questions Need To Be Answered.',
    margin: { t:30, b: 30, l: 10, r: 10}, // Set all margins to zero
   };

  // build the table
    const tableData = [{
    type: 'table',
     header: {
      values: ['Student Name', 'Question Number'],
      align: "center",
      line: {width: 1, color: 'black'},
      fill: {color: 'grey'},
      font: {family: "Arial Bold", size: 12, color: "white"},
      height: 20,
    },
    cells: {
      values: [studentNames, questions_not_answered],
      align: ["center", "center"],
      line: {color: "black", width: 1},
      font: {family: "Arial Bold", size: 10, color: ["black"]},
      height: 20,
    },
 
  }];


  Plotly.newPlot('questions_not_answered', tableData, layout_table, {displayModeBar: false});

}

// function to display the frequency of questions answered
function displayQuestionFrequency(questionFrequency) {


  const jsonData = JSON.parse(questionFrequency);


  const questionFrequencies = Object.entries(jsonData).map(([questionId, frequency]) => ({
    questionId, frequency: parseInt(frequency),
  }));

  
  // Sorting by frequency in descending order
  questionFrequencies.sort((a, b) => b.frequency - a.frequency);

  console.log(questionFrequencies);

  // Extracting data for Plotly chart
  const questionIds = questionFrequencies.map(item => item.questionId);
  const frequencies = questionFrequencies.map(item => item.frequency);
  
  // Creating a horizontal bar chart with Plotly
  const trace = {
    x: frequencies,
    y: questionIds,
    type: 'bar',
    orientation: 'h',
  };
  
  const layout = {
    title: 'Frequency of Question Numbers',
    xaxis: {
      title: 'Frequency',
      range: [1,30],
    },
    yaxis: {
      title: 'Question Number',
      autorange: 'reversed',
    },
    width: 1000,
    height: 1000,
    paper_bgcolor: 'rgba(255,255,255,0)',
    plot_bgcolor: 'rgba(255,255,255,0)',
  };
  
  const chartData = [trace];
  Plotly.newPlot('frequency', chartData, layout);
}

// function to  display the most ansewred option by stuiden
function displayMostAnsweredOptionByStudent(mostAnsweredOptionByStudent) {
  
  const jsonData = JSON.parse(mostAnsweredOptionByStudent);

  let studentNames = [];
  let totalOptionA = [];
  let totalOptionB = [];
  let columnTotal = [];

 // Extracting data from JSON
  jsonData.forEach(function(item) {
      studentNames.push(item.student_name);
      totalOptionA.push(item.total_option_a);
      totalOptionB.push(item.total_option_b);
      columnTotal.push(item.column_total);
  });

  const layout_table  = {
    font: { 
      family: 'Arial, Serif',
      size: 12,
    },
    text: '<b>Total number of Options (A or B) by students</b>',
    margin: { t: 30, b: 30, l: 10, r: 10 }, // Set all margins to zero
    width: 600,
    height: 750,
    title: 'Most Selected Options By Student',
  };

  // build the table
  const tableData = [{
    type: 'table',
    name: 'Total number of Options (A or B) by students',
    columnwidth:[50,25,25,25],
    header: {
      values: ['Student Name', 'Totals Options A', 'Totals Option B', 'Total'],
      align: "center",
      line: {width: 1, color: 'black'},
      fill: {color: 'grey'},
      font: {family: "Arial Bold", size: 12, color: "white"},
      height: 20,
    },
    cells: {
      values: [studentNames, totalOptionA,totalOptionB, columnTotal],
      align: ["center", "center"],
      line: {color: "black", width: 1},
      font: {family: "Arial Bold", size: 10, color: ["black"]},
      height: 20,
      },
 
  }];

  Plotly.newPlot('most-answers-selected-by-student', tableData, layout_table, {displayModeBar: false});
  
}

function displayMostAnsweredOptionByPeriod(mostAnsweredOptionByPeriod) {
  
  const optionByPeriod = JSON.parse(mostAnsweredOptionByPeriod);

  let classPeriod = [];
  let totalOptionA= [];
  let totalOptionB = [];
  let columnTotal = [];

 // Extracting data from JSON
  optionByPeriod.forEach(function(item) {
      classPeriod.push(item.class_period);
      totalOptionA.push(item.total_option_a);
      totalOptionB.push(item.total_option_b);
      columnTotal.push(item.column_total);
  });

  const layout_table  = {
     font: { 
       family: 'Arial, Serif',
       size: 12,
     },
    title: 'Total number of most answered option (a or b) by period',
    margin: { t: 40, b: 0, l: 10, r: 10 }, // Set all margins to zero
    width: 450,
    height: 350,
  };

  // build the table
  const tableData = [{
    type: 'table',
    header: {
      values: ['Class Period', 'A Totals', 'B Totals', 'Total'],
      align: "center",
      line: {width: 1, color: 'black'},
      fill: {color: 'grey'},
      font: {family: "Arial Bold", size: 12, color: "white"},
      height: 20,
    },
    cells: {
      values: [classPeriod, totalOptionA,totalOptionB, columnTotal],
      align: ["center", "center"],
      line: {color: "black", width: 1},
      font: {family: "Arial Bold", size: 10, color: ["black"]},
      height: 20,
    },
 
  }];

  Plotly.newPlot('most-options-selected-by-period', tableData, layout_table, {displayModeBar: false})

}