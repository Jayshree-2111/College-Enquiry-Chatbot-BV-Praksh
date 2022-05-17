<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>प्रKश FOR FACULTY</title>
    <link rel="stylesheet" href="mainbot.css">
</head>
<body>
    <header class="top-header">
        <div class="top-bar">
            <div class="logo" style="margin-left:11px;">
                <img src="https://i.postimg.cc/8C7W965P/image.png" height=50 width=50>
            </div>
            <div class="top-left"><a href="BV_Homepage.html" style="text-decoration: none; color:white">Banasthali Vidyapith</a></div>
        </div>
    </header>
    <div id="container">
        <div id="dot1"></div>
        <div id="dot2"></div>
        <div id="screen">
            <div id="header">प्रKश FOR FACULTY</div>
            <div id="messageDisplaySection">
                <!-- bot messages -->
                <img src="https://i.postimg.cc/RCXLgKKb/Chatbotlogo.png" class="avatar" ><div class="chat botMessages">Hii.. It's your Chatbot, प्रKश!</div>

                <!-- usersMessages -->
                <div id="messagesContainer">
                <!-- <div class="chat usersMessages"></div> -->
            </div>
        </div>
            <!-- messages input field -->
            <div id="userInput">
                <input type="text" name="messages" id="messages" autocomplete="OFF" placeholder="Type Your Message Here." required>
                <input type="submit" value="Send" id="send" name="send">
            </div>
        </div>
    </div>

    <!-- jQuery CDN -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    
    <!-- Jquery Start -->
    <script>
        $(document).ready(function(){
            $("#messages").on("keyup",function(){

                if($("#messages").val()){
                    $("#send").css("display","block");
                }else{
                    $("#send").css("display","none");
                }
            });
        });
        // when send button clicked
        $("#send").on("click",function(e){
            $userMessage = $("#messages").val();
            $appendUserMessage = '<img src="QUERY.jpg" class="avatar1"><div class="chat usersMessages">'+ $userMessage +'</div>';
            $("#messageDisplaySection").append($appendUserMessage);

            // ajax start
            $.ajax({
                url: "facbot.php",
                type: "POST",
                // sending data
                data: {messageValue: $userMessage},
                // response text
                success: function(data){
                    // show response
                    $appendBotResponse = '<img src="https://i.postimg.cc/RCXLgKKb/Chatbotlogo.png" class="avatar" ><div class="chat botMessages">'+data+'</div>';
                    $("#messageDisplaySection").append($appendBotResponse);
                }
            });
            $("#messages").val("");
            $("#send").css("display","none");
        });
    </script>
</body>
</html>