<?php

class Logs {

    function __construct() {
        
    }

    function LogXML($sp, $sv, $type, $xml) {
		
        $file_ext = microtime();
        $todays_folder = 'systemlog/xml_depo/'. date('Y_m_d');
        $sv_folder = $todays_folder .'/' . $sv.'/';
        $file_name = $sv_folder. $type . '_' . $file_ext . '.xml';
        if (is_dir($todays_folder)) {
            if (is_dir($sv_folder)) {
			
                file_put_contents($file_name, $xml . "\n", FILE_APPEND | LOCK_EX);
            } else {
			
                mkdir($sv_folder);
                file_put_contents($file_name, $xml . "\n", FILE_APPEND | LOCK_EX);
            }
        } else {
		
            mkdir($todays_folder);
            mkdir($sv_folder);

            file_put_contents($file_name, $xml . "\n", FILE_APPEND | LOCK_EX);
        }
        return $file_name;
    }

    function ExeLog($log, $id = false) {
        $todays_folder = 'systemlog/tmp/' . date('Y_m');
        $file_name = $todays_folder . '/Execution_Log_File_' . date('Y_m_d') . '.txt';
 
        if (is_dir($todays_folder)) {
            $this->PrepareLog($file_name, $log, $id);
        } else {
            mkdir($todays_folder);
            $this->PrepareLog($file_name, $log, $id);
        }
    }

    function PrepareLog($file_name, $log, $level) {
        switch ($level) {
            case 1:
                //Log Start & Date
                file_put_contents($file_name, '[LOG START]' . "\n", FILE_APPEND);
                //Entry
                file_put_contents($file_name, '[' . date('Y-m-d H:i:s') . '] ' . $log . "\n", FILE_APPEND);
                break;
            case 2:
                //Entry
                file_put_contents($file_name, '[' . date('Y-m-d H:i:s') . '] ' . $log . "\n", FILE_APPEND);
                break;
            case 3:
                //Entry
                file_put_contents($file_name, '[' . date('Y-m-d H:i:s') . '] ' . $log . "\n", FILE_APPEND);
                //End Log
                file_put_contents($file_name, '[LOG STOP]' . "\n", FILE_APPEND);
                break;
            default:
                break;
        }
    }

}
