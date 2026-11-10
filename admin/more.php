<?php
require __DIR__ . '/inc.php';
require_login();
admin_start('Zaidi', 'more.php');
?>
<div class="ad-head"><h1>Sehemu nyingine</h1></div>
<div class="tiles">
  <a class="tile" href="edit.php?t=services"><b>Ibada za Jumapili</b><span>Saa na maelezo ya ibada</span></a>
  <a class="tile" href="edit.php?t=schedule"><b>Ratiba ya wiki</b><span>Maombi, kwaya, jumuiya</span></a>
  <a class="tile" href="edit.php?t=fellowships"><b>Vikundi</b><span>Kwaya, vijana, wanawake...</span></a>
  <a class="tile" href="users.php"><b>Watumiaji</b><span>Nani anaweza kuingia hapa</span></a>
</div>
<?php admin_end();
