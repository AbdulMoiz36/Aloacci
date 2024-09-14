function user_login() {
    jQuery('.help-block').html('');
    var l_email = jQuery("#l_email").val();
    var l_password = jQuery("#l_password").val();
    var is_error = '';

    if (l_email == "") {
        jQuery('#l_email_error').html('Please enter your email');
        is_error = 'yes';
    }
    else {
        // Check email format using a regular expression
        var emailRegex = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/;
        if (!l_email.match(emailRegex)) {
            jQuery('#l_email_error').html('Please enter a valid email address');
            is_error = 'yes';
        }
    }
    if (l_password == "") {
        jQuery('#l_password_error').html('Please enter password');
        is_error = 'yes';
    }
    if (is_error == '') {
        jQuery.ajax({
            url: 'login_submit.php',
            type: 'post',
            data: 'email=' + l_email + '&password=' + l_password,
            success: function (result) {
                if (result == 'wrong') {
                    jQuery('.login_msg p').html('Please enter valid login details');
                }
                if (result == 'valid') {
                    window.location.href = 'index.php';
                }
            }
        });
    }
}