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

    // build the table for the questions the  studen hasn't answered
    displayUnansweredTable(studentPercentages);

    // get the most answered question
    const mostAnsweredQuestions = JSON.stringify(data.mostAnsweredQuestions);
    displayMostAnsweredQuestion(mostAnsweredQuestions);
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
        family: 'Courier New, Monospace',
        size: 12,
      },
      title: 'Unanswered Questions',
    },
    margin: { t: 30, b: 50, l: 0, r: 0 }, // Set all margins to zero
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
    width: 450,  // Set the width of the chart
    height: 200,  // Set the height of the chart.
  
  };

  const data = [trace];
  Plotly.newPlot('chartDiv', data, layout, {displayModeBar: false});
}

function displayUnansweredTable(studentPercentages) {

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
  const layout_table  = {
    
    font: { 
      family: 'Arial, Serif',
      size: 10,
    },
    height: 300,
    width: 450,
    title: '<b>Total number of unanswered questions by students</b>',
    margin: { t:0, b: 0, l: 0, r: 0 }, // Set all margins to zero
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
      values: [studentNames, unansweredQuestions],
      align: ["center", "center"],
      line: {color: "black", width: 1},
      font: {family: "Arial Bold", size: 10, color: ["black"]},
      height: 20,
    },
 
  }];


  Plotly.newPlot('tableDiv', tableData, layout_table, {displayModeBar: false});

}

function displayMostAnsweredQuestion(mostAnsweredQuestions) {


  const jsonData = JSON.parse(mostAnsweredQuestions);
  const questionFrequencies = Object.entries(jsonData).map(([questionId, frequency]) => ({
    questionId, frequency: parseInt(frequency),
  }));

  // Sorting by frequency in descending order
  questionFrequencies.sort((a, b) => b.frequency - a.frequency);
  
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
    title: 'Question Number Frequencies',
    xaxis: {
      title: 'Frequency',
      range: [1,30],
    },
    yaxis: {
      title: 'Question Number',
    },
    width: 1000,
  };
  
  const chartData = [trace];
  Plotly.newPlot('mostAnsweredQuestions', chartData, layout);
}

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
    margin: { t: 30, b: 50, l: 0, r: 0 }, // Set all margins to zero
    width: 600,
    height: 1000,
    title: 'Most Selected Options By Student',
  };

  // build the table
  const tableData = [{
    type: 'table',
    text: '<b>Total number of unanswered questions by students</b>',
    name: 'Total number of unanswered questions by students',
    columnwidth:[50,30,30,10],
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
      align: ["center", "left"],
      line: {color: "black", width: 1},
      font: {family: "Arial Bold", size: 10, color: ["black"]},
      height: 20,
      },
 
  }];

  Plotly.newPlot('mostAnsweredOptionByStudent', tableData, layout_table, {displayModeBar: false});
  

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
      family: 'Courier New, Monospace',
      size: 14,
    },
    margin: { t: 150, b: 0, l: 0, r: 0 }, // Set all margins to zero
    width: 450,
  };

  // build the table
  const tableData = [{
    type: 'table',
    text: '<b>Total number of unanswered questions by period</b>',
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

  Plotly.newPlot('mostAnsweredOptionByPeriod', tableData, layout_table, {displayModeBar: false})

}