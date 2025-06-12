<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Tours & Travel</title>
  <link rel="stylesheet" href="css/style.css">
  <style>
    /* Sticky Header */
    nav {
      position: fixed;
      top: 0;
      width: 100%;
      background-color: #002147;
      padding: 1rem;
      display: flex;
      justify-content: space-between;
      align-items: center;
      color: white;
      z-index: 999;
      box-shadow: 0 2px 8px rgba(0, 0, 0, 0.2);
    }

    nav div:first-child {
      font-weight: bold;
      font-size: 1.5rem;
    }

    nav a {
      color: white;
      text-decoration: none;
      position: relative;
      padding: 8px 12px;
      transition: color 0.3s ease;
    }

    nav a::after {
      content: '→';
      position: absolute;
      opacity: 0;
      right: -15px;
      transition: opacity 0.3s, right 0.3s;
    }

    nav a:hover {
      color: #FFD700;
    }

    nav a:hover::after {
      opacity: 1;
      right: -5px;
    }

    .nav-links {
      display: flex;
      gap: 20px;
    }

    /* To prevent content from hiding behind the fixed nav */
    body {
      margin: 0;
      padding-top: 80px; /* Height of the nav */
      font-family: Arial, sans-serif;
    }
  </style>
</head>
<body>

<!-- Navigation Bar -->
<nav>
  <div>Tours & Travel</div>
  <div class="nav-links">
    <a href="index.php?page=home">Home</a>
    <a href="index.php?page=about">About</a>
    <a href="index.php?page=packages">Packages</a>
    <a href="index.php?page=booking">Booking</a>
    <a href="index.php?page=review">Reviews</a>
    <a href="index.php?page=contact">Contact</a>
    <a href="index.php?page=login">Login</a>
    <a href="index.php?page=register">Register</a>
    <!-- Updated links below -->
    <a href="index.php?page=view_replies">📬 View Messages</a> <!-- Fixed View Messages link -->
    <a href="admin\admin_login.php"> Admin</a>

  </div>
</nav>

