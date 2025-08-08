<!doctype html>
<html lang="en" dir="ltr">
<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Bootstrap CSS (RTL) -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.rtl.min.css" integrity="sha384-q8+l9TmX3RaSz3HKGBmqP2u5MkgeN7HrfOJBLcTgZsQsbrx8WqqxdA5PuwUV9WIx" crossorigin="anonymous">

  <title>lifeLink</title>

  <style>
    /* Modern Navbar Look */
    .navbar {
      background-color: #dc3545 !important; /* Red background */
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
      border-radius: 0 0 1rem 1rem;
    }
    .navbar .nav-link,
    .navbar .navbar-brand,
    .navbar .dropdown-item {
      color: white !important;
      font-weight: 500;
      transition: all 0.3s ease;
    }
    .navbar .nav-link:hover,
    .navbar .dropdown-item:hover,
    .navbar .navbar-brand:hover {
      color: #ffc107 !important; /* Smooth yellow hover */
    }
    .navbar .dropdown-menu {
      background-color: #dc3545;
      border-radius: 0.5rem;
    }
    .navbar .dropdown-item:hover {
      background-color: #c82333;
    }
    .btn-search {
      color: white;
      border: 2px solid white;
      border-radius: 25px;
      padding: 5px 20px;
      transition: all 0.3s ease;
    }
    .btn-search:hover {
      background-color: white;
      color: #dc3545;
    }
    /* Active link styling */
    .nav-link.active {
      color: #ffc107 !important;
      border-bottom: 2px solid #ffc107;
      border-radius: 0;
    }
  </style>
</head>
<body>
  <nav class="navbar navbar-expand-lg mb-4">
    <div class="container-fluid">
      <a class="navbar-brand" href="index.php">✦ lifeLink</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse" id="navbarNavDropdown">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0" id="navLinks">
          <li class="nav-item">
            <a class="nav-link" href="index.php">Home</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="admin_login.php">Admin Login</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="approve.php">Dashboard</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="logout.php"> ↪ Logout</a>
          </li>
        </a>
          
      </div>
    </div>
  </nav>

  <!-- Bootstrap Bundle with Popper -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js" integrity="sha384-k6d4wzSIapyDyv1kpU366/PK5hCdSbCRGRCMv+eplOQJWyd1fbcAu9OCUj5zNLiq" crossorigin="anonymous"></script>

  <!-- Script to auto-highlight active page -->
  <script>
    const currentPage = window.location.pathname.split("/").pop();
    const navLinks = document.querySelectorAll("#navLinks .nav-link");

    navLinks.forEach(link => {
      if (link.getAttribute("href") === currentPage) {
        link.classList.add("active");
      }
    });
  </script>
</body>
</html>
