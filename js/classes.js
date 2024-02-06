var btnAction = 'insert';
$("#id").hide();

$("#showModal").on("click", function() {
    showModal()
});

$("#closeModal").on("click", function() {
    hideModal();
})

function showModal() {
    $("#classModal").modal('show');
}

function hideModal() {
    $("#classModal").modal('hide');
}

function resetForm() {
    $("#classForm")[0].reset();
}