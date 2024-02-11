var btnAction = 'insert';

// loading all data
load_data();


// clear table data 
function clearData() {
    $('#tableData tr').html('');
}
function load_data() {
    clearData();

    const sendingData = {
        'action': 'read_all_complains_api'
    }
    $.ajax({
        method: 'POST',
        dataType: 'json',
        url: '../api/complain.api.php',
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
                    // th += '<th>Action</th>';
                    th += '</tr>';

                    for (let i in element) {
                        if (i == 'status') {
                            tr += `<td>
                             <a class='btn text-white update_info' update_id="${element['com_id']}">${element[i]}</a>
                            </td>`;
                        }else{
                            tr += `<td>${element[i]}</td>`;
                        }
                        
                    }
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


function update_complain_status_fn(com_id) {
    const sendingData = {
        'com_id': com_id,
        'status': 'completed',
        'action': 'update_complain_status_api'
    }

    $.ajax({
        method: 'POST',
        dataType: 'json',
        url: '../api/complain.api.php',
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

$("#tableData tbody").on('click', 'a.update_info', function () {
    let com_id = $(this).attr('update_id');
    update_complain_status_fn(com_id);
})
