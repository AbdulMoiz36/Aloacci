function user_register() {
    jQuery('.help-block').html('');
    var name = jQuery("#name").val();
    var email = jQuery("#email").val();
    var mobile = jQuery("#mobile").val();
    var password = jQuery("#password").val();
    var c_password = jQuery("#c_password").val();
    var is_error = '';

    if (name == "") {
        jQuery('#name_error').html('Please enter your username');
        is_error = 'yes';
    }
    if (email == "") {
        jQuery('#email_error').html('Please enter your email');
        jQuery('.register_msg').hide();
        is_error = 'yes';
    }
    else {
        // Check email format using a regular expression
        var emailRegex = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/;
        if (!email.match(emailRegex)) {
            jQuery('#email_error').html('Please enter a valid email address');
            is_error = 'yes';
        }
    }
    if (mobile == "") {
        jQuery('#mobile_error').html('Please enter mobile');
        jQuery('.register_msg').hide();
        is_error = 'yes';
    }
    else {
        // Check phone format using regular expressions
        var mobileRegex03 = /^03[1-4]\d{8}$/;
        var mobileRegex021 = /^021\d{8}$/;

        if (!mobile.match(mobileRegex03) && !mobile.match(mobileRegex021)) {
            jQuery('#mobile_error').html('Please enter a valid mobile number');
            is_error = 'yes';
        }
    }
    if (password == "") {
        jQuery('#password_error').html('Please enter password');
        jQuery('.register_msg').hide();
        is_error = 'yes';
    }
    if (c_password == "") {
        jQuery('#c_password_error').html('Please enter password');
        jQuery('.register_msg').hide();
        is_error = 'yes';
    }
    if (c_password != password) {
        jQuery('#c_password_error').html('Password Mismatch');
        jQuery('.register_msg').hide();
        is_error = 'yes';
    }
    if (is_error == '') {
        jQuery.ajax({
            url: 'register_submit.php',
            type: 'post',
            data: 'name=' + name + '&email=' + email + '&mobile=' + mobile + '&password=' + password,
            success: function (result) {
                if (result == 'exist') {
                    jQuery('#al_email_error').html('This email is already in use');
                    jQuery('.register_msg').hide();
                }
                if (result == 'insert') {
                    jQuery("#registration_success").click();
                    jQuery('.register_msg').show();
                }
            }
        });
        jQuery("#name").val('');
        jQuery("#email").val('');
        jQuery("#mobile").val('');
        jQuery("#password").val('');
        jQuery("#c_password").val('');
    }
}

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