<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of gallery
 *
 * @author dheo
 */
class Digilib {

  //put your code here
  function directoryList() {
    return array_diff(scandir(DIGILIB_DIR), array('..', '.'));
  }
  /* function:  returns files from dir */

  function get_files($digilib_dir, $exts = array('pdf','doc','docx')) {
    $files = array();
    if ($handle = opendir($digilib_dir)) {
      while (false !== ($file = readdir($handle))) {
        $extension = strtolower($this->get_file_extension($file));
        if ($extension && in_array($extension, $exts)) {
          $files[] = $file;
        }
      }
      closedir($handle);
    }
    sort($files, SORT_NATURAL);
    return $files;
  }

  /* function:  returns a file's extension */

  function get_file_extension($file_name) {
    return substr(strrchr($file_name, '.'), 1);
  }

}
