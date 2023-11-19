<html>
<body>
  <form action="processLogin.php" method="post">
     <input type="text" name="username"/>
     <input type="password" name="password"/>
     <input type="submit" value="Ingresar"/>
  </form>
</body>
</html>
<?php

$username = $_POST['username'];
$password = $_POST['password'];

$sql = "SELECT u.id, r.name AS role, password FROM users u INNER JOIN roles r ON r.id = u.role_id WHERE username = '$username';";

// Conectar a la base de datos
// ejecutar la consulta
// $result contiene el resultado de la consulta

if (password_verify($result['password'], password_hash($password, PASSWORD_BCRYPT))) {
   $startingPage = [
      'admin' => 'admin_home.php',
      'user' => 'user_home.php',
   ];

   $nextPage = array_key_exists($result['role'], $startingPage) ? $startinPage['role'] : 'user_home.php';
   if (array_key_exists($result['role'], $startingPage)) {
      $nextPage = $startinPage[$result['role']];
   } else {
      $nextPage = $startinPage['user'];
      error_log('There is no starting page for role '.$result['role']);
   }
   session_start();
   $_SESSION['user_id'] = $result['id'];
   $_SESSION['role'] = $result['role'];
   header('Location: '.$nextPage);
} else {
   header('Location: login.html');
}
?>
<?php

// admin_home.php

session_start();

if (!array_key_exists('user_id', $_SESSION)) {
   header('Location: login.html');
   die;
}

$allowedRoles = ['admin'];

if (!array_key_exists('role', $_SESSION) || !in_array($_SESSION['role'], $allowdRoles)) {
   header('Location: login.html');
   die;
}
?>
<h1>Bienvenido amind!</h1>