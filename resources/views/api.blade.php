<!DOCTYPE html>
<html>
<head>
    <title>Generate API Key</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
        }

        .container {
            max-width: 400px;
            margin: 0 auto;
            background-color: #f5f5f5;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        h1 {
            text-align: center;
            margin-top: 0;
        }

        .form-group {
            margin-bottom: 20px;
        }

        label {
            display: block;
            font-weight: bold;
            margin-bottom: 5px;
        }

        input[type="text"] {
            width: 100%;
            padding: 10px;
            font-size: 14px;
            border: 1px solid #ddd;
            border-radius: 3px;
        }

        .btn-container {
            text-align: center;
        }

        button {
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 3px;
            cursor: pointer;
            font-size: 14px;
        }

        #response {
            margin-top: 20px;
            display: none;
        }

        #copy-btn {
            margin-top: 10px;
        }

        .success-msg {
            color: #4CAF50;
            margin-top: 10px;
        }
    </style>
</head>
<body>
<div class="container">
    <h1>Generate API Key</h1>

    <div id="response">
        <label>Generated API Key:</label>
        <div class="input-group">
            <input type="text" id="api-key" readonly>
            <button id="copy-btn">Copy</button>
        </div>
        <div class="success-msg" id="copy-success-msg"></div>
    </div>

    <div class="form-group">
        <label>Description:</label>
        <input type="text" id="description">
    </div>

    <div class="btn-container">
        <button id="generate-btn">Generate Key</button>
    </div>

    <script>
        document.getElementById('generate-btn').addEventListener('click', function() {
            var description = document.getElementById('description').value;

            fetch('/api-keys', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({ description: description })
            })
                .then(response => response.json())
                .then(data => {
                    document.getElementById('api-key').value = data.key;
                    document.getElementById('response').style.display = 'block';
                })
                .catch(error => {
                    console.error('Error:', error);
                });
        });

        document.getElementById('copy-btn').addEventListener('click', function() {
            var apiKeyInput = document.getElementById('api-key');
            apiKeyInput.select();
            apiKeyInput.setSelectionRange(0, 99999);
            document.execCommand('copy');
            document.getElementById('copy-success-msg').textContent = 'Copied to clipboard!';
        });
    </script>
</div>
</body>
</html>
