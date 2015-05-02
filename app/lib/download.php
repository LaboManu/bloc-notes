<?php
/**
 * DownloadBinaryFile: Charger un fichier distant et l'enregistrer en local
 *
 * @author Fobec.com 2012
 * @copyright http://www.fobec.com/php5/1113/telecharger-fichier-distant-enregistrer-local.html 
 */
 
class DownloadBinaryFile {
 
    private $UA="Mozilla/5.0 (Windows NT 5.1; rv:10.0.2) Gecko/20100101 Firefox/10.0.2";
    private $REFERER="http://google.com";
 
    private $rawdata='';
 
/**
 * Télecharger un fichier distant
 * Les données sont stockées dans le tampon $rawdata
 * @param string $url
 * @return boolean
 */
    public function load($url) {
        $curl = curl_init ();
        curl_setopt ($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_HEADER, 0);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        if (!empty($this->UA)) {
            curl_setopt ($curl, CURLOPT_USERAGENT, $this->UA);
        }
        if (!empty($this->REFERER)) {
            curl_setopt($curl, CURLOPT_REFERER, $this->REFERER);
        }
        curl_setopt($curl, CURLOPT_BINARYTRANSFER,1);
        curl_setopt ($curl, CURLOPT_FOLLOWLOCATION, 1);
        $this->rawdata=curl_exec($curl);
 
        $httpcode=curl_getinfo($curl, CURLINFO_HTTP_CODE);
        if ($httpcode!=200) {
            return FALSE;
        }
 
        curl_close ($curl);
        return TRUE;
    }
 
/**
 * Enregister les données en local
 * @param string $filename
 */
    public function saveTo($filename) {
        if(file_exists($filename)){
            unlink($filename);
        }
        $fhandle=fopen($filename, "x");
        if ($fhandle) {
            fwrite($fhandle, $this->rawdata);
            fclose($fhandle);
        } else if (isset($error)) {
            throw new Exception("File reading denied to ".$file." !!!");
        }
    }
 
/**
 * Fixer le user agent pour la requet
 * @param string $ua
 */
    public function setUseragent($ua) {
        $this->UA=$ua;
    }
 
 /**
 * Fixer le referer pour la requet
 * @param string $referer
 */
    public function setReferer($referer) {
        $this->REFERER=$referer;
    }
}