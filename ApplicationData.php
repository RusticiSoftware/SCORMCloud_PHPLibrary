<?php

/* Software License Agreement (BSD License)
 * 
 * Copyright (c) 2010-2014, Rustici Software, LLC
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


 /// <summary>
    /// Data class to hold high-level Application Data
    /// </summary>
class ApplicationData
    {
        private $_appId;
        private $_createDate;
        private $_name;
        private $_data;

        /// <summary>
        /// Constructor which takes an XML node as returned by the web service.
        /// </summary>
        /// <param name="xml"></param>
        public function __construct($xml)
        {
            $this->_appId = $xml->appId;
            $this->_createDate = $xml->createDate;
            $this->_name = $xml->name;
			$this->_data = $xml;
        }

        /// <summary>
        /// Helper method which takes the full XmlDocument as returned from the Application listing
        /// web service and returns a List of ApplicationData objects.
        /// </summary>
        /// <param name="xmlDoc"></param>
        /// <returns></returns>
        public static function ConvertToApplicationDataList($xmlDoc)
        {
			$allResults = array();
			if($xml = simplexml_load_string($xmlDoc))
			{
		            foreach ($xml->applicationlist->application as $Application)
		            {
		                $allResults[] = new ApplicationData($Application);
		            }
			}else{
				echo 'error loading $xmlDoc';
			}
		

            return $allResults;
        }

        /// <summary>
        /// Unique Identifier for this Application
        /// </summary>
        public function getAppId()
        {
            return (string) $this->_appId;
        }


        /// <summary>
        /// Create date for this Application
        /// </summary>
        public function getCreateDate()
        {
            return $this->_createDate;
        }

        /// <summary>
        /// Name for this Application
        /// </summary>
        public function getName()
        {
            return $this->_name;
        }

        public function getData()
        {
            return $this->_data;
        }
 
}

?>
