<?php
require_once("../../config.php");
?>
<script language="text/javascript">
    function addRelations(id)
    {
        
    }
</script>
<?php
/**
 * composant/editlink/contents.php
 * Edition des liens entre éléments. Ou "browser 2"
 */
$id = rawurldecode(filter_input(INPUT_GET, "dbdoc"));

/**
 * Loads relations as list of linked items
 * <span></span><a href="manageRelation(rel_id)">Relation</a><span></span>
 * @param type $id particular id to manage.
 */
function loadSelectDataParent($id)
{
    
}
/***
 * Load all data for inclusion in element {{id}}
 */
function loadSelectDataAllData($id)
{
    
}
?>
<select size="10" name="<?= $id ?>">
    <?php
        loadSelectDataAllData();
    ?>
</select>
<input type="button" name="addThis" value="Ajouter les relations" onclick="addRelations(<?= $id; ?>)"/>