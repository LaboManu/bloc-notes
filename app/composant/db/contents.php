<?php

require_once("../../config.php");
?>
<h2>Modifications récentes</h2>
<table>
<?php
$resultsArrDB = listHistory();


while(($row=  mysql_fetch_assoc($resultsArrDB))!=NULL)
{
    ?>
    <tr>
        <td><?= $row['user']     ?></td>
        <td><?= $row['filename'] ?></td>
        <td><?= $row['moment']   ?></td>
        <td><?=  $row['type']    ?></td>
        <td><?= $row['contenu']  ?></td>
    </tr><?php
}
?>
</table>