<!doctype html>
<html lang="es">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover" />
  <meta http-equiv="X-UA-Compatible" content="ie=edge" />
  <title>{{ config('app.name') }}</title>

  <style>
    @import url('https://rsms.me/inter/inter.css');

    :root {
      --tblr-font-sans-serif: 'Inter Var', -apple-system, BlinkMacSystemFont, San Francisco, Segoe UI, Roboto, Helvetica Neue, sans-serif;
    }

    body {
      font-feature-settings: "cv03", "cv04", "cv11";
      text-align: center;
    }
  </style>
</head>

<body class=" border-top-wide border-primary d-flex flex-column">
  <div class="page page-center">
    <div class="container-tight">
      <div class="empty">
        <p class="empty-title">¡Acceso no permitido!</p>
        <div style="margin: auto; margin-top: -90px; text-align: center">
          <img width="650" height="650" src="{{ Storage::url('images/errors/403-error.png') }}" alt="">
        </div>
        <p class="empty-subtitle text-muted">
          "Solicita acceso al administrador del sistema, de lo contrario no podrás ingresar."
        </p>
      </div>
      <div class="empty-action">
        <a href="/" style="color: red; border: 1px solid red; font-weight: bold; border-radius: 10px; padding: 3px; text-decoration: none">
          <!-- Download SVG icon from http://tabler-icons.io/i/arrow-left -->
          <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="15" height="15" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
            <path d="M5 12l14 0" />
            <path d="M5 12l6 6" />
            <path d="M5 12l6 -6" />
          </svg>
          Volver
        </a>
      </div>
    </div>
  </div>
</body>

</html>