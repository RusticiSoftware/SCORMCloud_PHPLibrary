<?php

 /// <summary>
    /// Data class to hold high-level Registration Summary
    /// </summary>
class RegistrationSummary
    {
		private $_complete;
        private $_success;
        private $_totaltime;
        private $_score;

		/// <summary>
        /// Inflate RegistrationSummary info object from passed in xml element
        /// </summary>
        /// <param name="launchInfoElem"></param>
        public function __construct($xml)
        {
			$this->_complete = $xml->complete;
	        $this->_success = $xml->success;
            $this->_totalTime = $xml->totaltime;
            $this->_score = $xml->score;
        }


		/// <summary>
        /// The completion status of the Registration Summary
        /// </summary>
        public function getComplete()
        {
            return $this->_complete;
        }

        /// <summary>
        /// The success status of the Registration Summary
        /// </summary>
        public function getSuccess()
        {
			return $this->_success;
        }

        /// <summary>
        /// The total time of the Registration Summary
        /// </summary>
        public function getTotalTime()
        {
            return $this->_totalTime;
        }

        /// <summary>
        /// The score of the Registration Summary
        /// </summary>
        public function getScore()
        {
           return $this->_score;
        }

}

?>