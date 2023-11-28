<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html lang="pt-br" xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">

    <style type="text/css">
        html,
        body {
            border: 0 !important;
            margin: 0 !important;
            width: 100% !important;
        }

        h1 {
            font-weight: bold;
            color: #2698d4;
        }

        p {
            color: #2698d4;
            font-weight: 500;
            font-size: 18px;
        }

        .container {
            width: 95%;
            background-color: white;
            font-family: Verdana, Geneva, Tahoma, sans-serif;
            padding: 20px;
            text-align: center;
            border: 3px #2698d4 solid;
            border-radius: 5px;
        }

        .code {
            font-weight: bold;
            font-size: 26px;
            color: #2698d4;
        }

        .obs {
            font-weight: 300;
            font-size: 15px;
            color: #9fbbc9;
        }

        img {
            height: 3rem;
        }
    </style>
</head>

<body>
    <div class="container">
        <img src="{{asset('images/logo.png')}}" alt="">
        <!-- <img src="{{asset('images/logo.png')}}" alt=""> -->
        <p>Seu cadastro está quase completo!</p>
        <p>Para completar acesse <a href="{{env('APP_URL')}}" target="_blank">este link</a>, entre com a senha provisória que foi criada para você.</p>
        <p>Assim que logar pela primeira vez, você precisará alterar sua senha!</p>
        <p class="obs">Esse e-mail é automático, por favor não responda.</p>
    </div>
</body>

</html>