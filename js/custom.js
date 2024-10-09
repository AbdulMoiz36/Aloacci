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
        var mobileRegex03 = /^03[0-7]\d{8}$/;
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

function manage_cart(pid, type, qty, format, price) {
    console.log("Product ID: " + pid);  // For debugging
    console.log("Quantity: " + qty); // For debugging
    console.log("Selected Format: " + format); // For debugging

    // Set default values for 'remove' action if format or price are not provided
    if (type === 'remove') {
        qty = 1; // Quantity doesn't matter when removing, just set it to 1
        if (!format) {
            format = ''; // Set format to an empty string for safety
        }
        if (!price) {
            price = 0; // Set price to 0 for remove action
        }
    }

    jQuery.ajax({
        url: 'manage_cart.php',
        type: 'post',
        data: { pid: pid, qty: qty, type: type, format: format, price: price }, // Send all necessary data
        success: function(result) {
            console.log("AJAX success response: " + result);  // For debugging
            if (result === 'not_available') {
                alert('You cannot select more than the available stock');
            } else {
                const cartQuantity = parseInt(result, 10);
                if (!isNaN(cartQuantity)) {
                    jQuery('.cart-quantity').html('(' + cartQuantity + ')');
                } else {
                    console.error('Invalid quantity response: ' + result);
                }
                window.location.reload(); // Reload the page to reflect the cart updates
            }
        },
        error: function(jqXHR, textStatus, errorThrown) {
            console.error("AJAX error: " + textStatus + ", " + errorThrown);
            alert('An error occurred while processing your request. Please try again.');
        }
    });
}


function changeQuantity(pid, change) {
    console.log((change > 0 ? "Increment" : "Decrement") + " button clicked for product ID: " + pid);
    let quantityInput = document.getElementById('quantity_' + pid);
    let quantity = parseInt(quantityInput.value) + change;

    if (quantity < 1) return; // Prevent going below 1
    quantityInput.value = quantity;
    manage_cart(pid, 'update');
}

// Usage
function increment(pid) {
    changeQuantity(pid, 1);
}

function decrement(pid) {
    changeQuantity(pid, -1);
}



