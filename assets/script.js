$(document).ready(function(){
    $("#submit").click(function(e) {
        e.preventDefault();
        let formData = $('#form').serialize();
        $.post("calendar.php", formData, function(response) {
            let alert = $("#alert");
            $.each(response.errors, function( fieldID, value ) {
                let field = $('.' + value.field + '_error');
                let inputField = $('.' + value.field);
                if(value.status) {
                    inputField.removeClass('field-error');
                    field.hide();
                }
                else {
                    inputField.addClass('field-error');
                    field.html(value.error);
                    field.show();
                }
            });
            if(!response.success) {
                alert.html("There are some error with fields, please correct them and try again!");
                alert.addClass('msg-error');
                alert.removeClass('msg-success');
                alert.slideDown();
            }
            else {
                alert.html('Event added. <a href="' + response.link + '" target="_blank">Click here</a> to view it');
                alert.removeClass('msg-error');
                alert.addClass('msg-success');
                alert.slideDown();
            }
        }, 'json');
    });
});