<?php

require_once 'ServiceRequest.php';

/// <summary>
/// Client-side proxy for the "rustici.course.*" Hosted SCORM Engine web
/// service methods.  
/// </summary>
class TaggingService{
	
	private $_configuration = null;
	
	public function __construct($configuration) {
		$this->_configuration = $configuration;
		//echo $this->_configuration->getAppId();
	}
	
	
    /// <summary>
    /// Add a tag to the course.
    /// </summary>
    /// <param name="courseId">Unique Identifier for this course.</param>
    /// <param name="tag">comma-delimited list of tags</param>
    /// <returns>success</returns>
    public function AddCourseTag($courseId, $tag)
    {
        $request = new ServiceRequest($this->_configuration);
        $params = array('courseid' => $courseId,
                        'tag' => $tag);
		$request->setMethodParams($params);
        $response = $request->CallService("rustici.tagging.addCourseTag");
        return $response;
    }
    
    public function RemoveCourseTag($courseId, $tag)
    {
        $request = new ServiceRequest($this->_configuration);
        $params = array('courseid' => $courseId,
                        'tag' => $tag);
		$request->setMethodParams($params);
        $response = $request->CallService("rustici.tagging.removeCourseTag");
        return $response;
    }
    
    public function AddLearnerTag($learnerId, $tag)
    {
        $request = new ServiceRequest($this->_configuration);
        $params = array('learnerid' => $learnerId,
                        'tag' => $tag);
		$request->setMethodParams($params);
        $response = $request->CallService("rustici.tagging.addLearnerTag");
        return $response;
    }
    
    public function RemoveLearnerTag($learnerId, $tag)
    {
        $request = new ServiceRequest($this->_configuration);
        $params = array('learnerid' => $learnerId,
                        'tag' => $tag);
		$request->setMethodParams($params);
        $response = $request->CallService("rustici.tagging.removeLearnerTag");
        return $response;
    }
}
    
?>