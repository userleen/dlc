<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Attendance QR Code Generator</title>
    <link rel="stylesheet" href="qrc.css">
    <style>
        .container {
            max-width: 600px;
            margin: auto;
            padding: 20px;
        }

        .container h1 {
            text-align: center;
        }

        #qrCode {
            text-align: center;
            margin-top: 20px;
        }

        form {
            margin-top: 20px;
        }

        label {
            display: block;
            margin-bottom: 5px;
        }

        input[type="text"] {
            width: calc(100% - 10px);
            padding: 8px;
            margin-bottom: 10px;
        }

        button {
            width: 100%;
            padding: 10px;
            background-color: #007bff;
            color: #fff;
            border: none;
            cursor: pointer;
        }

        #scanQR {
            display: block;
            text-align: center;
            margin-top: 10px;
            color: #007bff;
        }

        @media screen and (max-width: 600px) {
            input[type="text"] {
                width: 100%;
            }

            button {
                width: calc(100% - 20px);
            }
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>Employee QR Code</h1>
        <form id="attendanceForm">
            <label for="name">Name:</label>
            <input type="text" id="name" name="name" placeholder="Enter your name">
            <label for="id">ID:</label>
            <input type="text" id="id" name="id" placeholder="Enter your ID">
            <label for="subject">Subject:</label>
            <input type="text" id="subject" name="subject" placeholder="Enter the subject">
         
            <label for="classroom">Classroom:</label>
            <input type="text" id="classroom" name="classroom" placeholder="Enter your classroom">
            <label for="yearLevel">Year Level:</label>
            <input type="text" id="yearLevel" name="yearLevel" placeholder="Enter your year level">

            <button type="button" onclick="generateQR()">Generate QR Code</button>
            <div id="qrCode"></div><br>
            <a href="#" id="scanQR" onclick="scanQRCode()">Scan QR Code</a>
        </form>
    </div>
    <script src="https://cdn.jsdelivr.net/gh/davidshimjs/qrcodejs/qrcode.min.js"></script>
    <script>
        function generateQR() {
            var name = document.getElementById('name').value;
            var id = document.getElementById('id').value;
            var subject = document.getElementById('subject').value;
            var classroom = document.getElementById('classroom').value;
            var yearLevel = document.getElementById('yearLevel').value;

            // Check if all required fields are filled
            if (name && id && subject) {
                var time = new Date().toLocaleString();

                // Generate the QR code
                var qrCodeData = `Name: ${name}, ID: ${id}, Subject: ${subject}, Time: ${time}`;
                if (classroom && yearLevel) qrCodeData += `, Classroom: ${classroom}, Year Level: ${yearLevel}`;

                var qrCodeElement = document.getElementById('qrCode');
                qrCodeElement.innerHTML = '';
                new QRCode(qrCodeElement, {
                    text: qrCodeData,
                    width: 128,
                    height: 128,
                    colorDark: '#000000',
                    colorLight: '#fff',
                    correctLevel: QRCode.CorrectLevel.H // High correction level
                });

                // Hide the form fields after generating QR code
                document.getElementById('attendanceForm').reset();
                document.getElementById('qrCode').style.display = 'block';
            } else {
                alert('Please fill all the required fields.');
            }
        }

        // Function to handle QR code scanning
        function scanQRCode() {
            // Check if the browser supports the WebRTC API
            if ('mediaDevices' in navigator && 'getUserMedia' in navigator.mediaDevices) {
                // Access the device camera
                navigator.mediaDevices.getUserMedia({ video: { facingMode: "environment" } })
                    .then(function(stream) {
                        // Redirect to the scanner page passing the stream as a URL parameter
                        window.location.href = "scanner.php?stream=" + encodeURIComponent(stream);
                    })
                    .catch(function(err) {
                        console.error('Error accessing camera: ', err);
                    });
            } else {
                alert('Sorry, your browser does not support camera access. Please use a different browser.');
            }
        }
    </script>
</body>

</html>
