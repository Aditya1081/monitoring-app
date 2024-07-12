<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>403 Forbidden</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f4f4f4;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .error-container {
            text-align: center;
            background: white;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            max-width: 400px;
            /* Menyesuaikan lebar container */
            width: 100%;
        }

        .error-title {
            margin-bottom: 20px;
        }

        .error-title img {
            max-width: 250px;
            /* Menyesuaikan ukuran maksimum gambar */
            width: 100%;
            height: auto;
        }

        .error-message {
            font-size: 24px;
            margin-bottom: 20px;
        }

        .back-button {
            font-size: 18px;
            padding: 10px 20px;
        }
    </style>
</head>

<body>
    <div class="error-container">
        <div class="error-title">
            <img src="{{ asset('assets/images/403 Error.png') }}" alt="Custom Image">
        </div>
        <div class="error-message">Anda tidak memiliki akses untuk halaman ini.</div>
        <button onclick="goBack()" class="btn btn-primary back-button">Kembali</button>
    </div>

    <script>
        function goBack() {
            window.history.back();
        }
    </script>
</body>

</html>
