<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="qrc.css">
    <title>QR Code Scanner / Reader</title>
    <style>
        .container {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            padding: 20px;
        }

        #my-qr-reader {
            width: 250px;
            height: 250px;
            margin-right: 20px;
        }

        #qrData {
            border: 1px solid #ddd;
            padding: 10px;
            width: calc(100% - 280px); /* 250px width of QR scanner + 20px margin + 10px padding */
            max-width: 400px;
            background-color: #f9f9f9;
        }

        table {
            width: 100%;
            margin-top: 10px;
        }

        th,
        td {
            border-bottom: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }
    </style>
</head>

<body>
    <div class="container">
        <div id="my-qr-reader"></div>
        <div id="qrData"></div>
    </div>
    <script src="https://unpkg.com/html5-qrcode"></script>
    <script src="https://cdn.jsdelivr.net/gh/davidshimjs/qrcodejs/qrcode.min.js"></script>
    <script>
        function domReady(fn) {
            if (document.readyState === "complete" || document.readyState === "interactive") {
                setTimeout(fn, 1000);
            } else {
                document.addEventListener("DOMContentLoaded", fn);
            }
        }

        domReady(function () {
            const qrDataDiv = document.getElementById('qrData');

            function onScanSuccess(qrCodeMessage) {
                const qrData = JSON.parse(qrCodeMessage);
                displayQRData(qrData);
            }

            let htmlScanner = new Html5QrcodeScanner(
                "my-qr-reader", {
                    fps: 10,
                    qrbox: 250
                });

            htmlScanner.render(onScanSuccess);

            function displayQRData(data) {
                let dataHTML = '<h2>QR Code Data:</h2>';
                dataHTML += '<table>';
                for (let key in data) {
                    dataHTML += `<tr><th>${key}</th><td>${data[key]}</td></tr>`;
                }
                dataHTML += '</table>';
                qrDataDiv.innerHTML = dataHTML;
            }
        });
    </script>
</body>

</html>
