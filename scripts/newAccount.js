$('#isAdmin').on('change', function(){
    toggleDisableForm();
});

function toggleDisableForm(){
    if($('#isAdmin').prop('checked')){
        $('.customer-field').attr('disabled', true);
    }
    else{
        $('.customer-field').attr('disabled', false);
    }
}