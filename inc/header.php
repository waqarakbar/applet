<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Bootstrap Page with Menu</title>
  <!-- Bootstrap CSS -->
  <link href="./assets/bootstrap-5.3.6-dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
  <!-- Navigation Menu -->
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
      <a class="navbar-brand" href="#">GHL Applet</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ms-auto">
          <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="/">Home</a>
          </li>

          <li class="nav-item">
            <a class="nav-link" href="./help.php">Help</a>
          </li>

          <li class="nav-item">
            <a class="nav-link" href="#">Generate Token</a>
          </li>

          <li class="nav-item">
            <a class="nav-link" href="./logout.php">Logout</a>
          </li>

        </ul>
      </div>
    </div>
  </nav>

  <!-- Content Section -->
  <div class="container mt-5">
    
  