<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>PAGE NOT FOUND</title>
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
</head>
<body class="bg-white">
    <nav class="navbar p-3 border-bottom top-0 position-sticky">
       <div class="container-fluid">
       <a class="navbar-brand d-flex align-items-center fw-bolder fs-4" href="#">
            <img src="../storage/Eo_circle_deep-purple_letter-q.svg.png" alt="app logo" style="width:45px; height:45px;" class="d-inline-block align-text-top">
            QuickFeed
          </a>
          <a class="btn btn-primary border-0" href="{{ route('home') }}">Home</a>
       </div>
    </nav>
    <main class="d-flex align-items-center justify-content-center bg-white">

        <img src="../storage/404-error-page.jpg" alt="" style="width: 50%; height:50%">
    </main>
</body>
</html>