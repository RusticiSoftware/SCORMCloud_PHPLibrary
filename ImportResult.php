<?php

/* Software License Agreement (BSD License)
 * 
 * Copyright (c) 2010-2011, Rustici Software, LLC
 * All rights reserved.
 * 
 * Redistribution and use in source and binary forms, with or without
 * modification, are permitted provided that the following conditions are met:
 *     * Redistributions of source code must retain the above copyright
 *       notice, this list of conditions and the following disclaimer.
 *     * Redistributions in binary form must reproduce the above copyright
 *       notice, this list of conditions and the following disclaimer in the
 *       documentation and/or other materials provided with the distribution.
 *     * Neither the name of the <organization> nor the
 *       names of its contributors may be used to endorse or promote products
 *       derived from this software without specific prior written permission.
 * 
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS "AS IS" AND
 * ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE IMPLIED
 * WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE ARE
 * DISCLAIMED. IN NO EVENT SHALL Rustici Software, LLC BE LIABLE FOR ANY
 * DIRECT, INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES
 * (INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES;
 * LOSS OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND
 * ON ANY THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT
 * (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE OF THIS
 * SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
 */


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
		        $this->_title = (string) $importResultElement->title;
		        $this->_message = (string) $importResultElement->message;
		        $this->_wasSuccessful = (bool) $importResultElement["successful"];
				$pwarnings = $importResultElement->parserwarnings;
				foreach ($pwarnings as $pwarning)
				{
					foreach ($pwarning->warning as $warning)
		        	{
						$this->_parserWarnings[] = (string)$warning;
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
