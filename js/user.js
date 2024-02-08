var btnAction = 'insert';

// loading all data
load_data();

// hidden user id field
$("#id").hide();


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
    $("#userModal").modal('show');
}

// hide modal
function hideModal() {
    $("#userModal").modal('hide');
}

// reset form fields after submitted data
function resetForm() {
    $("#userForm")[0].reset();
}

// clear table data 
function clearData() {
    $('#tableData tr').html('');
}

$('#userForm').on('submit', (e) => {
    e.preventDefault();
    const id = $('#id').val();
    const username = $('#username').val();
    const email = $('#email').val();
    const password = $('#password').val();
    const status = $('#status').val();
    let sendingData = {};
    if (btnAction === 'insert') {
        sendingData = {
            'username': username,
            'email': email,
            'password': password,
            'status': status,
            'action': 'create_user_api'
        }
    }
    else {
        sendingData = {
            'id': id,
            'username': username,
            'email': email,
            'password': password,
            'status': status,
            'action': 'update_user_api'
        }
    }

    $.ajax({
        method: 'POST',
        dataType: 'json',
        url: '../api/user.api.php',
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
        'action': 'read_all_users_api'
    }
    $.ajax({
        method: 'POST',
        dataType: 'json',
        url: '../api/user.api.php',
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
                        if (i !== 'password') {
                            th += `<th>${i}</th>`
                        }
                    }
                    th += '<th>Action</th>';
                    th += '</tr>';

                    for (let i in element) {
                        if (i !== 'password') {
                            tr += `<td>${element[i]}</td>`;
                        }
                    }
                    tr += `
                <td>
                <a class='btn btn-primary text-white update_info' update_id="${element['id']}">Edit</a>
                <a class='btn btn-danger text-white delete_info' delete_id="${element['id']}">Delete</a>
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



// delete user fn 
function delete_user_fn(id) {
    const sendingData = {
        'id': id,
        'action': 'delete_user_api'
    }

    $.ajax({
        method: 'POST',
        dataType: 'json',
        url: '../api/user.api.php',
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
    let id = $(this).attr('delete_id');
    if (confirm("Are you sure you want to delete")) {
        delete_user_fn(id);
    }
})


// read single user to update
function read_single_user_fn(id) {
    console.log('id', id);
    const sendingData = {
        'id': id,
        'action': 'read_single_user_api'
    }

    $.ajax({
        method: 'POST',
        dataType: 'json',
        url: '../api/user.api.php',
        data: sendingData,
        success: (res) => {
            const status = res.status;
            const response = res.data;
            if (status) {
                $("#id").val(response[0].id);
                $("#username").val(response[0].username);
                $("#email").val(response[0].email);
                $("#password").hide();
                $("#status").val(response[0].status);
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
    let id = $(this).attr('update_id');
    showModal();
    read_single_user_fn(id);
})
