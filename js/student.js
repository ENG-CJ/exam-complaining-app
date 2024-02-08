// loading function calls
readStudents(displayStudentData);
readSemesters();
readClasses();


// variables

// events related modals
$(".createStudent").click(() => {
  $(".save").text("Save");
  $(".id-body").attr("hidden", false);
  $(".password-body").attr("hidden", false);

  $(".studentsModal").modal("show");
});
$(".close").click(() => {
  $(".studentsModal").modal("hide");
});

// events related functionalities
$(document).on("click", ".image-view", function () {
  var image = $(this).attr("imageName");
  $(".img-body").html(`
        <img src='../uploads/${image}' class='img-fluid'/>
    `);
  $(".imageModal").modal("show");
});

$(document).on("click", "a.deleteStudent", function () {
  var id = $(this).attr("id");
  deleteStudentData(id, (response) => {
    alert(response.message);
    readStudents(displayStudentData);
  });
});

$(document).on("click", "a.updatePassword", function () {
  var id = $(this).attr("studentID");
  getStudentPassword(id, (response) => {
    $(".newPassword").val(response.password);
    $(".hidden-id").val(response.id);
    $(".passwordModal").modal("show");
  });
});

//? updating student data
$(document).on("click", "a.editStudent", function () {
  var id = $(this).attr("id");
  getSingleStudentData(id, populateStudentInModal);
});

$(".save").click(() => {
  if ($(".save").text().toLowerCase() == "save") createStudent();
  else updateStudent();
});

//? four digit password generating
$(".generate").click((e) => {
  e.preventDefault();
  generateFourDigitPassword((response) => {
    $(".password").val(response.password);
    $(".newPassword").val(response.password);
  });
});

$(".updatePassword").click((e) => {
  e.preventDefault();
  updateStudentPassword(
    $(".hidden-id").val(),
    $(".newPassword").val(),
    (response) => {
      alert(response.message);
    }
  );
});

$(".search").on("keyup", function (event) {
 if (event.which === 13 && $(this).val().trim() !== "") {
   event.preventDefault();
   readStudentsWithIdentifier($(this).val(), displayStudentData);
 } else if ($(this).val().trim() === "") {
   event.preventDefault();
   readStudents(displayStudentData);
 }
 
});

// functions (Requests)

const formData = () => {
  var data = new FormData();
  data.append("id", $(".id").val());
  data.append("name", $(".name").val());
  data.append("gender", $(".gender").val());
  data.append("mobile", $(".mobile").val());
  data.append("address", $(".address").val());
  data.append("semester", $(".semester").val());
  data.append("class", $(".class").val());
  data.append("password", $(".password").val());
  data.append("action", "createStudent");
  data.append("profile", $(".profile")[0].files[0]);
  return data;
};

const formDataAsUpdatedData = () => {
  var data = new FormData();
  data.append("id", $(".hidden-id").val());
  data.append("name", $(".name").val());
  data.append("gender", $(".gender").val());
  data.append("mobile", $(".mobile").val());
  data.append("address", $(".address").val());
  data.append("semester", $(".semester").val());
  data.append("class", $(".class").val());
  data.append("action", "updateStudentData");
  data.append("isSelectedProfile", "true");
  data.append("profile", $(".profile")[0].files[0]);
  return data;
};

function createStudent() {
  $.ajax({
    method: "POST",
    dataType: "json",
    contentType: false,
    cache: false,
    processData: false,
    data: formData(),
    url: "../api/student.api.php",
    success: (res) => {
      readStudents(displayStudentData);
      console.log(res);
    },
    error: (err) => {
      console.log(err);
    },
  });
}

function readStudents(displayData) {
  $.ajax({
    method: "POST",
    dataType: "json",
    data: { action: "readStudents" },
    url: "../api/student.api.php",
    success: (res) => {
      displayData(res.data);
    },
    error: (err) => {
      console.log(err);
    },
  });
}

// callback function after student data has been fetched
function displayStudentData(data) {
  console.log(data);
  var tr = "<tr>";
  $(".studentsTable tbody").html("");
  data.forEach((student) => {
    tr += `<td>${student.id}</td>`;
    tr += `<td>
        <img imageName='${student.image}' title ='click to view this image' src='../uploads/${student.image}' class='img-fluid rounded-circle img-thumbnail image-view' style='width: 40px; height: 40px'/>
        </td>`;
    tr += `<td>${student.studentName}</td>`;
    tr += `<td>${student.mobile}</td>`;
    tr += `<td>${student.semester}</td>`;
    tr += `<td>${student.class}</td>`;
    tr += `<td>
            <a studentID = '${student.id}' class='btn btn-brand text-dark btn-rounded updatePassword' title='update password for this student'>Update</a>
        </td>`;
    tr += `<td>
            <a  id ='${student.id}' class='btn btn-secondary text-light deleteStudent'>Remove</a>
            <a id ='${student.id}' class='btn btn-success text-light editStudent'>Edit</a>
        </td>`;
    tr += "</tr>";
  });

  $(".studentsTable tbody").html(tr);
}

function readStudentsWithIdentifier(identifier, displayData) {
  $.ajax({
    method: "POST",
    dataType: "json",
    data: { action: "readStudentsWithIdentifier", value: identifier },
    url: "../api/student.api.php",
    success: (res) => {
      displayData(res.data);
    },
    error: (err) => {
      console.log(err);
    },
  });
}
function readSemesters() {
  $.ajax({
    method: "POST",
    dataType: "json",
    data: { action: "readSemesters" },
    url: "../api/semester.api.php",
    success: (res) => {
      var option = "<option value=''>Select</option>";
      res.data.forEach((value) => {
        option += `<option value="${value.s_id}">${value.name}</option>`;
      });
      $(".semester").html(option);
    },
    error: (err) => {
      console.log(err);
    },
  });
}
function readClasses() {
  $.ajax({
    method: "POST",
    dataType: "json",
    data: { action: "readClasses" },
    url: "../api/classes.api.php",
    success: (res) => {
      var option = "<option value=''>Select</option>";
      res.data.forEach((value) => {
        option += `<option value="${value.c_id}">${value.name}</option>`;
      });
      $(".class").html(option);
    },
    error: (err) => {
      console.log(err);
    },
  });
}

function deleteStudentData(id, response) {
  $.ajax({
    method: "POST",
    dataType: "json",
    data: { action: "deleteStudent", id: id },
    url: "../api/student.api.php",
    success: (res) => {
      response(res);
    },
    error: (err) => {
      console.log(err);
    },
  });
}
function updateStudent() {
  // checking if there is file
  if ($(".profile")[0].files.length > 0)
    updateStudentData(formDataAsUpdatedData(), true);
  else {
    const studentDataAsJson = {
      id: $(".hidden-id").val(),
      name: $(".name").val(),
      gender: $(".gender").val(),
      mobile: $(".mobile").val(),
      address: $(".address").val(),
      semester: $(".semester").val(),
      class: $(".class").val(),
      isSelectedProfile: "false",
      action: "updateStudentData",
    };
    updateStudentData(studentDataAsJson);
  }
}

function updateStudentData(data, hasFile = false) {
  if (!hasFile)
    $.ajax({
      method: "POST",
      dataType: "json",
      data: data,
      url: "../api/student.api.php",
      success: (res) => {
        readStudents(displayStudentData);
        alert(res.message);
      },
      error: (err) => {
        console.log(err);
      },
    });
  else
    $.ajax({
      method: "POST",
      dataType: "json",
      contentType: false,
      cache: false,
      processData: false,
      data: data,
      url: "../api/student.api.php",
      success: (res) => {
       
        readStudents(displayStudentData);
        alert(res.message);
      },
      error: (err) => {
        console.log(err);
      },
    });
}
function updateStudentPassword(id, newPassword, response) {
  $.ajax({
    method: "POST",
    dataType: "json",
    data: { action: "updateStudentPassword", id: id, password: newPassword },
    url: "../api/student.api.php",
    success: (res) => {
      response(res);
    },
    error: (err) => {
      console.log(err);
    },
  });
}

function generateFourDigitPassword(displayPassword) {
  $.ajax({
    method: "POST",
    dataType: "json",
    data: { action: "generateFourDigitPassword", min: 1000, max: 9999 },
    url: "../api/student.api.php",
    success: (res) => {
      displayPassword(res);
    },
    error: (err) => {
      console.log(err);
    },
  });
}
function getStudentPassword(id, displayPassword) {
  $.ajax({
    method: "POST",
    dataType: "json",
    data: { action: "fetchStudentPassword", id: id },
    url: "../api/student.api.php",
    success: (res) => {
      displayPassword(res);
    },
    error: (err) => {
      console.log(err);
    },
  });
}

function getSingleStudentData(id, displayDataInModal) {
  $.ajax({
    method: "POST",
    dataType: "json",
    data: { action: "getSingleStudentData", id: id },
    url: "../api/student.api.php",
    success: (res) => {
      displayDataInModal(res.data[0]);
    },
    error: (err) => {
      console.log(err);
    },
  });
}

/**
 * callback function after single student data has been fetched
 * @param {object} data  student data
 *
 */
function populateStudentInModal(data) {
  $(".id-body").attr("hidden", true);
  $(".password-body").attr("hidden", true);
  $(".name").val(data.name);
  $(".gender").val(data.gender);
  $(".mobile").val(data.mobile);
  $(".address").val(data.address);
  $(".semester").val(data.semester_id);
  $(".class").val(data.class_id);
  $(".hidden-id").val(data.id);

  $(".save").text("Edit");
  $(".studentsModal").modal("show");
}
