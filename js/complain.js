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
                        tr += `<td>${element[i]}</td>`;
                    }
                //     tr += `
                // <td>
                // <a class='btn btn-primary text-white update_info' update_id="${element['id']}">Edit</a>
                // <a class='btn btn-danger text-white delete_info' delete_id="${element['id']}">Delete</a>
                // </td>
                // `;
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
