<?php
define('MySecr33t', true);
require __DIR__ . '/../inc/db.php';

$sql = "SELECT p.pr_id, p.pr_naam, p.pr_prijs, c.ct_naam
        FROM producten p
        LEFT JOIN categorieen c ON p.pr_ct_id = c.ct_id
        ORDER BY p.pr_id";
$res = $conn->query($sql) or die("Query fout: ".$conn->error);
?>
<!doctype html><meta charset="utf-8"><title>Producten</title>
<h1>Producten</h1>
<p><a href="product_add.php">+ Nieuw product</a></p>
<table border="1" cellpadding="6" cellspacing="0">
  <tr><th>ID</th><th>Naam</th><th>Prijs (€)</th><th>Categorie</th><th>Acties</th></tr>
  <?php while($r=$res->fetch_assoc()): ?>
  <tr>
    <td><?=htmlspecialchars($r['pr_id'])?></td>
    <td><?=htmlspecialchars($r['pr_naam'])?></td>
    <td><?=number_format($r['pr_prijs'],2,',',' ')?></td>
    <td><?=htmlspecialchars($r['ct_naam'])?></td>
    <td><a href="product_edit.php?id=<?=$r['pr_id']?>">Wijzigen</a></td>
  </tr>
  <?php endwhile; ?>
</table>
<?php $conn->close(); ?>
