<?php

/*
 * Ical Exception
 */

include 'Exceptions/Ical/PathIcalException.php';
include 'Exceptions/Ical/ProIDException.php';
include 'Exceptions/Ical/VersionException.php';
include 'Exceptions/Ical/MethodException.php';
include 'Exceptions/Ical/NameException.php';

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
        if (!array_key_exists('patchIcal',$Data)){
            throw new PathIcalException();
        }
        if (!array_key_exists('proID',$Data)){
            throw new ProIDException();
        }
        if (!array_key_exists('Version',$Data)){
            throw new VersionException();
        }
        if (!array_key_exists('Method', $Data)){
            throw new MethodException();
        }
        if (!array_key_exists('Name',$Data)){
            throw new NameException();
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

/*
 * Event Exception
 */
include 'Exceptions/Event/BeginException.php';
include 'Exceptions/Event/EndException.php';
include 'Exceptions/Event/SummaryException.php';
include 'Exceptions/Event/UIDException.php';


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
        if (!array_key_exists('Begin',$Data)){
            throw new BeginException();
        }
        if (!array_key_exists('End',$Data)){
            throw new EndException();
        }
        if (!array_key_exists('Summary',$Data)){
            throw new SummaryException();
        }
        if (!array_key_exists('UID',$Data)){
            throw new UIDException();
        }
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