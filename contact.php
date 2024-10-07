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

<section class="py-10 w-full flex justify-center align-middle">
    <div class="w-full md:w-4/6 shadow-lg p-8 flex flex-col justify-center border">
        <h1 class="text-4xl font-bold underline text-center">Contact Us</h1>
        <form action="send_message.php" class="mt-8 w-full flex justify-center">
            <div class="flex flex-col gap-8 py-8">
                <div class="flex gap-4">
                    <div class="flex flex-col">
                        <label for="name" class="text-xl">Name:</label>
                        <input type="text" name="c_name" id="contact-name" value="<?=$name?>" class="p-1 rounded-lg border" >
                        <p class="help-block text-danger" id="c_name_error" style="padding:0 1rem 0; color:red;"></p>
                    </div>
                    <div class="flex flex-col">
                        <label for="email" class="text-xl">Email:</label>
                        <input type="email" id="contact-email" name="c_email" value="<?=$email?>" class="p-1 rounded-lg border" >
                        <p class="help-block text-danger" id="c_email_error" style="padding:0 1rem 0; color:red;"></p>
                    </div>
                </div>
                    <div class="flex flex-col">
                        <label for="subject" class="text-xl">Subject:</label>
                        <input type="text" name="c_subject" id="contact-subject" class="p-1 rounded-lg border" >
                        <p class="help-block text-danger" id="c_subject_error" style="padding:0 1rem 0; color:red;"></p>
                    </div>
                <div class="flex flex-col">
                    <label for="message" class="text-xl">Message:</label>
                    <textarea name="c_message" id="contact-message" class="p-1 rounded-lg border" rows="8" ></textarea>
                    <p class="help-block text-danger" id="c_message_error" style="padding:0 1rem 0; color:red;"></p>
                </div>
                <button type="button" onclick="send_message()" class="w-full p-3 border border-amber-500 text-lg font-semibold shadow-sm hover:shadow-lg transition-shadow ease-in-out duration-300 rounded-full bg-yellow-500 text-white">Submit</button>
            </div>
        </form>
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
            url: 'send_message.php',
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
