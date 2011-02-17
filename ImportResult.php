<?php

class ImportResult{
	
	private $_title = "";
	private $_wasSuccessful = false;
	private $_message = "";
	private $_parserWarnings = array();
	
	/// <summary>
    /// Purpose of this class is to map the return xml from the import
    /// web service into an object.  This is the main constructor.
    /// </summary>
    /// <param name="irXml">importresult Element</param>
    public function __construct($importResultElement)
    {
		if(isset($importResultElement))
		{
		        $this->_title = (string) $importResultElement->title->InnerText;
		        $this->_message = (string) $importResultElement->message->InnerText;
		        $this->_wasSuccessful = (bool) $importResultElement["successful"];
				$pwarnings = $importResultElement->parserwarnings;
				foreach ($pwarnings as $pwarning)
				{
					foreach ($pwarning->warning as $warning)
		        	{
						$this->_parserWarnings[] = $warning->InnerText;
					}
				}

		}
    }

    /// <summary>
    /// Helper method that takes the entire web service response document and
    /// returns a List of one or more ImportResults.
    /// </summary>
    /// <param name="xmlDoc"></param>
    /// <returns></returns>
    public static function ConvertToImportResults($xmlDoc)
    {
        $allResults = array();
		
		$xml = simplexml_load_string($xmlDoc);
		
        $importResults = $xml->importresult;
        foreach ($importResults as $result)
        {
            $allResults[] = new ImportResult($result);
        }

        return $allResults;
    }

    /// <summary>
    /// The Title of the course that was imported as derived from the manifest
    /// </summary>
    public function getTitle()
    {
        return $this->_title;
    }

    /// <summary>
    /// Indicates whether or not the import had any errors
    /// </summary>
    public function getWasSuccessful()
    {
        return $this->_wasSuccessful;
    }

    /// <summary>
    /// More information regarding the success or failure of the import.
    /// </summary>
    public function getMessage()
    {
        return $this->_message;
    }

    /// <summary>
    /// Warnings issued during import process related to the structure of the manifest.
    /// </summary>
    public function getParserWarnings()
    {
        return $this->_parserWarnings;
    }
	
}

?>