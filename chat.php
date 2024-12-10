<?php
// Fetch perfumes from the database
$sql = "SELECT id, original_name FROM impressions";
$result = $con->query($sql);


// Handle form submission (when the user selects a perfume)
$selectedPerfume = '';
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['perfume'])) {
    $selectedPerfume = $_POST['perfume'];
}

?>



    <!-- Toggle Button -->
    <button id="toggleChat" class="toggle-button">💬</button>

    <!-- Chat Box -->
    <div id="chatBox" class="chat-box">
        <div class="chat-header flex">
            <img src="./img/logo-cropped-bottom.png" width="40px" alt="">
            <p class="text-sm">Select Your Favorite Perfume And Get Our Impression</p>
        </div>
        <div class="chat-area">
            <div class="chat-messages" id="chatMessages">
                <!-- Messages will appear here -->
            </div>
        </div>
        <div class="chat-input">
            <!-- Dropdown for perfumes -->
            <select id="userMessage" class="form-control">
                <option value="" disabled selected>Select Original</option>
                <?php
                // Populate the dropdown with perfumes
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo '<option value="' . htmlspecialchars($row['original_name']) . '">' . htmlspecialchars($row['original_name']) . '</option>';
                    }
                } else {
                    echo '<option value="" disabled>No perfumes found</option>';
                }
                ?>
            </select>
            <button id="sendMessage" class="send-button ">Send</button>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            // Toggle chat box visibility
            $('#toggleChat').on('click', function() {
                $('#chatBox').toggle();
            });

            $('#sendMessage').on('click', function() {
                const message = $('#userMessage').val();

                if (message) {
                    // Append user message
                    $('#chatMessages').append(`<div class="message user-message">${message}</div>`);

                    // Append loading dots as a placeholder for bot response
                    const loadingDots = `<div id="loadingDots" class="message bot-message">
            <span class="dot">.</span><span class="dot">.</span><span class="dot">.</span>
        </div>`;
                    $('#chatMessages').append(loadingDots);

                    // Automatically scroll to the bottom of the messages container
                    $('#chatMessages').scrollTop($('#chatMessages')[0].scrollHeight);

                    // AJAX request to the server
                    $.post('chat_handler.php', {
                        message
                    }, function(response) {
                        console.log('Raw response:', response); // Log raw response

                        // Simulate a delay
                        setTimeout(() => {
                            // Remove loading dots
                            $('#loadingDots').remove();

                            try {
                                // Use the response directly, since it's already parsed
                                const data = response;

                                if (data.status) {
                                    let replyHTML = `<div class="message bot-message">${data.message}</div>`;

                                    if (data.product) {
                                        replyHTML += `
                            <a href="product_details?id=${data.product.id}">
                                <div class="message bot-message-product">
                                    <p class="font-semibold pb-2 underline">${data.product.name}</p><hr class="border-gray-300">
                                    <img src="./image/products/${data.product.image}" alt="${data.product.name}" style="max-width: 80px; border-radius: 5px;"><hr class="border-gray-300">
                                    <p class="underline font-semibold text-amber-600 pt-2">View Details</p>
                                </div>
                            </a>
                            `;
                                    }

                                    $('#chatMessages').append(replyHTML);
                                } else {
                                    $('#chatMessages').append(`<div class="message bot-message">${data.message}</div>`);
                                }
                            } catch (err) {
                                console.error('Error handling response:', err, response); // Log errors
                            }

                            // Automatically scroll to the bottom of the messages container
                            $('#chatMessages').scrollTop($('#chatMessages')[0].scrollHeight);
                        }, 1500); // Delay by 2 seconds
                    }).fail(function(xhr, status, error) {
                        console.error('AJAX Error:', status, error);
                    });
                }
            });


        });
    </script>


    <style>
       /* Toggle Button */
.toggle-button {
    position: fixed;
    bottom: 20px;
    right: 20px;
    background-color: black;
    color: white;
    border: none;
    border-radius: 50%;
    width: 60px;
    height: 60px;
    font-size: 24px;
    display: flex;
    align-items: center;
    justify-content: center;
    box-shadow: 0 0 15px rgba(255, 255, 255, 0.6);
    cursor: pointer;
    transition: all 0.3s ease;
    z-index: 1000;
}

.toggle-button:hover {
    background-color: goldenrod;
    transform: scale(1.1);
}

/* Chat Box */
.chat-box {
    position: fixed;
    bottom: 90px;
    right: 20px;
    width: 350px;
    height: 500px;
    background-color: white;
    border-radius: 10px;
    box-shadow: rgba(0, 0, 0, 0.16) 0px 10px 36px 0px, rgba(0, 0, 0, 0.06) 0px 0px 0px 1px;
    display: none;
    flex-direction: column;
    overflow-y: hidden;
    z-index: 1000;
}

/* Chat Header */
.chat-header {
    background-color: black;
    color: white;
    padding: 15px;
    font-size: 16px;
    text-align: center;
    font-weight: bold;
    border-radius: 10px 10px 0 0;
}

/* Chat Messages Container */
.chat-messages {
    flex: 1;
    padding: 10px;
    width: 100%;
    display: flex;
    height: 368px;
    flex-direction: column;
    overflow-y: auto;
    background-color: #f9f9f9;
}

/* Chat Input Section */
.chat-input {
    display: flex;
    background-color: black;
    position: relative;
    width: 100%;
    bottom: 0;
    padding: 10px;
    gap: 10px;
    align-items: center;
    border-top: 1px solid #ddd;
}

.chat-input select {
    flex: 1;
    padding: 8px;
    font-size: 14px;
    border: 1px solid #ccc;
    border-radius: 5px;
    background-color: #fff;
    color: #333;
    outline: none;
    transition: border-color 0.3s ease, box-shadow 0.3s ease;
}

.chat-input select:focus {
    border-color: goldenrod;
    box-shadow: 0 0 4px rgba(0, 123, 255, 0.5);
}

.chat-input button {
    background-color: white;
    color: black;
    border: none;
    border-radius: 5px;
    padding: 10px 15px;
    cursor: pointer;
    font-size: 14px;
    transition: background-color 0.3s ease;
}

.chat-input button:hover {
    background-color: goldenrod;
    color: white;
}
/* Chat Messages Styling */

.message {
    margin-bottom: 10px;
    padding: 10px 15px;
    border-radius: 12px;
    word-wrap: break-word;
    font-size: 14px;
    max-width: 80%; /* Constrain the width of the messages */
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1); /* Optional for aesthetics */
}

/* User Message */
.user-message {
    background-color: goldenrod;
    color: white;
    align-self: flex-end; /* Align to the right */
    text-align: right;
}

/* Bot Message */
.bot-message {
    background-color: #f1f1f1;
    color: #333;
    align-self: flex-start; /* Align to the left */
    text-align: left;
}
/* Bot Message */
.bot-message-product {
    background-color: #f1f1f1;
    color: #333;
    max-width: 40%;
    align-self: flex-start; /* Align to the left */
    text-align: left;
}

/* Loading Dots */
.dot {
    display: inline-block;
    font-size: 24px;
    animation: blink 1s infinite;
}

.dot:nth-child(2) {
    animation-delay: 0.2s;
}

.dot:nth-child(3) {
    animation-delay: 0.4s;
}

@keyframes blink {
    0%, 20% {
        opacity: 0;
    }
    50% {
        opacity: 1;
    }
    100% {
        opacity: 0;
    }
}

/* Responsive Adjustments */
@media (max-width: 768px) {
    .chat-box {
        width: 90%;
        bottom: 70px;
        right: 5%;
    }
    .toggle-button {
        bottom: 10px;
        right: 10px;
    }
    .chat-messages {
        height: 350px;
    }
    .bot-message-product{
        max-width: 60%;
    }
}

    </style>
