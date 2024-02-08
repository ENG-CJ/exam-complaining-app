var btnAction = 'insert';

// loading all data
// load_data();

// hidden complain terms id field
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