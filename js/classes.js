var btnAction = 'insert';

// loading all data
load_data();

// loading all semester names 
load_semester_names();

// hidden class id field
$("#c_id").hide();


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
    $("#classModal").modal('show');
}

// hide modal
function hideModal() {
    $("#classModal").modal('hide');
}

// reset form fields after submitted data
function resetForm() {
    $("#classForm")[0].reset();
}

// clear table data 
function clearData() {
    $('#tableData tr').html('');
}
// clear drop down data 
function clearSelectoptions() {
    $('#s_id').html('');
}
$('#classForm').on('submit', (e) => {
    e.preventDefault();
    const c_id = $('#c_id').val();
    const s_id = $('#s_id').val();
    const name = $('#name').val();
    const description = $('#description').val();
    let sendingData = {};
    if (btnAction === 'insert') {
        sendingData = {
            'name': name,
            's_id': s_id,
            'description': description,
            'action': 'create_class_api'
        }
    }
    else {
        sendingData = {
            'c_id': c_id,
            's_id': s_id,
            'name': name,
            'description': description,
            'action': 'update_class_api'
        }
    }

    console.log('sending data',sendingData);
    $.ajax({
        method: 'POST',
        dataType: 'json',
        url: '../api/classes.api.php',
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

// read all claases within db
function load_data() {
    clearData();

    const sendingData = {
        'action': 'read_all_class_api'
    }
    $.ajax({
        method: 'POST',
        dataType: 'json',
        url: '../api/classes.api.php',
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
                <a class='btn text-white update_info' update_id="${element['c_id']}">Edit</a>
                <a class='btn btn-danger text-white delete_info' delete_id="${element['c_id']}">Delete</a>
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


// read all semester names within db
function load_semester_names() {
    clearSelectoptions()
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
            options = '';
            th = '';
            if (status) {
                options = '<option value="">-- select semester name --</option>';
                response.forEach(element => {
                    options += `<option value="${element['s_id']}">${element['name']}</option>`;
                });
            }
            $("#s_id").append(options);
        },
        error: (err) => {
            console.log('Failed to retrieve data', err.responseText);
        }
    });
}


// delete class 
function delete_class_fn(c_id) {
    console.log('c_id', c_id);
    const sendingData = {
        'c_id': c_id,
        'action': 'delete_class_api'
    }

    $.ajax({
        method: 'POST',
        dataType: 'json',
        url: '../api/classes.api.php',
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
    let c_id = $(this).attr('delete_id');
    console.log('c_id', c_id);
    if (confirm("Are you sure you want to delete")) {
        delete_class_fn(c_id);
    }
})


// read single class to update
function read_single_class_fn(c_id) {
    console.log('c_id', c_id);
    const sendingData = {
        'c_id': c_id,
        'action': 'read_single_class_api'
    }

    $.ajax({
        method: 'POST',
        dataType: 'json',
        url: '../api/classes.api.php',
        data: sendingData,
        success: (res) => {
            const status = res.status;
            const response = res.data;
            if (status) {
                $("#c_id").val(response[0].c_id);
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
    let c_id = $(this).attr('update_id');
    showModal();
    read_single_class_fn(c_id);
})
