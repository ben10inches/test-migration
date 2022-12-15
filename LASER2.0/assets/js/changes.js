$(function() {
    $('a[href^="' + location.pathname.split("/")[2] + '"]').closest('li').addClass('active');

    var selectDB = $('#shipmentDBSelect').val();
    
    var span = $('a[href^="' + location.pathname.split("/")[2] + '"]').parent().parent().parent().before();
    var path = location.pathname.split("/")[2];
    console.log(path)
    if(path != "index.php" && path != "/"){
        $(span).toggle();
    }
    // $(span).parent().parent().parent().before().click();

});

function pullAttachments(GUID){
    console.log($(this));
    // Show full page LoadingOverlay
    $.LoadingOverlay("show");
    $.ajax({
        url: 'functions/getAttachments.php',
        type: 'POST',
        data: {
            GUID: GUID
        },
        success: function(data){
            console.log(data)
            $('#attachmentListing').html(data);
            $.LoadingOverlay("hide");
        }
    });
}
function isValidDate(d) {
    return d instanceof Date && !isNaN(d);
}
function pullInvoiceAttachments(GUID){
    console.log($(this));
    // Show full page LoadingOverlay
    $.LoadingOverlay("show");
    $.ajax({
        url: 'functions/getInvoiceAttachments.php',
        type: 'POST',
        data: {
            id: GUID
        },
        success: function(data){
            console.log(data)
            $('#attachmentListing').html(data);
            $.LoadingOverlay("hide");
        }
    });
}