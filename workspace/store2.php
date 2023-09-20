<?php
require_once 'inc/top.php';

    try {
        $db = new PDO('mysql:host=localhost;dbname=apuna;charset=utf8', 'sari95', '');
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }   
    catch (exception $ex) {
        header('location: error.php?error=' . urlencode($ex->getMessage()));
        print "<p>Error connecting database." . $ex->getMessage() . "</p>";
    }
    
    if (isset($_GET['poista'])) {
    unset($_SESSION['kori']);
    }
    
    if (!isset($_SESSION['kori'])) {
    $_SESSION['kori'] = array();
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $product_id = filter_input(INPUT_POST,'id',FILTER_SANITIZE_NUMBER_INT);
    array_push($_SESSION['kori'],$product_id);
    }
?>
<p>Tervetuloa Apuna-kauppaan!</p>
<p>Valitse seuraavista tuotteista</p>

    <div class="row">
    <div class="col-sm-6">
    <?php
    $sql = "select * from product";
    $kysely = $db->query($sql);
    
    while ($tietue = $kysely->fetch()) {
        print "<form action='" . $_SERVER['PHP_SELF']  
                . "' method='post'>";
        print "<input type='hidden' name='id' value='" . $tietue['id'] . "'>";
        print "<p>" . $tietue['name'] . ", " . $tietue['description'] . "</p>";
        print "<p><img src='photos/apuna" . $tietue['id'] . ".jpg' alt='' style='width:200px;'/></p>";
        // print "<p><a href='store2.php?id=" . $tietue['id'] . "'>" . $tietue['name'] . ", " . $tietue['description'] . "</a></p>";
        print "<p>" . $tietue['unitprice'] . "€</p>";
        print "<button class='btn btn-success'>Koriin</button>";
        print "</form>";
        print "<hr>";
    }
    ?>
    </div>
    
    <div class="col-sm-6">
        <p>Ostoskorin sisältö</p>
     <?php
    if (isset($_SESSION['kori'])) {
        $summa = 0;
        foreach ($_SESSION['kori'] as $product_id) {
            //print "$tuote_id<br />";
            $sql = "select * from product where id = $product_id";
            $kysely = $db->query($sql);
            $product = $kysely->fetch();
            $summa+=$product['unitprice'];
            print $product['name'] . ', ' . $product['unitprice'] . ' €<br />';
        }
        print "<p>Yhteensä $summa €</p>";
        
        print "<a href='" . $_SERVER['PHP_SELF'] . "?poista=true' class='btn btn-danger'>Tyhjennä</a>";
        if (count($_SESSION['kori']) > 0) {
            print "&nbsp;&nbsp;&nbsp;<a href='thankyou_purchase.php' class='btn btn-success'>&nbsp;Osta tuotteet</a>";
        }
    }
    
    ?>    
    </div>
    
    
<?php
require_once 'inc/bottom.php';
?>