<?php

 /// <summary>
    /// Data class to hold high-level Registration Data
    /// </summary>
class RegistrationData
    {
        private $_registrationId;
        private $_courseId;
       // private int numberOfInstances;

        /// <summary>
        /// Constructor which takes an XML node as returned by the web service.
        /// </summary>
        /// <param name="regDataEl"></param>
        public function __construct($xml)
        {
			//echo $regDataEl;
			//$xml = simplexml_load_string($regDataEl);
            $this->_registrationId = $xml["id"];
            $this->_courseId = $xml["courseid"];
            //this.numberOfInstances = Convert.ToInt32(regDataEl.Attributes["instances"].Value);
        }

        /// <summary>
        /// Helper method which takes the full XmlDocument as returned from the registration listing
        /// web service and returns a List of RegistrationData objects.
        /// </summary>
        /// <param name="xmlDoc"></param>
        /// <returns></returns>
        public static function ConvertToRegistrationDataList($xmlDoc)
        {
			//echo '$xmlDoc='.$xmlDoc;
			$allResults = array();
			if($xml = simplexml_load_string($xmlDoc))
			{
		            foreach ($xml->registrationlist->registration as $registration)
		            {
						//echo $registration['id'];
		                $allResults[] = new RegistrationData($registration);
		            }
			}else{
				echo 'error loading $xmlDoc';
			}
		

            return $allResults;
        }

        /// <summary>
        /// Unique Identifier for this registration
        /// </summary>
        public function getRegistrationId()
        {
            return $this->_registrationId;
        }

        /// <summary>
        /// Unique Identifier for this course
        /// </summary>
        public function getCourseId()
        {
            return $this->_courseId;
        }

//        /// <summary>
//        /// Number of instances of this course.  Instances are independent registrations
//        /// of the same registration ID.  It is essentially "retakes" of a course by
//        /// the same user under the same registration ID.
//        /// </summary>
//        public int NumberOfInstances
//        {
//            get { return numberOfInstances; }
//        }
 
}

?>