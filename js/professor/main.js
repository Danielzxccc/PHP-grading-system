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

function getStudentGrades(id) {
  $.ajax({
    url: '../routes/professor/getStudentGrades.php',
    method: 'post',
    data: {
      getStudentGrades: null,
      id: id,
    },
    success: function (data) {
      $('#studentGrades').html(data)
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

function getStudentGradeInfo(id, type) {
  $.ajax({
    url: '../routes/professor/getStudentGrades.php',
    method: 'post',
    data: {
      getOneStudentGrade: null,
      id: id,
    },
    success: function (data) {
      const json = JSON.parse(data)
      if (type === 'view') {
        $('#_monthly').val(json.monthly)
        $('#_firstprelim').val(json.firstprelim)
        $('#_secondpremlim').val(json.secondpremlim)
        $('#_midterm').val(json.midterm)
        $('#_prefinal').val(json.prefinal)
        $('#_final').val(json.final)
        $('#_average').val(json.average)
        $('#_grade').val(json.grades)
        $('#_graderemark').val(json.graderemark)
        $('#_studentViewSubject').text(json.coursecode + ' ' + json.description)
        $('#_semester').val(
          json.semester === 1 ? '1st Semester' : '2nd Semester'
        )
        $('#_studentViewGradeName').text(
          json.lastname + ' ' + json.firstname + ' ' + json.middlename
        )
      } else {
        $('#__id').val(json.id)
        $('#__monthly').val(json.monthly)
        $('#__firstprelim').val(json.firstprelim)
        $('#__secondpremlim').val(json.secondpremlim)
        $('#__midterm').val(json.midterm)
        $('#__prefinal').val(json.prefinal)
        $('#__final').val(json.final)
        $('#__graderemark').val(json.graderemark)
        $('#__studentViewSubject').text(
          json.coursecode + ' ' + json.description
        )
        $('#__semester').val(json.semester)
        $('#__studentViewGradeName').text(
          json.lastname + ' ' + json.firstname + ' ' + json.middlename
        )
      }
    },
  })
}

function editStudentGrade(data) {
  $.ajax({
    url: '../routes/professor/studentGradeActions.php',
    method: 'post',
    data: data,
    success: function (res) {
      $('#editGradeModal').modal('hide')
      if (res.success) {
        return Swal.fire({
          icon: 'success',
          title: `${res.message}`,
          allowOutsideClick: false,
          focusConfirm: true,
          allowEscapeKey: false,
          timer: 1500,
        })
      }
      Swal.fire({
        icon: 'error',
        title: `${res.message}`,
        allowOutsideClick: false,
        focusConfirm: true,
        allowEscapeKey: false,
        timer: 1500,
      })
    },
  })
}

function deleteStudentGrade(id) {
  $.ajax({
    url: '../routes/professor/studentGradeActions.php',
    method: 'post',
    data: {
      deleteStudentGrade: null,
      id: id,
    },
    success: function (res) {
      if (res.success) {
        return Swal.fire({
          icon: 'success',
          title: `${res.message}`,
          allowOutsideClick: false,
          focusConfirm: true,
          allowEscapeKey: false,
          timer: 1500,
        })
      }
      Swal.fire({
        icon: 'error',
        title: `${res.message}`,
        allowOutsideClick: false,
        focusConfirm: true,
        allowEscapeKey: false,
        timer: 1500,
      })
    },
  })
}

function resetGradeForm() {
  $('#monthly').val('')
  $('#firstprelim').val('')
  $('#secondpremlim').val('')
  $('#midterm').val('')
  $('#prefinal').val('')
  $('#final').val('')
  $('#graderemark').val('')
}

$(document).ready(function () {
  getAllStudents()

  //selecting student
  $(document).on('click', '#btnSelectStudent', function () {
    const selectedStudent = $('.student-radio:checked').val()
    if (selectedStudent) {
      getStudentInfo(selectedStudent)
      getStudentSubjects(selectedStudent)
      getStudentGrades(selectedStudent)
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
    const selectedStudent = $('.student-radio:checked').val()
    const selectedSubjectId = $('#studentsubjectid option:selected')
    const dataSubjectId = selectedSubjectId.data('id')
    $.ajax({
      url: '../routes/professor/addGrade.php',
      method: 'post',
      data: {
        addStudentGrade: '1',
        studentsubjectid: dataSubjectId,
        monthly: $('#monthly').val(),
        firstprelim: $('#firstprelim').val(),
        secondpremlim: $('#secondpremlim').val(),
        midterm: $('#midterm').val(),
        prefinal: $('#prefinal').val(),
        final: $('#final').val(),
        semester: $('#semester').val(),
        schoolyear: $('#schoolyear').val(),
        section: $('#section').val(),
        graderemark: $('#graderemark').val(),
      },
      success: function (res) {
        console.log(res)
        if (res.success) {
          getStudentGrades(selectedStudent)
          resetGradeForm()
          Swal.fire({
            icon: 'success',
            title: res.message,
            allowOutsideClick: false,
            focusConfirm: true,
            allowEscapeKey: false,
            timer: 2000,
          })
        } else {
          Swal.fire({
            icon: 'error',
            title: res.message,
            allowOutsideClick: false,
            focusConfirm: true,
            allowEscapeKey: false,
          })
        }
      },
    })
  })

  $('#editStudentSubjectForm').submit(function (e) {
    e.preventDefault()
    const selectedStudent = $('.student-radio:checked').val()
    const data = $(this).serializeArray()
    editStudentGrade(data)
    getStudentGrades(selectedStudent)
  })

  $(document).on('click', '.btn-view', function () {
    const id = $(this).data('id')
    getStudentGradeInfo(id, 'view')
    $('#viewGradeModal').modal('show')
  })

  $(document).on('click', '.btn-edit', function () {
    const id = $(this).data('id')
    getStudentGradeInfo(id, 'edit')
    $('#editGradeModal').modal('show')
  })

  $(document).on('click', '.btn-delete', function () {
    const id = $(this).data('id')
    const selectedStudent = $('.student-radio:checked').val()
    Swal.fire({
      icon: 'error',
      title: 'Are you sure you want to delete?',
      allowOutsideClick: false,
      focusConfirm: true,
      allowEscapeKey: false,
      showCancelButton: true,
    }).then((result) => {
      if (result.isConfirmed) {
        deleteStudentGrade(id)
        getStudentGrades(selectedStudent)
      }
    })
  })

  $('#editStudentSubjectForm').submit(function (e) {
    e.preventDefault()
  })

  // $('.grades').change(function () {
  //   const gradeInputs = document.querySelectorAll('.grades')
  //   const gradeValues = Array.from(gradeInputs)
  //     .map((input) => parseInt(input.value))
  //     .filter((value) => !isNaN(value))
  //   const gradeSum = gradeValues.reduce((acc, curr) => acc + curr, 0)
  //   const gradeAverage = gradeValues.length ? gradeSum / gradeValues.length : 0

  //   $('#average').val(gradeAverage.toFixed(2))
  // })
})
