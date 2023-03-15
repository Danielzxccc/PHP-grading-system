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
      $('.coursedescription').text(json.description)
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
    console.log(e.target.value)
    getSubjectInfo(e.target.value)
  })

  $('#btnAddSubject').on('click', function () {
    Swal.fire({
      icon: 'success',
      title: 'Added Successfully',
      allowOutsideClick: false,
      focusConfirm: true,
      allowEscapeKey: false,
      timer: 1500,
    })
  })
})
