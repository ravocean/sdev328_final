/*
 * Desc:    This script is used with the adminDash page to allow for interactive data tables that will update
 *          their contents in real time.
 * Date:    3/20/21
 * File:    adminDash.js
 * Auth:    Ryan Rivera & Husrav Khomidov
 */

//When the page loads
$(document).ready(function(){
    //Populate Open Tickets table
    $('#ticket-table').load('model/adminDash.php', {
        updateTicketTable : true
    });
});

//When userSelect is changes
$('#userSelect').on('change', function(){
    //Get the selected user's ID
    let userID = $(this).val();

    //Select the User Table, send the userID to admin.php to update user-table
    $('#user-table').load('model/adminDash.php', {
        updateUserTable : userID
    });
});

/*NOTE: Experienced issue selecting elements that were appended to table after page
        loads and had to user event-delegation approach to select .edit and .save.
*/

//When the user-table is clicked, select .edit
$('#user-table').on('click', '.edit', function(){
    //Assign edit, save, and input
    let input = $(this).closest('tr').find("input");
    let save = $(this).closest('tr').find(".save");
    let edit = $(this).closest('tr').find(".edit");

    //Toggle disabled property on input and save button, and edit button text
    if(input.attr('disabled')){
        input.attr('disabled', false);
        save.attr('disabled', false)
        edit.html("Cancel");
    }
    else{
        input.attr('disabled', true);
        save.attr('disabled', true)
        edit.html("Edit");
    }
});

//When the user-table is clicked, select .save
$('#user-table').on('click', '.save', function(){
    //Assign edit, input, vehicleID, and new status from input
    let input = $(this).closest('tr').find("input");
    let edit = $(this).closest('tr').find(".edit");
    let vehicleID = $(this).closest('tr').attr('id');
    let status = input.val();

    //Reset input and buttons
    edit.html("Edit");
    input.attr('disabled', true);
    $(this).attr('disabled', true)

    //Send Status update to database table
    $('#ticket-table').load('model/adminDash.php', {
        vehicleID : vehicleID,
        status : status,
        updateTicketTable : true
    });
});