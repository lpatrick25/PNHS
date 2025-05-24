<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laravel TypeScript Integration</title>
</head>
<body>
    <input type="text" id="phoneNumber" placeholder="Enter phone number">
    <input type="text" id="messageBody" placeholder="Enter message">
    <button id="sendMessageButton">Send Message</button>

    <script src="{{ asset('js/bundle.js') }}"></script>
    <script>
        document.getElementById('sendMessageButton').addEventListener('click', function() {
            const phoneNumber = document.getElementById('phoneNumber').value;
            const messageBody = document.getElementById('messageBody').value;
            window.sendMessageSequence(phoneNumber, messageBody);
        });
    </script>
</body>
</html>
