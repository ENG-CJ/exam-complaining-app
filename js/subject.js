var btnAction = 'insert';
$("#id").hide();

$("#showModal").on("click", function() {
    showModal()
});

$("#closeModal").on("click", function() {
    hideModal();
})

function showModal() {
    $("#semesterModal").modal('show');
}

function hideModal() {
    $("#semesterModal").modal('hide');
}

function resetForm() {
    $("#semesterForm")[0].reset();
}