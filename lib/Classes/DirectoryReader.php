<?php
/**
 * Name: Class DirectoryReader
 * Purpose: For reading or executing some actions to any specific folder and files which is under this folder.
 * Comment:
 * 
 * Editor: Jason Lai
 * Edit Time: 2018/12/11
 * Update Time: 2018/12/11
 */
class DirectoryReader
{
    // To store informations of all files.
    private static $fullFiles = array();
    // To store all valid formats.
    private static $validFormats = array();

    function __construct(){
        set_time_limit(0);
        ini_set('memory_limit', '256M');
    }

    /**
     * Get all files from any specific path.
     * @param string $dir: the path of a directory which need to search.
     * @return array an array which stores informations of all files under this specific path.
     */
    public static function getAllFiles($dir){
        $allFiles = scandir($dir);
        if(count($allFiles) > 2)
            self::queryAllFiles($dir, $allFiles);
        return $this->fullFiles;
    }

    /**
     * Search all files which is under a specific path.
     * @param string $dir: the path of a directory which need to search.
     * @param array $allFiles: all files under a specific path.
     */
    private static function queryAllFiles($dir, $allFiles){
        foreach($allFiles as $file){
            if($file == '.' || $file == '..') continue;
            $ext = pathinfo($file, PATHINFO_EXTENSION);
            if(!empty($ext)){
                self::getFileInfo($file);
            }else{
                $newDir = "$dir/$file";
                if(!is_dir($newDir)) continue;
                $allFiles = scandir($newDir);
                self::queryAllFiles($newDir, $allFiles);
            }
        }
    }

    /**
     * Get informations of a file.
     * @param string $file: the name of file which you want to get its information.
     * @param integer $mode: the mode of getting a file's information. It decides that how many
     * informations will be returned. Default is ALL_FILE_INFO and it will return all informations.
     * @return boolean the status of getting a file's informations.
     */
    private static function getFileInfo($file, $mode = ALL_FILE_INFO){
        if(empty($file)) return false;
        switch($mode){
            case ALL_FILE_INFO:
                $this->fullFiles[] = array(
                    'fileName' => pathinfo($file, PATHINFO_FILENAME),
                    'baseName' => pathinfo($file, PATHINFO_BASENAME),
                    'extension' => pathinfo($file, PATHINFO_EXTENSION),
                    'dirName' => pathinfo($file, PATHINFO_DIRNAME),
                );
                break;
            default:
                return false;
        }
        return true;
    }

    /**
     * Check whether a format of any file is valid or not.
     * You can also pass a custom valid formats to check by passing the second parameter.
     * @param string $format: the format of a file which need to check.
     * @param array $validFormats: a custom valid formats for checking is valid or not. Default is NULL.
     * @return boolean is the format valid or not.
     */
    public static function isValidFormat($format, $validFormats = NULL){
        if(empty($format)) return false;
        if(!empty($validFormats) && gettype($validFormats) != 'array') return false;
        if(empty($validFormats)){
            return in_array($format, $this->validFormats);
        }else{
            return in_array($format, $validFormats);
        }
    }
}
?>