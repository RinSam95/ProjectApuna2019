<?php
require_once 'inc/top.php';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $firstName = filter_input(INPUT_POST,'firstName',FILTER_SANITIZE_STRING);
    $lastName = filter_input(INPUT_POST,'lastName',FILTER_SANITIZE_STRING);
    $email = filter_input(INPUT_POST,'email');
    $address = filter_input(INPUT_POST,'address',FILTER_SANITIZE_STRING);
    $postalCode = filter_input(INPUT_POST,'postalCode',FILTER_SANITIZE_STRING);
    $phoneNum = filter_input(INPUT_POST,'phoneNum',FILTER_SANITIZE_STRING);
    $password = filter_input(INPUT_POST,'password');
     // $password = md5(filter_input(INPUT_POST,'password'));
    $virhe = "";
    
    try {
        $db = new PDO('mysql:host=localhost;dbname=apuna;charset=utf8', 'sari95', '');
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }   catch (exception $ex) {
        header('location: error.php?error=' . urlencode($ex->getMessage()));
        print "<p>Error connecting database." . $ex->getMessage() . "</p>";
    } 
    
    try {
        $sql = "insert into user_account (firstName,lastName,email,address,postalCode,phoneNum,password)
        values (:firstName,:lastName,:email,:address,:postalCode,:phoneNum,:password)";
        $statement = $db->prepare($sql);
        $statement->bindValue(':firstName',$firstName,PDO::PARAM_STR);
        $statement->bindValue(':lastName',$lastName,PDO::PARAM_STR);
        $statement->bindValue(':email',$email,PDO::PARAM_STR);
        $statement->bindValue(':address',$address,PDO::PARAM_STR);
        $statement->bindValue(':postalCode',$postalCode,PDO::PARAM_STR);
        $statement->bindValue(':phoneNum',$phoneNum,PDO::PARAM_STR);
        $statement->bindValue(':password',$password,PDO::PARAM_STR);
        $statement->execute();
        header('location: thankyou.php');
        exit;
    } catch (Exception $ex) {
        print "<p>Sähköpostiosoite on jo käytössä tai kirjaamasi tiedot eivät ole kelvollisia!</p>";
        print "<p>Virheen kuvaus: <br>" . $ex->getMessage() . "</p>";
        
    }
}
?>

<form action="<?php print $_SERVER['PHP_SELF']?>" method="post" enctype="multipart/form-data">
    <div class="kappale">
        <p>Tervetuloa rekisteröitymään asiakkaaksemme!</p>
        <p>Kirjaa seuraavat tiedot ja hyväksy rekisteröityminen tallenna-painikkeella.</p>
        <p><?php print $virhe; ?></p>
    </div>
    <div class="form-group">
        <label>Etunimi</label>
        <input type="name" class="form-control" name="firstName" placeholder="Syötä etunimesi">
    </div>
    <div class="form-group">
        <label>Sukunimi</label>
        <input type="name" class="form-control" name="lastName" placeholder="Syötä sukunimesi">
    </div>
    <div class="form-group">
        <label>Sähköpostiosoite</label>
        <input type="email" class="form-control" name="email" aria-describedly="emailHelp" placeholder="Syötä sähköpostiosoitteesi">
        <small id="emailHelp" class="form-text text-muted">Emme koskaan jaa sähköpostiasi kenellekkään muulle.</small>
    </div>
    <div class="form-group">
        <label>Kotiosoite</label>
        <input type="name" class="form-control" name="address" placeholder="Syötä kotiosoitteesi">
    </div>
    <div class="form-group">
        <label>Postinumero</label>
        <input type="text" class="form-control" name="postalCode" placeholder="Syötä postinumerosi">
    </div>
    <div class="form-group">
        <label>Puhelinnumero</label>
        <input type="text" class="form-control" name="phoneNum" placeholder="Syötä puhelinnumerosi">
    </div>
    <div class="form-group">
        <label>Salasana</label>
        <input type="password" class="form-control" name="password" placeholder="Syötä salasanasi">
    </div>
    <button type="submit" class="btn btn-success">Tallenna</button>
</form>
<?php
require_once 'inc/bottom.php';
?>