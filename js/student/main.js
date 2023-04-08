function getIndividualGrades() {
  $.ajax({
    url: '../routes/student/getIndividualGrades.php',
    method: 'post',
    data: {
      getIndividualGrades: null,
    },
    success: function (data) {
      console.log(data)
      $('#getStudentGrades').html(data)
    },
  })
}

function submitFilter(schoolyear, semester) {
  $.ajax({
    url: '../routes/student/getIndividualGrades.php',
    method: 'post',
    data: {
      getIndividualGrades: null,
      schoolyear: schoolyear,
      semester: semester,
    },
    success: function (data) {
      console.log(data)
      $('#getStudentGrades').html(data)
    },
  })
}

$(document).ready(function () {
  getIndividualGrades()

  $('#submitFilter').submit(function (e) {
    e.preventDefault()
    const schoolyear = $('#schoolyear').val()
    const semester = $('#semester').val()

    submitFilter(schoolyear, semester)
  })
})
