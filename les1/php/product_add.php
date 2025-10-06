<?php
define('MySecr33t', true);
require __DIR__ . '/../inc/db.php';

// Charger catégories pour le select
$cats = $conn->query("SELECT ct_id, ct_naam FROM categorieen ORDER BY ct_naam");

// Traitement formulaire
$msg = '';
if ($_SERVER['REQUEST_METHOD']==='POST') {
  $naam  = trim($_POST['naam'] ?? '');
  $prijs = (float)($_POST['prijs'] ?? 0);
  $ct_id = (int)($_POST['categorie'] ?? 0);

  if ($naam!=='' && $prijs>0) {
    $stmt = $conn->prepare("INSERT INTO producten (pr_naam, pr_prijs, pr_ct_id) VALUES (?,?,?)");
    $stmt->bind_param("sdi", $naam, $prijs, $ct_id);
    if ($stmt->execute()) {
      header("Location: producten.php"); exit;
    } else {
      $msg = "Fout bij opslaan: ".$stmt->error;
    }
  } else {
    $msg = "Naam en prijs zijn verplicht.";
  }
}
?>
<!doctype html><meta charset="utf-8"><title>Nieuw product</title>
<h1>Nieuw product toevoegen</h1>
<?php if($msg): ?><p style="color:red"><?=$msg?></p><?php endif; ?>
<form method="post">
  <p>Naam: <input name="naam" required></p>
  <p>Prijs (€): <input name="prijs" type="number" step="0.01" required></p>
  <p>Categorie:
    <select name="categorie">
      <?php while($c=$cats->fetch_assoc()): ?>
        <option value="<?=$c['ct_id']?>"><?=htmlspecialchars($c['ct_naam'])?></option>
      <?php endwhile; ?>
    </select>
  </p>
  <p><button type="submit">Opslaan</button> &nbsp; <a href="producten.php">Annuleren</a></p>
</form>
