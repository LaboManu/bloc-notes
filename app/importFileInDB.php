<?php

class TableGestionFichier {


    function verifierExistenceFichier($filename) {
        $this->connect();
        $query = "select id from blocnotes_revisions where filename=$filename;";
        $result = mysql_query($query);
        if ($count = mysql_count($result) > 0) {
            $row = mysql_fetch_assoc($result);
            return $$row['id'];
        } else {
            return -1;
        }
    }

    function infosFichier($id, &$revision = "-1", &$path = "/") {
        $this->connect();
        $query = "select path, id from blocnotes_revisions;";
        $result = mysql_query($query);
        $row = mysql_fetch_assoc($result);
        if ($row != NULL) {

            $revision = $row["revision"];
            $path = $row["path"];
            return 0;
        } else {
            return -1;
        }
    }

    function associerFichier($id1, $id2) {
        
    }

    function getLastRevID($revid) {

        $this->connect();
        $query = "select max(id) as $id from blocnotes_revisions where revid=$revid";
        $result = mysql_query($query);
        $row = mysql_fetch_assoc($result);
        $id = $row["maxrevid"];
        return $id;
    }

    function insertFichier($filename, $path) {
        $revision;
        $path;
        $this->connect();
        if (infosFichier($id = verifierExistenceFichier()) == -1) {
            $this->backupRevision($revid);
            $query = "insert into revisions (revid, filename,path) values($id, filename, path);";
            $result = mysql_query($query);
        } else {
            return -1;
        }
    }

    function insertNewItem($filename) {


        $this->connect();
        $query = "select max(serid) as maxserid from blocnotes_items;";
        $result = mysql_query($query);
        $row = fetch_assoc_assoc($query);
        $axserid = $row['maxserid'];
        $query = "insert into blocnotes_items(filename, serid) values($filename, $maxserid);";
        $result = mysql_query($query);
        return 0;
    }

    function deplacerFichier($id, $filename, $path) {
        $this->insertFichier($filename, $path);
    }

    function updateFichier($id, $filename, $path) {
        $this->insertFichier($filename, $path);
    }

    function supprimerFichier($id) {
        $this->insertFichier($filename, "\DELETED");
    }

    function adressePhysiqueItem($id) {
        $revision = "-1";
        $path = "/";
        infosFichier($id);
        return $path;
    }

    function getNameForUpload($filename) {
        $this->connect();
        $query = "select * blocnotes_items;";
        $result = mysql_query($query);
        $id = mysql_count($result) + 10000001;
        return "id" . $id . "t" . time() . "--" . $filename;
    }

    function pushRev($id, $filename) {
        $revision = "-1";
        $path = "/";
        infosFichier($id);
        deplacerFichier($id, $filename, $path);
    }

}

class InterfaceFichierDB {
    
}

?>