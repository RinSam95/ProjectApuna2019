create table user_account (
    id int primary key auto_increment,
    firstName char(50),
    lastName char(50),
    email varchar(100) not null unique,
    address varchar(100),
    postalCode smallint,
    phoneNum smallint,
    password varchar(255) not null
);

insert into product (name, description, unitprice)
values ('Ranneketju A', 'Kauniisti kimalteleva ranneke', 10.00)

insert into product (name, description, unitprice)
values ('Ranneketju B', 'Lumoavasti kimalteleva ranneke', 20.00)


<?php
session_start();
session_regenerate_id();

header('location: index.php');
  exit;
?>


<?php
 if (!isset($_SESSION['user_account_id']) &&
       !(basename($_SERVER['PHP_SELF']) === 'login.php' || basename($_SERVER['PHP_SELF']) === 'register.php')) {
    header('location: register.php');
    exit;
} else {
  header('location: index.php');
  exit;
}

try {
    $db = new PDO('mysql:host=localhost;dbname=apuna;charset=utf8','root','');
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (Exception $ex) {
   header('location: error.php?error=' . urlencode($ex->getMessage()));
}
?>

/* phpmyadmin-ctl install */


              
              
         