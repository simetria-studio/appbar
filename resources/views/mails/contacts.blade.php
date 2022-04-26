<!DOCTYPE html>
<html lang="en">

<head>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      {{-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet"> --}}
      <meta http-equiv="X-UA-Compatible" content="ie=edge">
      <title>Email</title>
</head>

<body>
      <div class="container">
            <div>
                  <img  src="{{ url('assets/img/logo-mail.png') }}" alt="">
            </div>

            <div>
                  <h3>Olá {{ $name }}</h3>

                  <p>Acabamos de receber a sua inscrição.</p>

                  <p>Obrigado!</p>

                  <p>Equipe Celeiro do Malte</p>
            </div>
      </div>
      <style>
            .container {
                  width: 100%;
                  margin-right: auto;
                  margin-left: auto;
                  text-align: center;
            }
      </style>
</body>

</html>