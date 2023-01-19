<?php

class Ical
{
    private $name;
    private $pathIcalSave;
    private $proID;
    private $version;
    private $calscale = 'GREGORIAN';
    private $method;
    private $Event = array();

    /**
     * @param array $Data - ['patchIcal'] = Path to Ical | ['proID'][0] = Company Name | ['proID'][1] == Product name | ['Version'] = Version | ['Method'] = Method | ['Name'] = file name
     * @throws Exception
     */
    public function __construct(array $Data){
        if ($Data['patchIcal'] == null){
            throw new Exception('Ical patch required');
        }
        if ($Data['proID'][0] == null || $Data['proID'][1] == null){
            throw new Exception('Pro ID required');
        }
        if ($Data['Version'] ==null){
            throw new Exception('Version is required');
        }
        if ($Data['Method'] == null){
            throw new Exception('Method is required');
        }
        if ($Data['Name'] == null){
            throw new Exception('Name is required');
        }

        $this->pathIcalSave = $Data['patchIcal'];
        $this->proID = $this->generateProID($Data['proID']);
        $this->version = $Data['Version'];
        $this->method = $Data['Method'];
        $this->name = $Data['Name'];
        $this->createFile();
        $this->writefile();
    }

    /*
     * Vital function
     */

    /**
     * @param array $Data - [0] Company Name - [1] Product Name
     * @return void
     */
    private function generateProID(array $Data) :string{
        return '-//'.$Data[0].'//NONSGML '.$Data[1].'//FR';
    }

    private function createFile() :void{
        if (!file_exists($this->pathIcalSave.'/'.$this->name.'.ics')) {
            touch($this->pathIcalSave.'/'.$this->name.'.ics');
        }else {
            unlink($this->pathIcalSave.'/'.$this->name.'.ics');
            touch($this->pathIcalSave.'/'.$this->name.'.ics');
        }
    }

    public function writefile() :void{
        if (file_exists($this->pathIcalSave.'/'.$this->name.'.ics')){
            $file = fopen($this->pathIcalSave.'/'.$this->name.'.ics','w') or die('Problem');
            /*
             * Write Parameters
             */
            fwrite($file,'BEGIN:VCALENDAR'."\n");
            fwrite($file,'VERSION:'.$this->version."\n");
            fwrite($file,'PRODID:'.$this->proID."\n");
            fwrite($file, 'CALSCALE:'.$this->calscale."\n");
            fwrite($file, 'METHOD:'.$this->method."\n");
        }
    }

    /*
     * Debug function
     */
    public function debugViewIcal() :void{
        var_dump($this);
    }
}

class EventIcal{
    private $DateStart;
    private $DateEnd;
    private $Summary;
    private $UID;
}