# phpToIcal
* Utility : Create an Ical file with event inside FR format.
* Requirement : PHP 5.2 > | WebServer

# How To use :
* Include ical.php to your file
```
include 'ical.php';
```
* Define a new Ical as 
````
$Ical = new Ical(array(
    'patchIcal' => 'ics/',
    'proID' => array(
        0 => 'RezanCorp',
        1 => 'ReyzanProduct'
    ),
    'Version' => '1.0.0',
    'Method' => 'PUBLISH',
    'Name' => 'ReyzanCorp'
));
````
#Follow part 1 of documentation for more information

* Crate an Event as an Array
```
$Event = array(
    'Begin' =>  '2023-01-19',
    'End' => '2023-01-20',
    'Summary' => '01 | Event 1',
    'UID' => 'Event_1@reyhome.com'
);
```
#Follow part 2 of documentation for more information

* Add event in the Ical event Array
```
$Ical->addEvent($Event);
```

* Write events in ical file
```
$Ical->writeEvent();
```

------
# Documentation

* Part 1 :
```
patchIcal => Path to the icals storage folder
proID => 
        [0] => Company Name
        [1] => Product Name
Version => Version of your file
Method => Method for the ical export = PUBLISH
Name => Name of the file
```

* Part 2 : 
```
Begin => Date of the beginning of the event as ('YYYY-MM-DD)
End => Date of the ending of the event as ('YYYY-MM-DD')
Summary => Title of the event 
UID => UID unique of the event to identify it
```

* Function of ical Class
```
PUBLIC
* Construct : Create a new Ical Object : Vital
* addEvent : Add event to the array list of events ical
* writeEvent : Write all event in the ICS file

Private
* generateProID : Generate ProID with your informations : Vital
* createFile : Generate a new file YOUR_NAME.ics : Vital
* writefile : Write vital part of the ical file : Vital

Debug
* debugViewIcal : var_dump of the ical object
```

* Function of EventIcal class 
````
PUBLIC 
* Constrcut : Create an new Event object : Vital
* getDateStart : Get Date of beginning of the event
* getDateEnd : Get Date of ending of the event
* getSummary : Get the summary of the event
* getUID : Get UID of the event

PRIVATE 
* doEventIcal : Transorm vital property for the ical file : Vital
````

* Awaited Result 
```
BEGIN:VCALENDAR
VERSION:1.0.0
PRODID:-//RezanCorp//NONSGML ReyzanProduct//FR
CALSCALE:GREGORIAN
METHOD:PUBLISH
BEGIN:VEVENT
DTSTART;VALUE=DATE:20230119
DTEND;VALUE=DATE:20230120
SUMMARY:01 | Event 1
UID:Event_1@reyhome.com
END:VEVENT
END:VCALENDAR
```

* Errors code
```
* 600 => PathIcalException => Path to ical is not define in array data of ical object.
* 601 => ProIDException => ProID is not define in array data of ical object.
* 602 => VersionException => Version is not define in array data of ical object.
* 603 => MethodException => Method is not define in array data of ical object.
* 604 => NameException => Name is not define in array data of ical object.

* 605 => BeginException => Beginning date of event is not define in array event.
* 606 => EndException => Ending date of event is not define in array event.
* 607 => SummaryException => Summary of event is not define in array event.
* 608 => UIDException => UID of event is not define in array event.
```