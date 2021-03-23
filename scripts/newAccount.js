/*
 * Desc:    This script is used with the newAccount page to toggle customer information inputs
 *          disabled.
 * Date:    3/20/21
 * File:    newAccount.js
 * Auth:    Ryan Rivera & Husrav Khomidov
 */

//When isAdmin checkbox is changed, call the toggleDisableForm function
$('#isAdmin').on('change', function(){
    toggleDisableForm();
});

/**
 * This function will toggle the customer-field inputs disabled on or off
 */
function toggleDisableForm(){
    //Get the isAdmin check box, toggle disabled on or off
    if($('#isAdmin').prop('checked')){
        $('.customer-field').attr('disabled', true);
    }
    else{
        $('.customer-field').attr('disabled', false);
    }
}