<h2>Modifications récentes</h2>
<table>
<?php

require_once("../../config.php");

$resultsArrDB = listHistory();


while(($row=  mysql_fetch_assoc($resultsArrDB))!==null)
{
    ?>
    <tr>
        <td><?= $row['user']     ?></td>
        <td><?= $row['filename'] ?></td>
        <td><?= $row['moment']   ?></td>
        <td><?=  $row['type']    ?></td>
    </tr><?php
}
?>
</table>