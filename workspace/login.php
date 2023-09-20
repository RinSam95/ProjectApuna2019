<?php
require_once 'inc/top.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = filter_input(INPUT_POST,'email');
    $password = filter_input(INPUT_POST,'password');
    // $password = md5(filter_input(INPUT_POST,'password'));
    
    try {
        $db = new PDO('mysql:host=localhost;dbname=apuna;charset=utf8', 'sari95', '');
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }   
    catch (exception $ex) {
        header('location: error.php?error=' . urlencode($ex->getMessage()));
        print "<p>Error connecting database." . $ex->getMessage() . "</p>";
    } 
    
    $sql = "select id from user_account where email='$email' and password='$password'"; 
    
    $statement = $db->query($sql);
    if ($statement) {
        $user_account = $statement->fetch();
        if ($user_account) {
            session_destroy();
            $_SESSION['user_account_id'] = $user_account['id'];
            $_SESSION['user_picture'] = $user_account['picture'];
            header('location: store2.php');
            exit;
        }
        else {
            print "<p>Incorrect email or password. (" . $password . " " . $email . ")</p>";
        }
    }
    else {
         print "<p>Error retrieving user account information.</p>";
    }
}

?>
<form action="<?php print $_SERVER['PHP_SELF']?>" method="post">
    <div class="form-group">
        <label>Sähköpostiosoite</label>
        <input type="email" class="form-control" name="email" aria-describedby="emailHelp" placeholder="Sähköposti">
    </div>
    <div class="form-group">
        <label>Salasana</label>
        <input type="password" class="form-control" name="password" placeholder="Salasana">
    </div>
    <button type="submit" class="btn btn-success">Kirjaudu sisään</button>
    <a href="register.php" class="register">Rekisteröidy</a>
</form>
<?php
require_once 'inc/bottom.php';
?>