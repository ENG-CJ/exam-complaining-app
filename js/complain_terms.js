var btnAction = 'insert';

// loading all data
load_data();

// hterm_idden complain terms term_id field
$("#term_id").hide();


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
    $("#complainTermsModal").modal('show');
}

// hide modal
function hideModal() {
    $("#complainTermsModal").modal('hide');
}

// reset form fields after submitted data
function resetForm() {
    $("#complainTermsForm")[0].reset();
}

// clear table data 
function clearData() {
    $('#tableData tr').html('');
}

$('#complainTermsForm').on('submit', (e) => {
    e.preventDefault();
    const term_id = $('#term_id').val();
    const subject_length = $('#subject_length').val();
    const start_date = $('#start_date').val();
    const expire_date = $('#expire_date').val();
    const description = $('#description').val();
    const status = $('#status').val();
    const exam_type = $('#exam_type').val();
    let sendingData = {};
    if (btnAction === 'insert') {
        sendingData = {
            'subject_length': subject_length,
            'start_date': start_date,
            'expire_date': expire_date,
            'description': description,
            'exam_type': exam_type,
            'status': status,
            'action': 'create_complain_terms_api'
        }
    }
    else {
        sendingData = {
            'term_id': term_id,
            'subject_length': subject_length,
            'start_date': start_date,
            'expire_date': expire_date,
            'description': description,
            'exam_type': exam_type,
            'status': status,
            'action': 'update_complain_terms_api'
        }
    }

    $.ajax({
        method: 'POST',
        dataType: 'json',
        url: '../api/complain_terms.api.php',
        data: sendingData,
        success: (res) => {
            const status = res.status;
            const message = res.data;
            if (status) {
                alert(message)
                resetForm();
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
        'action': 'read_all_complain_terms_api'
    }
    $.ajax({
        method: 'POST',
        dataType: 'json',
        url: '../api/complain_terms.api.php',
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
                        if (i !== 'created_at') {
                            th += `<th>${i}</th>`
                        }
                    }
                    th += '<th>Action</th>';
                    th += '</tr>';

                    for (let i in element) {
                        if (i == 'description') {
                            tr += `<td>${element[i].slice(0, 30)}...</td>`;
                        } else if (i !== 'created_at') {
                            tr += `<td>${element[i]}</td>`;
                        }
                    }
                    tr += `
                <td>
                <a class='btn text-white update_info' update_id="${element['term_id']}">Edit</a>
                <a class='btn btn-danger text-white delete_info' delete_id="${element['term_id']}">Delete</a>
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


// delete complain terms fn 
function delete_complain_terms_fn(term_id) {
    const sendingData = {
        'term_id': term_id,
        'action': 'delete_complain_terms_api'
    }

    $.ajax({
        method: 'POST',
        dataType: 'json',
        url: '../api/complain_terms.api.php',
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
    let term_id = $(this).attr('delete_id');
    if (confirm("Are you sure you want to delete")) {
        delete_complain_terms_fn(term_id);
    }
})



// read single complain_terms to update
function read_single_complain_terms_fn(term_id) {
    const sendingData = {
        'term_id': term_id,
        'action': 'read_single_complain_terms_api'
    }

    $.ajax({
        method: 'POST',
        dataType: 'json',
        url: '../api/complain_terms.api.php',
        data: sendingData,
        success: (res) => {
            const status = res.status;
            const response = res.data;
            if (status) {
                $("#term_id").val(response[0].term_id);
                $("#subject_length").val(response[0].subject_length);
                $("#start_date").val(response[0].start_date);
                $("#expire_date").val(response[0].expire_date);
                $("#description").val(response[0].description);
                $("#status").val(response[0].status);
                $("#exam_type").val(response[0].exam_type);
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
    let term_id = $(this).attr('update_id');
    showModal();
    read_single_complain_terms_fn(term_id);
})
