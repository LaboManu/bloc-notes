<?php

class HashTag {

    private $db_key;
    private $secretkey;

    /**
     * initialise la paire de clés pour le hachage et le cryptage
     */
    function initSecretKey() {
        global $monutilisateur;
        // Get private key from db
        // Get secret key from db_key
        $q = "select public_key, secret_text from blocnotes_key where username='".mysql_real_escape_string($monutilisateur)."'";
        
    }

    function getFullFilename($hash) {
        
    }

    function getHachages($blocnoteName = "*") {
        
    }

    function getFileContent($fullName) {
        
    }

    function renameOrMove($fullName1, $fullName2) {
        
    }

    function getPartagesPourMoi() {
        
    }

    function getPartagesParMoi() {
        
    }

}
