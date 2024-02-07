// loading function calls
readSubjects(displaySubjectsData);
readSemesters();

// variables

// events related modals
$(".createSubject").click(() => {
  $(".save").text("Save");
  $(".subjectsModal").modal("show");
});

// events related functionalities
$(document).on("click", "a.deleteSubject", function () {
  var id = $(this).attr("id");
  deleteSubjectData(id, (response) => {
    alert(response.message);
    readSubjects(displaySubjectsData);
  });
});
$(document).on("change", ".filters", function () {
   
  if ($(".filters").val() == "") {
    readSubjects(displaySubjectsData);
    return;
  }
  readSubjectsWithIdentifier($(".filters").val(), (response) => {
    
    displaySubjectsData(response.data);
  });
});

//? updating student data
$(document).on("click", "a.editSubject", function () {
  var id = $(this).attr("id");
  getSingleSubjectData(id, populateSubjectInModal);
});

$(".save").click(() => {
  if ($(".save").text().toLowerCase() == "save") {
    const data = {
      name: $(".subject").val(),
      semester: $(".semester_id").val(),
      description: $(".description").val(),
      action: "createSubject",
    };
    createSubject(data);
  } else UpdateSubjectData();
});

// functions (Requests)

function createSubject(data) {
  $.ajax({
    method: "POST",
    dataType: "json",
    data: data,
    url: "../api/subject.api.php",
    success: (res) => {
      alert(res.message);
      readSubjects(displaySubjectsData);
    },
    error: (err) => {
      console.log(err);
    },
  });
}

function readSubjects(displayData) {
  $.ajax({
    method: "POST",
    dataType: "json",
    data: { action: "readSubjects" },
    url: "../api/subject.api.php",
    success: (res) => {
      displayData(res.data);
    },
    error: (err) => {
      console.log(err);
    },
  });
}

// callback function after student data has been fetched
function displaySubjectsData(data) {
  console.log(data);
  var tr = "<tr>";
  $(".subjectsTable tbody").html("");
  data.forEach((subject) => {
    tr += `<td>${subject.id}</td>`;

    tr += `<td>${subject.subject}</td>`;
    tr += `<td>${subject.semster}</td>`;
    tr += `<td>${subject.description}</td>`;
    tr += `<td>
            <a  id ='${subject.id}' class='btn btn-secondary text-light deleteSubject'>Remove</a>
            <a id ='${subject.id}' class='btn btn-success text-light editSubject'>Edit</a>
        </td>`;
    tr += "</tr>";
  });

  $(".subjectsTable tbody").html(tr);
}

function readSubjectsWithIdentifier(identifier, displayData) {
  $.ajax({
    method: "POST",
    dataType: "json",
    data: { action: "readSubjectsWithIdentifier", value: identifier },
    url: "../api/subject.api.php",
    success: (res) => {
        console.log("value ",res)
      displayData(res);
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
      var filtersOption = "<option value=''>Filter By Semester</option>";
      res.data.forEach((value) => {
        option += `<option value="${value.s_id}">${value.name}</option>`;
        filtersOption += `<option value="${value.name}">${value.name}</option>`;
      });
      $(".semester_id").html(option);
      $(".filters").html(filtersOption);
    },
    error: (err) => {
      console.log(err);
    },
  });
}

function deleteSubjectData(id, response) {
  $.ajax({
    method: "POST",
    dataType: "json",
    data: { action: "deleteSubjectData", id: id },
    url: "../api/subject.api.php",
    success: (res) => {
      response(res);
    },
    error: (err) => {
      console.log(err);
    },
  });
}
function UpdateSubjectData() {
  const subjectData = {
    id: $(".hidden-id").val(),
    subject: $(".subject").val(),
    semester_id: $(".semester_id").val(),
    description: $(".description").val(),
    action: "updateSubjectData",
  };
  $.ajax({
    method: "POST",
    dataType: "json",
    data: subjectData,
    url: "../api/subject.api.php",
    success: (res) => {
      readSubjects(displaySubjectsData);
      alert(res.message);
    },
    error: (err) => {
      console.log(err);
    },
  });
}

function getSingleSubjectData(id, displayDataInModal) {
  $.ajax({
    method: "POST",
    dataType: "json",
    data: { action: "getSingleSubjectData", id: id },
    url: "../api/subject.api.php",
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
function populateSubjectInModal(data) {
  $(".subject").val(data.name);
  $(".semester_id").val(data.semester_id);
  $(".description").val(data.description);
  $(".hidden-id").val(data.id);
  $(".save").text("Edit");
  $(".subjectsModal").modal("show");
}
