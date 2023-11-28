<?php 
// include('connect.php');


// if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit'])) {
//    if (isset($_POST['email']) && isset($_POST['password'])) {
//         $email = $_POST['email'];
//         $password = $_POST['password'];

//         $sql = "INSERT INTO login (`email`, `password`) VALUES ('$email', '$password')";

//         $query = mysqli_query($connexion, $sql);
//         if ($query) {
//             echo 'Entry successful';
//             header('Location: index.php'); // Add a semicolon here
//             exit(); // Add an exit() to stop further execution
//         } else {
//             echo 'Error occurred: ' . mysqli_error($connexion);
//         }
//     }
// }
include('connect.php');
session_start();

function authenticateUser($email, $password, $connexion) {
    $stmt = $connexion->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch();

    if ($user && password_verify($password, $user['password'])) {
        return $user;
    } else {
        return null;
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $emailA = $_POST["email"];
    $passwordA = $_POST["password"];
    $authenticatedUser = authenticateUser($emailA, $passwordA, $connexion);

    if ($authenticatedUser) {
        if ($authenticatedUser['role'] == 'user') {
            header("Location: user1.php");
        } elseif ($authenticatedUser['role'] == 'product owner') {
            header("Location: po.php");
        } elseif ($authenticatedUser['role'] == 'scrum master') {
            header("Location: scrum.php");
        }

        $_SESSION["user"] = $authenticatedUser;
        $_SESSION["role"] = $authenticatedUser['role'];
        $_SESSION["lastname"] = $authenticatedUser['lastname'] . " " . $authenticatedUser['firstname'];
        exit();
    } else {
        echo "<p class='mt-4 text-sm text-gray-600'>Login failed. Invalid email or password.</p>";
    }
}
?>




<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script src="https://flowbite.com"></script>
    <script src="https://cdn.tailwindcss.com"></script>
    
    
</head>
<body class="bg-gradient-to-r from-violet-500 to-fuchsia-500">

    <nav class="bg-white border-gray-200 dark:bg-gray-900">
        <div class="max-w-screen-xl flex flex-wrap items-center justify-between mx-auto p-4">
          <a href="https://flowbite.com/" class="flex items-center space-x-3 rtl:space-x-reverse">
              <!-- <img src="https://flowbite.com/docs/images/logo.svg" class="h-8" alt="Flowbite Logo" /> -->
              <span class="self-center text-2xl font-semibold whitespace-nowrap dark:text-white">DataWare</span>
          </a>
          <button data-collapse-toggle="navbar-default" type="button" class="inline-flex items-center p-2 w-10 h-10 justify-center text-sm text-gray-500 rounded-lg md:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200 dark:text-gray-400 dark:hover:bg-gray-700 dark:focus:ring-gray-600" aria-controls="navbar-default" aria-expanded="false">
              <span class="sr-only">Open main menu</span>
              <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 17 14">
                  <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 1h15M1 7h15M1 13h15"/>
              </svg>
          </button>
          <div class="hidden w-full md:block md:w-auto" id="navbar-default">
            <ul class="font-medium flex flex-col p-4 md:p-0 mt-4 border border-gray-100 rounded-lg bg-gray-50 md:flex-row md:space-x-8 rtl:space-x-reverse md:mt-0 md:border-0 md:bg-white dark:bg-gray-800 md:dark:bg-gray-900 dark:border-gray-700">
             
              <li>
                <a href="/index2.html" class="block py-2 px-3 text-gray-900 rounded hover:bg-gray-100 md:hover:bg-transparent md:border-0 md:hover:text-blue-700 md:p-0 dark:text-white md:dark:hover:text-blue-500 dark:hover:bg-gray-700 dark:hover:text-white md:dark:hover:bg-transparent">Sign up</a>
              </li>
              <li>
                <a href="/index.html" class="block py-2 px-3 text-gray-900 rounded hover:bg-gray-100 md:hover:bg-transparent md:border-0 md:hover:text-blue-700 md:p-0 dark:text-white md:dark:hover:text-blue-500 dark:hover:bg-gray-700 dark:hover:text-white md:dark:hover:bg-transparent">Log in</a>
              </li>
             
            </ul>
          </div>
        </div>
      </nav>
    
<section class="justify-center h-full">
    
<form method="POST" action="" class="max-w-sm mx-auto bg-white rounded-md p-10 mt-20">
  <h1 class="text-center text-2xl p-4 font-semibold">Log in</h1>
    <div class="mb-5">
      <label for="email" class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-500">Your email</label>
      <input  type="email" id="email" name="email" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="" required>
    </div>
    <div class="mb-5">
      <label for="password" class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-500">Your password</label>
      <input type="password" id="password" name="password" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required>
    </div>
    <div class="flex items-start mb-5">
      <!-- <div class="flex items-center h-5">
        <input id="remember" type="checkbox" value="" class="w-4 h-4 border border-gray-300 rounded bg-gray-50 focus:ring-3 focus:ring-blue-300 dark:bg-gray-700 dark:border-gray-600 dark:focus:ring-blue-600 dark:ring-offset-gray-800 dark:focus:ring-offset-gray-800" required>
      </div>
      <label for="remember" class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-500">Remember me</label>
    </div> -->
    <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800" name="submit">Submit</button>
  </form>

  
</section>

    
  
</body>
</html>