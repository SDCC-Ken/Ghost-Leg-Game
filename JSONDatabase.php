<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of JSONDatabase
 *
 * @author user
 */
class JSONDatabase {
    
    var $filenaeme = NULL;



    public function createJSON($filename, $object) {
        if (!file_exists(realpath(dirname(__FILE__) . "/json/" . $filename . ".json"))) {
            $fp = fopen(dirname(__FILE__) . "/json/" . $filename . ".json", 'w');
            fwrite($fp, json_encode($object));
            fclose($fp);
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function readJSON($filename) {
        if (file_exists(realpath(dirname(__FILE__) . "/json/" . $filename . ".json"))) {
            $myfile = fopen(dirname(__FILE__) . "/json/" . $filename . ".json", "r");
            $json = fread($myfile, filesize(dirname(__FILE__) . "/json/" . $filename . ".json"));
            fclose($myfile);
            return json_decode($json);
        } else {
            return NULL;
        }
    }

    public function updateJSON($filename, $newobject) {
        if (file_exists(realpath(dirname(__FILE__) . "/json/" . $filename . ".json"))) {
            return ($this->deleteJSON($filename)) ? $this->createJSON($filename, $newobject) : FALSE;
        } else {
            return FALSE;
        }
    }

    public function deleteJSON($filename) {
        return (file_exists(realpath(dirname(__FILE__) . "/json/" . $filename . ".json"))) ? unlink(dirname(__FILE__) . "/json/" . $filename . ".json") : FALSE;
    }

}
