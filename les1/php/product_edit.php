<?php
define('MySecr33t', true);
require __DIR__ . '/../inc/db.php';

$id = (int)($_GET['id'] ?? 0);
if ($id<=0) { header("Location: producten.php"); exit; }

// Charger produit
$stmt = $conn->prepare("SELECT pr_id, pr_naam, pr_prijs, pr_ct_id FROM producten WHERE pr_id=?");
$stmt->bind_param("i", $id);
$stmt->execute();
$prod = $stmt->get_result()->fetch_assoc();
if (!$prod) { header("Location: producten.php"); exit; }

// Charger catégories
$cats = $conn->query("SELECT ct_id, ct_naam FROM categorieen ORDER BY ct_naam");

// Traitement update
$msg = '';
if ($_SERVER['REQUEST_METHOD']==='POST') {
  $naam  = trim($_POST['naam'] ?? '');
  $prijs = (float)($_POST['prijs'] ?? 0);
  $ct_id = (int)($_POST['categorie'] ?? 0);

  if ($naam!=='' && $prijs>0) {
    $up = $conn->prepare("UPDATE producten SET pr_naam=?, pr_prijs=?, pr_ct_id=? WHERE pr_id=?");
    $up->bind_param("sdii", $naam, $prijs, $ct_id, $id);
    if ($up->execute()) {
      header("Location: producten.php"); exit;
    } else {
      $msg = "Fout bij bijwerken: ".$up->error;
    }
  } else {
    $msg = "Naam en prijs zijn verplicht.";
  }
}
?>
<!doctype html><meta charset="utf-8"><title>Product wijzigen</title>
<h1>Product wijzigen</h1>
<?php if($msg): ?><p style="color:red"><?=$msg?></p><?php endif; ?>
<form method="post">
  <p>Naam: <input name="naam" value="<?=htmlspecialchars($prod['pr_naam'])?>" required></p>
  <p>Prijs (€): <input name="prijs" type="number" step="0.01" value="<?=htmlspecialchars($prod['pr_prijs'])?>" required></p>
  <p>Categorie:
    <select name="categorie">
      <?php while($c=$cats->fetch_assoc()): ?>
        <option value="<?=$c['ct_id']?>" <?=$c['ct_id']==$prod['pr_ct_id']?'selected':''?>>
          <?=htmlspecialchars($c['ct_naam'])?>
        </option>
      <?php endwhile; ?>
    </select>
  </p>
  <p>
    <button type="submit">Opslaan</button>
    &nbsp; <a href="producten.php">Terug</a>
  </p>
</form>
