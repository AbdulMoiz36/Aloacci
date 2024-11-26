<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>

<style>
    /* Reset */
body {
    font-family: Arial, sans-serif;
    margin: 0;
    padding: 0;
    background-color: #f5f5f5;
}

/* Toggle Button */
.toggle-button {
    position: fixed;
    bottom: 20px;
    right: 20px;
    background-color: #007bff;
    color: white;
    border: none;
    border-radius: 50%;
    width: 60px;
    height: 60px;
    font-size: 24px;
    display: flex;
    align-items: center;
    justify-content: center;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    cursor: pointer;
    transition: all 0.3s ease;
}

.toggle-button:hover {
    background-color: #0056b3;
    transform: scale(1.1);
}

/* Chat Box */
.chat-box {
    position: fixed;
    bottom: 90px;
    right: 20px;
    width: 300px;
    background-color: white;
    border-radius: 10px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
    display: none;
    flex-direction: column;
    overflow: hidden;
}

.chat-header {
    background-color: #007bff;
    color: white;
    padding: 10px;
    font-size: 16px;
    text-align: center;
    font-weight: bold;
}

.chat-messages {
    padding: 10px;
    height: 200px;
    overflow-y: auto;
    border-top: 1px solid #f0f0f0;
    border-bottom: 1px solid #f0f0f0;
    background-color: #f9f9f9;
}

.chat-input {
    display: flex;
    padding: 10px;
    gap: 10px;
    align-items: center;
}

.chat-input input {
    flex: 1;
    padding: 8px;
    border: 1px solid #ccc;
    border-radius: 5px;
}

.send-button {
    background-color: #007bff;
    color: white;
    border: none;
    border-radius: 5px;
    padding: 8px 12px;
    cursor: pointer;
    transition: all 0.3s ease;
}

.send-button:hover {
    background-color: #0056b3;
}
/* Chat Messages Container */
.chat-messages {
    display: flex;
    flex-direction: column;
    padding: 10px;
    height: 200px;
    overflow-y: auto;
    border-top: 1px solid #f0f0f0;
    border-bottom: 1px solid #f0f0f0;
    background-color: #f9f9f9;
}

/* Common Style for All Messages */
.message {
    margin-bottom: 10px;
    padding: 10px 15px;
    border-radius: 12px;
    max-width: 70%;
    word-wrap: break-word;
}

/* User Message (Sent by User) */
.user-message {
    background-color: #007bff;
    color: white;
    align-self: flex-end; /* Align to the right */
    text-align: right;
}

/* Bot Message (Replied by System) */
.bot-message {
    background-color: #f1f1f1;
    color: #333;
    align-self: flex-start; /* Align to the left */
    text-align: left;
}


</style>


<!-- Toggle Button -->
<button id="toggleChat" class="toggle-button">💬</button>

<!-- Chat Box -->
<div id="chatBox" class="chat-box">
    <div class="chat-header">Chat with Us</div>
    <div class="chat-messages" id="chatMessages">
        <!-- Messages will appear here -->
    </div>
    <div class="chat-input">
        <input type="text" id="userMessage" placeholder="Type your message...">
        <button id="sendMessage" class="send-button">Send</button>
    </div>
</div>

<!-- jQuery 3.7.0 (Latest as of November 2024) -->
<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>


<script>
  
  $(document).ready(function () {
    // Toggle chat box visibility
    $('#toggleChat').on('click', function () {
        $('#chatBox').toggle();
    });

    // Handle message send button
    $('#sendMessage').on('click', function () {
        const message = $('#userMessage').val().trim();

        if (message !== '') {
            // Append user message (aligned to the right)
            $('#chatMessages').append(`<div class="message user-message">${message}</div>`);

            // Clear the input field
            $('#userMessage').val('');

            // Example AJAX request to fetch the bot's reply
            $.post('chat_handler.php', { message }, function (response) {
                const data = JSON.parse(response);
                const reply = data.message;

                // Append bot reply (aligned to the left)
                $('#chatMessages').append(`<div class="message bot-message">${reply}</div>`);

                // Automatically scroll to the bottom of the messages container
                $('#chatMessages').scrollTop($('#chatMessages')[0].scrollHeight);
            });
        }
    });
});



</script>
</body>
</html>