read_users_fn();
read_students_fn();
read_classes_fn();
read_complains_fn();
function read_users_fn() {
    const sendingData = {
        'action': 'read_all_users_api'
    }

    $.ajax({
        method: 'POST',
        dataType: 'json',
        url: '../api/user.api.php',
        data: sendingData,
        success: (res) => {
            const status = res.status;
            const response = res.data;
            document.getElementById('users').innerText = response.length
        },
        error: (err) => {
            console.log('Failed to delete table data', err.responseText);
        }
    })
}


function read_students_fn() {
    const sendingData = {
        'action': 'readStudents'
    }

    $.ajax({
        method: 'POST',
        dataType: 'json',
        url: '../api/student.api.php',
        data: sendingData,
        success: (res) => {
            const status = res.status;
            const response = res.data;
            document.getElementById('students').innerText = response.length
        },
        error: (err) => {
            console.log('Failed to delete table data', err.responseText);
        }
    })
}

function read_classes_fn() {
    const sendingData = {
        'action': 'read_all_class_api'
    }

    $.ajax({
        method: 'POST',
        dataType: 'json',
        url: '../api/classes.api.php',
        data: sendingData,
        success: (res) => {
            const status = res.status;
            const response = res.data;
            document.getElementById('classes').innerText = response.length
        },
        error: (err) => {
            console.log('Failed to delete table data', err.responseText);
        }
    })
}


function read_complains_fn() {
    const sendingData = {
        'action': 'read_all_complains_api'
    }

    $.ajax({
        method: 'POST',
        dataType: 'json',
        url: '../api/complain.api.php',
        data: sendingData,
        success: (res) => {
            const status = res.status;
            const response = res.data;
            document.getElementById('complains').innerText = response.length
        },
        error: (err) => {
            console.log('Failed to delete table data', err.responseText);
        }
    })
}