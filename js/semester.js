var btnAction = 'insert';

// loading all data
load_data();

// hidden semester id field
$("#s_id").hide();


// listening event handler to show modal
$("#showModal").on("click", function () {
    showModal()
});

// close modal
$("#closeModal").on("click", function () {
    hideModal();
})

// show modal
function showModal() {
    $("#semesterModal").modal('show');
}

// hide modal
function hideModal() {
    $("#semesterModal").modal('hide');
}

// reset form fields after submitted data
function resetForm() {
    $("#semesterForm")[0].reset();
}

// clear table data 
function clearData() {
    $('#tableData tr').html('');
}
$('#semesterForm').on('submit', (e) => {
    e.preventDefault();
    const s_id = $('#s_id').val();
    const name = $('#name').val();
    const description = $('#description').val();
    let sendingData = {};
    if (btnAction === 'insert') {
        sendingData = {
            'name': name,
            'description': description,
            'action': 'create_semester_api'
        }
    }
    else {
        sendingData = {
            's_id': s_id,
            'name': name,
            'description': description,
            'action': 'update_semester_api'
        }
    }

    $.ajax({
        method: 'POST',
        dataType: 'json',
        url: '../api/semester.api.php',
        data: sendingData,
        success: (res) => {
            const status = res.status;
            const message = res.data;
            if (status) {
                alert(message)
                btnAction = 'insert';
                load_data();
            } else {
                alert(message);
            }
        },
        error: (err) => {
            console.log('Failed to send form data', err.responseText);
        }
    })
})

function load_data() {
    clearData();

    const sendingData = {
        'action': 'read_all_semester_api'
    }
    $.ajax({
        method: 'POST',
        dataType: 'json',
        url: '../api/semester.api.php',
        data: sendingData,
        success: (res) => {
            console.log('res data', res.data);
            const status = res.status;
            const response = res.data;
            tr = '';
            th = '';
            if (status) {
                response.forEach(element => {
                    tr += '<tr>';
                    th = '<tr>';

                    for (let i in element) {
                        th += `<th>${i}</th>`
                    }
                    th += '<th>Action</th>';
                    th += '</tr>';

                    for (let i in element) {
                        if (i === 'description') {
                            tr += `<td>${element[i].slice(0, 50)}</td>`;
                        } else {
                            tr += `<td>${element[i]}</td>`;
                        }
                    }
                    tr += `
                <td>
                <a class='btn btn-primary text-white update_info' update_id="${element['s_id']}">Edit</a>
                <a class='btn btn-danger text-white delete_info' delete_id="${element['s_id']}">Delete</a>
                </td>
                `;
                    tr += '</tr>';
                });
            }
            $("#tableData thead").append(th);
            $("#tableData tbody").append(tr);
        },
        error: (err) => {
            console.log('Failed to retrieve data', err.responseText);
        }
    });
}


// delete semester 
function delete_semester_fn(s_id) {
    console.log('s_id', s_id);
    const sendingData = {
        's_id': s_id,
        'action': 'delete_semester_api'
    }

    $.ajax({
        method: 'POST',
        dataType: 'json',
        url: '../api/semester.api.php',
        data: sendingData,
        success: (res) => {
            const status = res.status;
            const message = res.data;
            if (status) {
                alert(message)
                load_data();
            } else {
                alert(message);
            }
        },
        error: (err) => {
            console.log('Failed to delete table data', err.responseText);
        }
    })
}



$("#tableData tbody").on('click', 'a.delete_info', function () {
    let s_id = $(this).attr('delete_id');
    console.log('s_id', s_id);
    if (confirm("Are you sure you want to delete")) {
        delete_semester_fn(s_id);
    }
})


// read single semester to update
function read_single_semester_fn(s_id) {
    console.log('s_id', s_id);
    const sendingData = {
        's_id': s_id,
        'action': 'read_single_semester_api'
    }

    $.ajax({
        method: 'POST',
        dataType: 'json',
        url: '../api/semester.api.php',
        data: sendingData,
        success: (res) => {
            const status = res.status;
            const response = res.data;
            if (status) {
               $("#s_id").val(response[0].s_id);
               $("#name").val(response[0].name);
               $("#description").val(response[0].description);
               btnAction = 'update';
               load_data();
            }
        },
        error: (err) => {
            console.log('Failed to delete table data', err.responseText);
        }
    })
}

$("#tableData tbody").on('click', 'a.update_info', function () {
    let s_id = $(this).attr('update_id');
    showModal();
    read_single_semester_fn(s_id);
})
