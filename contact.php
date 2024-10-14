<?php
include 'header.php';

// Initialize variables for form data
$name = '';
$email = '';
$message = '';

// Check if the user is logged in and retrieve user details
if (isset($_SESSION['USER_ID'])) {
    $user_id = $_SESSION['USER_ID'];
    $sql = mysqli_query($con, "SELECT `name`,`email` FROM `users` WHERE `id` = '$user_id'");
    $user = mysqli_fetch_array($sql);
    $name = $user['name'];
    $email = $user['email'];
}
?>

<section class="py-10 w-full flex justify-center items-center">
    <div class="w-full md:w-5/6 grid grid-cols-1 md:grid-cols-2 gap-8 border rounded-lg">
        <!-- Right: Image Section (on top for small screens) -->
        <div class="flex justify-center items-center order-1 md:order-none">
            <img src="./img/messenger-isometric-color-vector-29602122.jpg" alt="Contact Us" class="w-full h-full object-cover rounded-l-none rounded-t-lg md:rounded-l-lg md:rounded-tr-none" />
        </div>

        <!-- Left: Form Section (on bottom for small screens) -->
        <div class="flex flex-col justify-center p-8 order-2 md:order-none">
            <h1 class="text-4xl font-bold underline text-center mb-6">Contact Us</h1>
            <form action="send_message" class="w-full">
                <div class="flex flex-col gap-6">
                    <!-- Name and Email -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="flex flex-col">
                            <label for="name" class="text-lg font-semibold">Name:</label>
                            <input type="text" name="c_name" id="contact-name" value="<?=$name?>" 
                                class="p-2 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-amber-500" >
                            <p class="help-block text-danger" id="c_name_error" style="color:red;"></p>
                        </div>
                        <div class="flex flex-col">
                            <label for="email" class="text-lg font-semibold">Email:</label>
                            <input type="email" id="contact-email" name="c_email" value="<?=$email?>" 
                                class="p-2 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-amber-500" >
                            <p class="help-block text-danger" id="c_email_error" style="color:red;"></p>
                        </div>
                    </div>
                    <!-- Subject -->
                    <div class="flex flex-col">
                        <label for="subject" class="text-lg font-semibold">Subject:</label>
                        <input type="text" name="c_subject" id="contact-subject" 
                            class="p-2 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-amber-500" >
                        <p class="help-block text-danger" id="c_subject_error" style="color:red;"></p>
                    </div>
                    <!-- Message -->
                    <div class="flex flex-col">
                        <label for="message" class="text-lg font-semibold">Message:</label>
                        <textarea name="c_message" id="contact-message" 
                            class="p-2 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-amber-500" 
                            rows="8"></textarea>
                        <p class="help-block text-danger" id="c_message_error" style="color:red;"></p>
                    </div>
                    <!-- Submit Button -->
                    <button type="button" onclick="send_message()" 
                        class="w-full p-3 bg-gradient-to-r from-amber-500 to-yellow-500 text-white text-lg font-semibold rounded-full shadow-sm hover:shadow-lg transition-shadow duration-300 ease-in-out">
                        Submit
                    </button>
                </div>
            </form>
        </div>
    </div>
</section>



<script>
    function send_message() {
    jQuery('.help-block').html('');
    var c_name = jQuery("#contact-name").val();
    var c_email = jQuery("#contact-email").val();
    var c_subject = jQuery("#contact-subject").val();
    var c_message = jQuery("#contact-message").val();
    var is_error = '';
    if (c_name == "") {
        jQuery('#c_name_error').html('Please enter your name');
        is_error = 'yes';
    }
    if (c_email == "") {
        jQuery('#c_email_error').html('Please enter your email');
        is_error = 'yes';
    } else {
        // Check email format using a regular expression
        var c_emailRegex = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/;
        if (!c_email.match(c_emailRegex)) {
            jQuery('#c_email_error').html('Please enter a valid email address');
            is_error = 'yes';
        }
    }
    if (c_subject == "") {
        jQuery('#c_subject_error').html('Please enter a subject');
        is_error = 'yes';
    }
    if (c_message == "") {
        jQuery('#c_message_error').html('Please enter your message');
        is_error = 'yes';
    } else {
        jQuery.ajax({
            url: 'send_message',
            type: 'post',
            data: 'name=' + c_name + '&email=' + c_email + '&subject=' + c_subject +
                '&message=' + c_message,
            success: function(result) {
                if (result == 'ThankYou') {
                    jQuery("#message_send").click();
                }
            }
        });
        jQuery("#contact-subject").val('');
        jQuery("#contact-message").val('');
    }
}
</script>

<?php
include 'footer.php';
?>
