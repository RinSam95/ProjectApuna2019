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
?>
    <div>
        <p>Kiitos ostoksistasi!<p>
             <div class="col-sm-6">
        <p>Ostit seuraavat tuotteet:</p>
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
            }
            
            ?>    
            </div>
        <p><a href="index.php">Etusivulle</a></p>
    </div>
<?php
require_once 'inc/bottom.php';
?>