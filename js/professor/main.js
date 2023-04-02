function getAllStudents(search = '') {
  $.ajax({
    url: '../routes/admin/getStudents.php',
    method: 'post',
    data: {
      getAllStudents: null,
      search: search,
    },
    success: function (data) {
      $('#studentList').html(data)
    },
  })
}

function getStudentInfo(id) {
  $.ajax({
    url: '../routes/admin/getStudents.php',
    method: 'post',
    data: {
      getStudentInfo: null,
      id: id,
    },
    success: function (data) {
      const json = JSON.parse(data)
      console.log(json)
      $('#studentid').val(json.id)
      $('#studentname').val(
        json.lastname + ', ' + json.firstname + ' ' + json.middlename
      )
      $('.studentname').val(
        json.lastname + ', ' + json.firstname + ' ' + json.middlename
      )
      $('.studentcourse').val(json.course)
      $('.studentid').text(json.studentid)
      $('#studentModal').modal('hide')
    },
  })
}

function getStudentSubjects(id) {
  $.ajax({
    url: '../routes/admin/getStudents.php',
    method: 'post',
    data: {
      getStudentSubjects: null,
      id: id,
      getCourseCode: '1',
    },
    success: function (data) {
      $('#studentsubjectid').html(data)
    },
  })
}

function getSubjectInfo(id) {
  $.ajax({
    url: '../routes/admin/getStudents.php',
    method: 'post',
    data: {
      getSubjectInfo: null,
      id: id,
    },
    success: function (data) {
      const json = JSON.parse(data)
      $('#coursedescription').val(json.description)
    },
  })
}

$(document).ready(function () {
  getAllStudents()

  //selecting student
  $(document).on('click', '#btnSelectStudent', function () {
    const selectedStudent = $('.student-radio:checked').val()
    if (selectedStudent) {
      getStudentInfo(selectedStudent)
      getStudentSubjects(selectedStudent)
    } else {
      Swal.fire({
        icon: 'error',
        title: 'Please select a student',
        allowOutsideClick: false,
        focusConfirm: true,
        allowEscapeKey: false,
        timer: 1500,
      })
    }
  })
  $('#studentsubjectid').change(function (e) {
    getSubjectInfo(e.target.value)
  })

  $('#gradeForm').submit(function (e) {
    e.preventDefault()
    if ($('#studentsubjectid').val() === '0')
      return Swal.fire({
        icon: 'error',
        title: 'Please select a subject',
        allowOutsideClick: false,
        focusConfirm: true,
        allowEscapeKey: false,
        timer: 1500,
      })
  })

  $('.grades').change(function () {
    const gradeInputs = document.querySelectorAll('.grades')
    const gradeValues = Array.from(gradeInputs)
      .map((input) => parseInt(input.value))
      .filter((value) => !isNaN(value))
    const gradeSum = gradeValues.reduce((acc, curr) => acc + curr, 0)
    const gradeAverage = gradeValues.length ? gradeSum / gradeValues.length : 0

    $('#average').val(gradeAverage.toFixed(2))
  })
})
