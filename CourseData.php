<?php

class CourseData{
	private $_courseId;
    private $_numberOfVersions;
    private $_numberOfRegistrations;
    private $_title;

	/// <summary>
    /// Purpose of this class is to map the return xml from the course listing
    /// web service into an object.  This is the main constructor.
    /// </summary>
    /// <param name="courseDataElement"></param>
    public function __construct($courseDataElement)
    {
		//$xml = simplexml_load_string($courseDataElement);
		//if (false === $xml) {
            //throw new ScormEngine_XmlParseException('Could not parse XML.', $courseDataElement);
        //}
		if(isset($courseDataElement))
		{
		        $this->_courseId = (string) $courseDataElement["id"];
		        $this->_numberOfVersions = (integer) $courseDataElement["versions"];
		        $this->_numberOfRegistrations = (integer) $courseDataElement["registrations"];
		        $this->_title = (string) $courseDataElement["title"];
		}
    }

	/// <summary>
    /// Helper method which takes the full XmlDocument as returned from the course listing
    /// web service and returns a List of CourseData objects.
    /// </summary>
    /// <param name="xmlDoc"></param>
    /// <returns></returns>
    public static function ConvertToCourseDataList($xmlDoc)
    {
		$xml = simplexml_load_string($xmlDoc);
		if (false === $xml) {
            //throw new ScormEngine_XmlParseException('Could not parse XML.', $courseDataElement);
        }
		
		$allResults = array();
        
        foreach ($xml->courselist->course as $course)
        {
            $allResults[] = new CourseData($course);
        }

        return $allResults;
    }

	/// <summary>
    /// Course Identifier as specified at import-time
    /// </summary>
    public function getCourseId()
    {
        return $this->_courseId;
    }

    /// <summary>
    /// Count of the number of versions for this course/package
    /// </summary>
    public function getNumberOfVersions()
    {
        return $this->_numberOfVersions;
    }

    /// <summary>
    /// Count of the number of existing registrations there are for this
    /// course -- the number of instances that a user has taken this course.
    /// </summary>
    public function getNumberOfRegistrations()
    {
        return $this->_numberOfRegistrations;
    }

    /// <summary>
    /// The title of this course
    /// </summary>
    public function getTitle()
    {
        return $this->_title;
    }
}

?>