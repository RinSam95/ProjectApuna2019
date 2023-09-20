<?php require_once 'inc/top.php';
    try {
        $db = new PDO('mysql:host=localhost;dbname=apuna;charset=utf8', 'sari95', '');
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }   
    catch (exception $ex) {
        header('location: error.php?error=' . urlencode($ex->getMessage()));
        print "<p>Error connecting database." . $ex->getMessage() . "</p>";
    }
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = filter_input(INPUT_POST,'name',FILTER_SANITIZE_STRING);
    $email = filter_input(INPUT_POST,'email');
    $message = filter_input(INPUT_POST,'message',FILTER_SANITIZE_STRING);
    $virhe = "";
    
    try {
        $db = new PDO('mysql:host=localhost;dbname=apuna;charset=utf8', 'sari95', '');
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }   catch (exception $ex) {
        header('location: error.php?error=' . urlencode($ex->getMessage()));
        print "<p>Error connecting database." . $ex->getMessage() . "</p>";
    } 
    
    try {
        $sql = "insert into contact (name,email,message)
        values (:name,:email,:message)";
        $statement = $db->prepare($sql);
        $statement->bindValue(':name',$name,PDO::PARAM_STR);
        $statement->bindValue(':email',$email,PDO::PARAM_STR);
        $statement->bindValue(':message',$message,PDO::PARAM_STR);
        $statement->execute();
        header('location: thankyou_contact.php');
        exit;
    } catch (Exception $ex) {
        print "<p>Valitettasti palautettasi ei voitu tallentaa.</p>";
        print "<p>Virheen kuvaus: <br>" . $ex->getMessage() . "</p>";
        
    }
}

?>
<div class="row">
<form action="yhteydenotto2.php" method="post">
<h2 class="otsikko">Yhteydenottolomake</h2>
<div class="kappale">
<p>Nimi</p> <input type="text" name="name">
<p>Sähköposti</p> <input type="text" name="email">
<p>Viesti</p><textarea name="message" rows="5" cols="20" type="textarea" placeholder="Kirjoita viestisi tähän"></textarea><br />
<input type="submit" value="Lähetä"><input type="reset" value="Tyhjennä">
</div>
</form>
</div>
<?php require_once 'inc/bottom.php';?>      
