// ADD (Create)
function user_type_submit() {

    var user_type = $("#user_type").val().trim();
    var status    = $("#user_type_status").val();

    if (user_type === "") {
        validate_usertype(user_type);
        return false;
    }

    $.ajax({
        type: "POST",
        url: "model/user_type_creation.php?action=SUBMIT",
        data: {
            user_type: user_type,
            status: status
        },
        success: function (data) {
            console.log("Server:", data);
            alert("wait");
            window.location.href = 'index1.php?filename=user_type_creation/admin';
        },
        error: function () {
            alert('Error submitting data.');
        }
    });
}



function user_type_update(update_id) {

    var user_type = $("#user_type").val().trim();
    var status    = $("#user_type_status").val();

    if (user_type === "") {
        validate_usertype(user_type);
        return false;
    }

    $.ajax({
        type: "POST",
        url: "model/user_type_creation.php?action=UPDATE",
        data: {
            update_id: update_id,
            user_type: user_type,
            status: status
        },
        success: function (data) {
            console.log("Update:", data);
            if(data === "OK") {
                window.location.href = 'index1.php?filename=user_type_creation/admin';
            } else {
                alert("Update failed: " + data);
            }
        }
    });
}


// DELETE
function usertype_delete(delete_id) {

    if (!confirm("Are you sure?")) return;

    $.ajax({
        type: "POST",
        url: "model/user_type_creation.php?action=DELETE&delete_id=" + delete_id,
        success: function (data) {
            console.log("Delete Response:", data);
            window.location.href = 'index1.php?filename=user_type_creation/admin';
        },
        error: function () {
            alert('Error deleting.');
        }
    });
}



// VALIDATION
function validate_usertype(user_type) {
    if (user_type === "") {
        $("#user_type").addClass('errorClass');
        $("#user_type").focus();
    } else {
        $("#user_type").removeClass('errorClass').addClass('successClass');
    }
}
