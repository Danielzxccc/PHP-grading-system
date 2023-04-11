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

function getIncomingStudents() {
  $.ajax({
    url: '../routes/admin/getStudents.php',
    method: 'post',
    data: {
      getIncomingStudents: null,
    },
    success: function (data) {
      $('#incomingStudents').html(data)
    },
  })
}

function getStudentGrades(id) {
  $.ajax({
    url: '../routes/admin/getAllStudentGrades.php',
    method: 'post',
    data: {
      getStudentGrades: null,
      id: id,
    },
    success: function (data) {
      $('#getStudentGrades').html(data)
    },
  })
}

function acceptStudent(id) {
  $.ajax({
    url: '../routes/admin/studentSubjectsActions.php',
    method: 'post',
    data: {
      acceptStudent: null,
      id: id,
    },
    success: function (data) {
      if (data.success)
        return Swal.fire({
          icon: 'success',
          title: `${data.message}`,
          allowOutsideClick: false,
          focusConfirm: true,
          allowEscapeKey: false,
          timer: 1500,
        })
      Swal.fire({
        icon: 'error',
        title: `${data.message}`,
        allowOutsideClick: false,
        focusConfirm: true,
        allowEscapeKey: false,
        timer: 1500,
      })
    },
  })
}

function releaseGrades(id) {
  $.ajax({
    url: '../routes/admin/studentSubjectsActions.php',
    method: 'post',
    data: {
      releaseGrades: null,
      id: id,
    },
    success: function (data) {
      console.log(data)
      if (data.success)
        return Swal.fire({
          icon: 'success',
          title: `${data.message}`,
          allowOutsideClick: false,
          focusConfirm: true,
          allowEscapeKey: false,
          timer: 1500,
        })

      Swal.fire({
        icon: 'error',
        title: `${data.message}`,
        allowOutsideClick: false,
        focusConfirm: true,
        allowEscapeKey: false,
        timer: 1500,
      })
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
      $('.studentname').text(
        json.lastname + ', ' + json.firstname + ' ' + json.middlename
      )
      $('.studentcourse').text(json.course)
      $('.studentid').text(json.studentid)
      $('#studentModal').modal('hide')
    },
  })
}

function getSubjectInfo(id, type = 'add') {
  $.ajax({
    url: '../routes/admin/getStudents.php',
    method: 'post',
    data: {
      getSubjectInfo: null,
      id: id,
    },
    success: function (data) {
      const json = JSON.parse(data)
      if (type === 'add') {
        $('.coursedescription').text(json.description)
        $('.subjectunit').text(json.units)
      } else if (type === 'get') {
        $('#selectsubject').val(json.id)
        $('.updatedescription').text(json.description)
      } else {
        $('.updatedescription').text(json.description)
      }
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
    },
    success: function (data) {
      if (data === '')
        return $('#studentSubjectList').html('<td colspan="7">No Subjects</>')
      $('#studentSubjectList').html(data)
    },
  })
}

// adding subject
function addSubject(studentid, subjectid) {
  $.ajax({
    url: '../routes/admin/addStudentSubject.php',
    method: 'post',
    data: {
      addStudentSubject: null,
      studentid: studentid,
      subjectid: subjectid,
    },
    success: function (data) {
      if (data.success) {
        return Swal.fire({
          icon: 'success',
          title: `${data.message}`,
          allowOutsideClick: false,
          focusConfirm: true,
          allowEscapeKey: false,
          timer: 1500,
        })
      }
      Swal.fire({
        icon: 'error',
        title: `${data.message}`,
        allowOutsideClick: false,
        focusConfirm: true,
        allowEscapeKey: false,
        timer: 1500,
      })
    },
  })
}

function updateSubject(subject) {
  const { id, studentid, subjectid } = subject

  $.ajax({
    url: '../routes/admin/studentSubjectsActions.php',
    method: 'post',
    data: {
      updateStudentSubject: null,
      id: id,
      studentid: studentid,
      subjectid: subjectid,
    },
    success: function (data) {
      $('#updateSubject').modal('hide')
      if (data.success) {
        return Swal.fire({
          icon: 'success',
          title: `${data.message}`,
          allowOutsideClick: false,
          focusConfirm: true,
          allowEscapeKey: false,
          timer: 1500,
        })
      }
      Swal.fire({
        icon: 'error',
        title: `${data.message}`,
        allowOutsideClick: false,
        focusConfirm: true,
        allowEscapeKey: false,
        timer: 1500,
      })
    },
  })
}

function deleteSubject(id) {
  $.ajax({
    url: '../routes/admin/studentSubjectsActions.php',
    method: 'post',
    data: {
      deleteStudentSubject: null,
      id: id,
    },
    success: function (data) {
      if (data.success) {
        return Swal.fire({
          icon: 'success',
          title: `${data.message}`,
          allowOutsideClick: false,
          focusConfirm: true,
          allowEscapeKey: false,
          timer: 1500,
        })
      }
      Swal.fire({
        icon: 'error',
        title: `${data.message}`,
        allowOutsideClick: false,
        focusConfirm: true,
        allowEscapeKey: false,
        timer: 1500,
      })
    },
  })
}

//add delay to search
function debounce(cb, delay = 500) {
  let timeout

  return (...args) => {
    if (timeout) clearTimeout(timeout)

    timeout = setTimeout(() => {
      cb(...args)
    }, delay)
  }
}

const searchStudent = debounce((searchTerm) => {
  getAllStudents(searchTerm)
})

$(document).ready(function () {
  // fetch student on load to modal
  getAllStudents()

  //selecting student
  $(document).on('click', '#btnSelectStudent', function () {
    const selectedStudent = $('.student-radio:checked').val()
    if (selectedStudent) {
      getStudentInfo(selectedStudent)
      getStudentSubjects(selectedStudent)
      getStudentGrades(selectedStudent)
      $('#releaseGrades').removeClass('d-none')
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
  //search student
  $('#searchStudent').on('input', function (e) {
    searchStudent(e.target.value)
  })

  //select subject
  $('#subject').on('change', function (e) {
    if (e.target.value === '') {
      $('.coursedescription').text('')
      $('.subjectunit').text('')
    }
    getSubjectInfo(e.target.value)
  })

  $('#selectsubject').on('change', function (e) {
    if (e.target.value === '') {
      $('.updatedescription').text('')
    }
    getSubjectInfo(e.target.value, 'update')
  })

  //adding subject
  $('#btnAddSubject').on('click', function () {
    const studentid = $('#studentid').val()
    const subjectid = $('#subject').val()

    if (!studentid)
      return Swal.fire({
        icon: 'error',
        title: 'Please select a student',
        allowOutsideClick: false,
        focusConfirm: true,
        allowEscapeKey: false,
        timer: 1500,
      })

    if (!subjectid)
      return Swal.fire({
        icon: 'error',
        title: 'Please select a subject',
        allowOutsideClick: false,
        focusConfirm: true,
        allowEscapeKey: false,
        timer: 1500,
      })

    addSubject(studentid, subjectid)
    getStudentSubjects(studentid)
  })

  // CRUD OPERATIONS
  // UDPATE SUBJECT
  $('.btnUpdate').on('click', function () {
    const selectedSubject = $('.subjectList:checked').val()
    const subjectUpdateID = $('.subjectList:checked').data('id')
    getSubjectInfo(subjectUpdateID, 'get')
    if (!selectedSubject) return
    $('#updateSubject').modal('show')
  })

  $('#updateSubjectForm').on('submit', function (e) {
    e.preventDefault()
    const selectedSubject = $('.subjectList:checked').val()
    const studentid = $('#studentid').val()
    const subjectid = $('#selectsubject').val()

    if (!subjectid)
      return Swal.fire({
        icon: 'error',
        title: 'Please select a subject',
        allowOutsideClick: false,
        focusConfirm: true,
        allowEscapeKey: false,
        timer: 1500,
      })
    updateSubject({
      id: selectedSubject,
      studentid: studentid,
      subjectid: subjectid,
    })
    getStudentSubjects(studentid)
  })

  // delete events
  $('.btnDelete').on('click', function () {
    const selectedSubject = $('.subjectList:checked').val()
    const studentid = $('#studentid').val()
    if (!selectedSubject) return
    Swal.fire({
      title: 'Are you sure you want to delete?',
      icon: 'warning',
      showCancelButton: true,
      confirmButtonText: 'Yes',
    }).then((result) => {
      if (result.isConfirmed) {
        deleteSubject(selectedSubject)
        getStudentSubjects(studentid)
        getStudentGrades(studentid)
      }
    })
  })

  // release grades
  $('#releaseGrades').click(function () {
    const studentid = $('#studentid').val()
    Swal.fire({
      title: 'Are you sure you want to release these grades?',
      icon: 'warning',
      showCancelButton: true,
      confirmButtonText: 'Yes',
    }).then((result) => {
      if (result.isConfirmed) {
        releaseGrades(studentid)
        getStudentGrades(studentid)
      }
    })
  })

  // accept students
  $('#acceptStudentButton').click(function () {
    $('#acceptStudents').modal('show')
    getIncomingStudents()
  })

  $(document).on('click', '.accept-btn', function () {
    const id = $(this).data('id')
    const name = $(this).data('name')
    Swal.fire({
      title: `Are you sure you want to accept ${name}?`,
      icon: 'warning',
      showCancelButton: true,
      confirmButtonText: 'Yes',
    }).then((result) => {
      if (result.isConfirmed) {
        acceptStudent(id)
        getIncomingStudents()
      }
    })
  })

  // print functions
  $('.btnPrint').click(function () {
    $('#printGrade').printThis({
      importCSS: true,
      printDelay: 333,
      afterPrint: function () {
        window.close()
      },
    })
  })
})
