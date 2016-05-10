<?php
// Exit if accessed directly
defined('ABSPATH') || exit;


if (!class_exists('WP_Event_Exporter')):

/**
 * WP Event Exporter
 *
 * Class is responsible for taking events and exporting them into an ICS file available for download
 *
 * @author Chris Smith <chris@cgsmith.net>
 * @link https://tools.ietf.org/html/rfc5545 (ICS specification)
 */
class WP_Event_Exporter
{

    /**
     * @var string File name that is downloaded - include extension
     */
    protected $fileName = 'calendar.ics';

    /**
     * @var string MIME type of the download
     */
    protected $mimeType = 'text/calendar';

    /**
     * @var array Events from WP Query
     */
    public $events;

    /**
     * @var string File for ICS
     */
    protected $icsFile = '';

    /**
     * Constructor
     * 
     * @param array $events
     */
    public function __construct($events)
    {
        $this->events = $events;
    }

    /**
     * Gets the export file. This method is called publicly and responsible for calling protected methods.
     */
    public function getExportFile()
    {
        $this->export(urlencode($this->fileName), $this->mimeType); //get the export file
    }

    /**
     * Creates the exported file
     *
     * @param string $filename Name of the file to be created
     * @param string $filetype Type of the file ('text/calendar')
     */
    protected function export($filename, $filetype)
    {
        //Buffer start
        //ob_start();

        // File header
        header('Content-Description: File Transfer');
        header('Content-Disposition: attachment; filename=' . $filename);
        header('Content-Type: ' . $filetype . '; charset=' . get_option('blog_charset'), true);
/*
        //Begin Data Transmit
        $content = 'BEGIN:VCALENDAR' . PHP_EOL .
            'VERSION:2.0' . PHP_EOL .
            'CALSCALE:GREGORIAN' . PHP_EOL ;
        
        // Echo out all of our events :) 
        foreach ($this->events as $item) {
             $item;
        }
        
        echo 'END:VCALENDAR' . PHP_EOL;
        
        //Collect output and echo
        $content = ob_get_contents();
        ob_end_clean();
        echo $content;*/
        exit;
    }
}
endif; //class doesn't exist

