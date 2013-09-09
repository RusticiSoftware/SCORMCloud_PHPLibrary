<?php

/* Software License Agreement (BSD License)
 * 
 * Copyright (c) 2013, Rustici Software, LLC
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
    /// Data class to hold high-level Registration Data
    /// </summary>
class LrsAccount
    {
        private $_accountKey;
        private $_accountEnabled;
		private $_accountLabel;
        private $_accountSecret;
        private $_accountAuthType;

        
        /// private int numberOfInstances;
        /// <summary>
        /// Constructor which takes an XML node as returned by the web service.
        /// </summary>
        /// <param name="regDataEl"></param>
        public function __construct($xmlDoc)
        {
            $xml = null;

            if($xmlDoc instanceof SimpleXMLElement)
            {
                $xml = $xmlDoc;
            }
            else
            {
                $xml = simplexml_load_string($xmlDoc);  
                $xml = $xml->activityProvider;  
            }
            
            $this->_accountKey = (string)$xml->accountKey;            
            $this->_accountEnabled = (boolean)$xml->accountEnabled;
	        $this->_accountLabel = (string)$xml->accountLabel;
            $this->_accountAuthType = (string)$xml->accountAuthType;
            $this->_accountSecret = (string)$xml->accountSecret;
        }

        
        /// <summary>
        /// Helper method which takes the full XmlDocument as returned from the registration listing
        /// web service and returns a List of RegistrationData objects.
        /// </summary>
        /// <param name="xmlDoc"></param>
        /// <returns></returns>
        public static function ConvertToLrsAcountList($xmlDoc)
        {
			$allResults = array();
            $xml = simplexml_load_string($xmlDoc);
			if(false === $xml)
			{
                echo 'error loading $xmlDoc';
            }
            else
            {
                foreach ($xml->activityProviderList->activityProvider as $activityProvider)
                {
                    $allResults[] = new LrsAccount($activityProvider);
                }
            }
		

            return $allResults;
        }

        
        public function getAccountKey()
        {
            return $this->_accountKey;
        }

        
        public function getAccountEnabled()
        {
            return $this->_accountEnabled;
        }

		public function getAccountLabel()
        {
            return $this->_accountLabel;
        }

        public function getAccountSecret()
        {
            return $this->_accountSecret;
        }

        public function getAccountAuthType()
        {
            return $this->_accountAuthType;
        }

        public function setAccountKey($accountKey)
        {
            $this->_accountKey = $accountKey;
        }

        
        public function setAccountEnabled($accountEnabled)
        {
            $this->_accountEnabled = $accountEnabled;
        }

        public function setAccountLabel($accountLabel)
        {
            $this->_accountLabel = $accountLabel;
        }

        public function setAccountSecret($accountSecret)
        {
            $this->_accountSecret = $accountSecret;
        }

        public function setAccountAuthType($accountAuthType)
        {
            $this->_accountAuthType = $accountAuthType;
        }
 
}

?>
