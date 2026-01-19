<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nuevo Mensaje de Contacto</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            color: #333;
            line-height: 1.6;
        }
        .container {
            width: 80%;
            margin: 20px auto;
            background: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        h2 {
            color: #2c3e50;
            border-bottom: 2px solid #3498db;
            padding-bottom: 10px;
        }
        .field {
            margin-bottom: 15px;
        }
        .label {
            font-weight: bold;
            color: #555;
            display: block;
            margin-bottom: 5px;
        }
        .value {
            background: #f9f9f9;
            padding: 10px;
            border-left: 4px solid #3498db;
        }
        .footer {
            margin-top: 20px;
            font-size: 12px;
            color: #777;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Nuevo Mensaje de Contacto</h2>
        
        <div class="field">
            <span class="label">Nombre:</span>
            <div class="value">{{ $data['name'] }}</div>
        </div>

        <div class="field">
            <span class="label">Email:</span>
            <div class="value">{{ $data['email'] }}</div>
        </div>

        <div class="field">
            <span class="label">Asunto:</span>
            <div class="value">{{ $data['subject'] }}</div>
        </div>

        <div class="field">
            <span class="label">Mensaje:</span>
            <div class="value" style="white-space: pre-line;">{{ $data['message'] }}</div>
        </div>

        <div class="footer">
            Este mensaje fue enviado desde el formulario de contacto de Custom Camis.
        </div>
    </div>
</body>
</html>
