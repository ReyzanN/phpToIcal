<?php

class Ical
{
    private string $name;
    private string $pathIcalSave;
    private string $proID;
    private string $version;
    private string $calscale = 'GREGORIAN';
    private string $method;
    private array $Event = array();

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
     * @usage Generate proID
     * @param array $Data - [0] Company Name - [1] Product Name
     * @return void
     */
    private function generateProID(array $Data) :string{
        return '-//'.$Data[0].'//NONSGML '.$Data[1].'//FR';
    }

    /**
     * @usage Create Ical file
     * @return void
     */
    private function createFile() :void{
        if (!file_exists($this->pathIcalSave.'/'.$this->name.'.ics')) {
            touch($this->pathIcalSave.'/'.$this->name.'.ics');
        }else {
            unlink($this->pathIcalSave.'/'.$this->name.'.ics');
            touch($this->pathIcalSave.'/'.$this->name.'.ics');
        }
    }

    /**
     * @usage Write vital part of ical file
     * @return void
     */
    private function writefile() :void{
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

    /**
     * @usage Add Event for ical
     * @param array $Data
     * @return bool
     */
    public function addEvent(array $Data) :bool{
        $this->Event[] = new EventIcal($Data);
        return false;
    }

    /**
     * @usage Write Events in the ics file
     * @return void
     */
    public function writeEvent(){
        if (file_exists($this->pathIcalSave.'/'.$this->name.'.ics')){
            $file = fopen($this->pathIcalSave.'/'.$this->name.'.ics','a');
            foreach ($this->Event as $Event) {
                fwrite($file, "BEGIN:VEVENT\n");
                fwrite($file,$Event->getDateStart()."\n");
                fwrite($file, $Event->getDateEnd()."\n");
                fwrite($file, $Event->getSummary()."\n");
                fwrite($file, $Event->getUID()."\n");
                fwrite($file, "END:VEVENT\n");
            }
            fwrite($file,"END:VCALENDAR");
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
    private string $DateStart;
    private string $DateEnd;
    private string $Summary;
    private string $UID;

    /**
     * @param $Data
     * @throws Exception
     */
    public function __construct($Data){
        $this->DateStart = $Data['Begin'];
        $this->DateEnd = $Data['End'];
        $this->Summary = $Data['Summary'];
        $this->UID = $Data['UID'];
        $this->doEventIcal();
    }

    /**
     * @usage Transform property of class as item for ics file
     * @return void
     * @throws Exception
     */
    private function doEventIcal():void{
        $Begin = new DateTime($this->DateStart);
        $End = new DateTime($this->DateEnd);
        $this->DateStart = 'DTSTART;VALUE=DATE:'.$Begin->format('Ymd');
        $this->DateEnd = 'DTEND;VALUE=DATE:'.$End->format('Ymd');
        $this->Summary = 'SUMMARY:'.$this->Summary;
        $this->UID = 'UID:'.$this->UID;
    }

    /*
     * Get - Set
     */

    /**
     * @return string - Date Begin as string
     */
    public function getDateStart():string {
        return $this->DateStart;
    }

    /**
     * @return string - Date End as string
     */
    public function getDateEnd():string {
        return $this->DateEnd;
    }

    /**
     * @return string - Summary as string
     */
    public function getSummary():string {
        return $this->Summary;
    }

    /**
     * @return string - UID as string
     */
    public function getUID():string {
        return $this->UID;
    }
}