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


require_once 'ServiceRequest.php';
require_once 'DebugLogger.php';

/// <summary>
/// Client-side proxy for the "rustici.course.*" Hosted SCORM Engine web
/// service methods.  
/// </summary>
class ReportingService{
	
	private $_configuration = null;
	
	public function __construct($configuration) {
		$this->_configuration = $configuration;
		//echo $this->_configuration->getAppId();
	}

	public function GetReportageAuth($navpermission='NONAV', $admin = false)
	{
		$request = new ServiceRequest($this->_configuration);
		$params = array('appid' => $this->_configuration->getAppId());
		$params['navpermission'] = $navpermission;
		$params['admin'] = ($admin == true) ? 'true' : 'false';
		 
		$request->setMethodParams($params);
       	$response = $request->CallService("rustici.reporting.getReportageAuth");
       	$xml = simplexml_load_string($response);
		write_log($xml->auth);
       	return $xml->auth;
	}
	
    public function GetReportUrl($auth, $reportUrl)
    {
		$request = new ServiceRequest($this->_configuration);
		$params = array('appid' => $this->_configuration->getAppId());
		$params['auth'] = $auth;
        $params['reporturl'] = $reportUrl;	 
		$request->setMethodParams($params);
       	$response = $request->ConstructUrl("rustici.reporting.launchReport");
		//error_log($response);
		return $response;
    }
    
    function GetReportageServiceUrl(){
        return str_replace('EngineWebServices','',$this->_configuration->getScormEngineServiceUrl());
    }
    
    function GetReportageDate(){
        $request = new ServiceRequest($this->_configuration);
        
        $rServiceUrl = $this->GetReportageServiceUrl();
        $reportageUrl = $rServiceUrl.'Reportage/scormreports/api/getReportDate.php?appId='.$this->_configuration->getAppId();
        return $request->submitHttpPost($reportageUrl);
        
    }

    public function LaunchReportage($auth)
    {
		$rServiceUrl = $this->GetReportageServiceUrl();
        $reportageUrl = $rServiceUrl.'Reportage/reportage.php?appId='.$this->_configuration->getAppId();
       	return $this->GetReportUrl($auth, $reportageUrl);
    }

    public function LaunchCourseReport($auth, $courseid)
    {
		$rServiceUrl = $this->GetReportageServiceUrl();
        $reportageUrl = $rServiceUrl.'/Reportage/reportage.php?courseId='.$courseid.'&appId='.$this->_configuration->getAppId();
       	return $this->GetReportUrl($auth, $reportageUrl);
    }
	
	public function LaunchUserReport($auth, $learnerid)
    {
		$rServiceUrl = $this->GetReportageServiceUrl();
        $reportageUrl = $rServiceUrl.'/Reportage/reportage.php?learnerId='.$learnerid.'&appId='.$this->_configuration->getAppId();
       	return $this->GetReportUrl($auth, $reportageUrl);
    }
	
	public function GetWidgetUrl($auth, $widgettype, $widgetSettings = null)
    {
		$rServiceUrl = $this->GetReportageServiceUrl();
        
		switch($widgettype)
		{
			case 'allSummary':
				$reporturl = $rServiceUrl.'/Reportage/scormreports/widgets/summary/SummaryWidget.php';
				$reporturl .= '?srt=allLearnersAllCourses';
				break;
			case 'courseSummary':
				$reporturl = $rServiceUrl.'/Reportage/scormreports/widgets/summary/SummaryWidget.php';
				$reporturl .= '?srt=singleCourse';
				break;
			case 'learnerSummary':
				$reporturl = $rServiceUrl.'/Reportage/scormreports/widgets/summary/SummaryWidget.php';
				$reporturl .= '?srt=singleLearner';
				break;
			case 'learnerCourseSummary':
				$reporturl = $rServiceUrl.'Reportage/scormreports/widgets/summary/SummaryWidget.php';
				$reporturl .= '?srt=singleLearnerSingleCourse';
				break;
			case 'courseActivities':
            case 'learnerRegistration':
            case 'courseComments':
            case 'learnerComments':
			case 'courseInteractions':
			case 'learnerInteractions':
			case 'learnerActivities':
			case 'courseRegistration':
			case 'learnerRegistration':
            case 'learnerCourseActivities':
            case 'learnerTranscript':
            case 'learnerCourseInteractions':
            case 'learnerCourseComments':
            
				$reporturl = $rServiceUrl.'/Reportage/scormreports/widgets/DetailsWidget.php';
				$reporturl .= '?drt='.$widgettype;
				break;
			case 'allLearners':
				$reporturl = $rServiceUrl.'/Reportage/scormreports/widgets/ViewAllDetailsWidget.php';
				$reporturl .= '?viewall=learners';
				break;
			case 'allCourses':
				$reporturl = $rServiceUrl.'/Reportage/scormreports/widgets/ViewAllDetailsWidget.php';
				$reporturl .= '?viewall=courses';
				break;
			default:
				break;
		}
		
		$reporturl .= '&appId='.$this->_configuration->getAppId();
	
		//process the WidgetSettings
		if(isset($widgetSettings))
		{
            if ($widgetSettings->hasCourseId())
            {
                $reporturl .= '&courseId='.$widgetSettings->getCourseId();
            }
            if ($widgetSettings->hasLearnerId())
            {
                $reporturl .= '&learnerId='.$widgetSettings->getLearnerId();
            }
			
			$reporturl .= '&showTitle='.boolString($widgetSettings->getShowTitle());
			$reporturl .= '&standalone='.boolString($widgetSettings->getStandalone());
			if($widgetSettings->getIframe())
			{
				$reporturl .= '&iframe=true'; //only write this if it's true
			}
			$reporturl .= '&expand='.boolString($widgetSettings->getExpand());
			$reporturl .= '&scriptBased='.boolString($widgetSettings->getScriptBased());
			$reporturl .= '&divname='.$widgetSettings->getDivname();
			$reporturl .= '&vertical='.boolString($widgetSettings->getVertical());
			$reporturl .= '&embedded='.boolString($widgetSettings->getEmbedded());
			//$reporturl .= '&viewall='.boolString($widgetSettings->getViewAll());
			//$reporturl .= '&export='.boolString($widgetSettings->getExport());
		
		
            //Process the DateRangeSettings
            $dateRangeSettings = $widgetSettings->getDateRangeSettings();
            if(isset($dateRangeSettings))
            {
                
                switch($dateRangeSettings->getDateRangeType())
                {
                    case 'selection': //daterange
                        $reporturl .= '&dateRangeType=c';
                        $reporturl .= '&dateRangeStart='.$dateRangeSettings->getDateRangeStart();
                        $reporturl .= '&dateRangeEnd='.$dateRangeSettings->getDateRangeEnd();
                        $reporturl .= '&dateCriteria='.$dateRangeSettings->getDateCriteria();
                        break;
                    case 'mtd': //month to date
                        $reporturl .= '&dateRangeType=mtd';
                        $reporturl .= '&dateCriteria='.$dateRangeSettings->getDateCriteria();
                        break;
                    case 'ytd': //year to date
                        $reporturl .= '&dateRangeType=ytd';
                        $reporturl .= '&dateCriteria='.$dateRangeSettings->getDateCriteria();
                        break;
                    //case 'p3m': ??
                    default:
                        break;
                }
            }
            
            //Process Tags
            $tagSettings = $widgetSettings->getTagSettings();
            if(isset($tagSettings))
            {
                $tagSettings = $widgetSettings->getTagSettings();
                if ($tagSettings->hasTags('learner'))
                {
                    $reporturl .= '&learnerTags='.$tagSettings->getTagString('learner');
                    $reporturl .= '&viewLearnerTagGroups='.$tagSettings->getViewTagString('learner');
                }
                if ($tagSettings->hasTags('course'))
                {
                    $reporturl .= '&courseTags='.$tagSettings->getTagString('course');
                    $reporturl .= '&viewCourseTagGroups='.$tagSettings->getViewTagString('course');
                }
                if ($tagSettings->hasTags('registration'))
                {
                    $reporturl .= '&registrationTags='.$tagSettings->getTagString('registration');
                    $reporturl .= '&viewRegistrationTagGroups='.$tagSettings->getViewTagString('registration');
                }
                
                
            }
            
            //Process Comparisons
            $comparisonSettings = $widgetSettings->getComparisonSettings();
            if(isset($comparisonSettings))
            {
                
                
                $reporturl .= '&compDateRangeType=ad';
                $reporturl .= '&compDateCriteria=launched';
                $reporturl .= '&compLearnerTags=_all';
                $reporturl .= '&compDateRangeType=ad';
                $reporturl .= '&compDateCriteria=launched';
                $reporturl .= '&compViewLearnerTagGroups=_all';
                $reporturl .= '&compViewCourseTagGroups=_all';
                $reporturl .= '&compViewRegistrationTagGroups=_all';
                $reporturl .= '&compMatchDates=1';
            }
        }
        //error_log("ReportUrl: ".$reporturl);
       	return $this->GetReportUrl($auth, $reporturl);
    }
    
}


class WidgetSettings {
	
    private $_dateRangeSettings;
    private $_tagSettings;
    private $_comparisonSettings;
    
    private $_courseid = null;
    private $_learnerid = null;
    
	private $_showTitle = true;
	private $_vertical = false;
	private $_public = true;
	private $_standalone = true;
	private $_iframe = false;
	private $_expand = true;
	private $_scriptBased = true;
	private $_divname = '';
	private $_pubNavPermission = 'DOWNONLY';
	private $_embedded = true;
	private $_viewall = true;
	private $_export = true;
	
	public function __construct($dateRangeSettings = null, $tagSettings = null, $comparisonSettings = null) {
		$this->_dateRangeSettings = $dateRangeSettings;
        $this->_tagSettings = $tagSettings;
        $this->_comparisonSettings = $comparisonSettings;
	}
    
    public function getDateRangeSettings()
    {
        return $this->_dateRangeSettings;
    }
    public function getTagSettings()
    {
        return $this->_tagSettings;
    }
    public function getComparisonSettings()
    {
        return $this->_comparisonSettings;
    }
    
	
    public function setCourseId($val)
	{
		$this->_courseid = $val;
	}
	public function getCourseId()
	{
		return $this->_courseid;
	}
    public function hasCourseId()
    {
        return isset($this->_courseid);
    }
    
    public function setLearnerId($val)
	{
		$this->_learnerid = $val;
	}
	public function getLearnerId()
	{
		return $this->_learnerid;
	}
    public function hasLearnerId()
    {
        return isset($this->_learnerid);
    }
    
    
	public function setShowTitle($val)
	{
		$this->_showTitle = $val;
	}
	public function getShowTitle()
	{
		return $this->_showTitle;
	}
	public function setVertical($val)
	{
		$this->_vertical = $val;
	}
	public function getVertical()
	{
		return $this->_vertical;
	}
	public function setPublic($val)
	{
		$this->_public = $val;
	}
	public function getPublic()
	{
		return $this->_public;
	}
	public function setStandalone($val)
	{
		$this->_standalone = $val;
	}
	public function getStandalone()
	{
		return $this->_standalone;
	}
	public function setIframe($val)
	{
		$this->_iframe = $val;
	}
	public function getIframe()
	{
		return $this->_iframe;
	}
	public function setExpand($val)
	{
		$this->_expand = $val;
	}
	public function getExpand()
	{
		return $this->_expand;
	}
	public function setScriptBased($val)
	{
		$this->_scriptBased = $val;
	}
	public function getScriptBased()
	{
		return $this->_scriptBased;
	}
	public function setDivname($val)
	{
		$this->_divname = $val;
	}
	public function getDivname()
	{
		return $this->_divname;
	}
	public function setPubNavPermission($val)
	{
		$this->_pubNavPermission = $val;
	}
	public function getPubNavPermission()
	{
		return $this->_pubNavPermission;
	}
	public function setEmbedded($val)
	{
		$this->_embedded = $val;
	}
	public function getEmbedded()
	{
		return $this->_embedded;
	}
	public function setViewAll($val)
	{
		$this->_viewall = $val;
	}
	public function getViewAll()
	{
		return $this->_viewall;
	}
	public function setExport($val)
	{
		$this->_export = $val;
	}
	public function getExport()
	{
		return $this->_export;
	}
}

class DateRangeSettings {
	
	private $_dateRangeType = null;
	private $_dateRangeStart = null;
	private $_dateRangeEnd = null;
	private $_dateCriteria = null;
	
	
	public function __construct($dateRangeType,$dateRangeStart,$dateRangeEnd,$dateCriteria) {
		$this->_dateRangeType = $dateRangeType;
		$this->_dateRangeStart = $dateRangeStart;
		$this->_dateRangeEnd = $dateRangeEnd;
		$this->_dateCriteria = $dateCriteria;
	}
	
	public function getDateRangeType()
	{
		return $this->_dateRangeType;
	}
	public function getDateRangeStart()
	{
		return $this->_dateRangeStart;
	}
	public function getDateRangeEnd()
	{
		return $this->_dateRangeEnd;
	}
	public function getDateCriteria()
	{
		return $this->_dateCriteria;
	}
}

class TagSettings {
	
	private $_tags = array('learner' => array(),'course' => array(),'registration' => array());
    
    public function addTag($tagType,$newValue)
    {
        $this->_tags[$tagType][] = $newValue;
    }
    
    public function getTagString($tagType)
    {
        return implode(",",$this->_tags[$tagType])."|_all";
    }
    
    public function getViewTagString($tagType)
    {
        return implode(",",$this->_tags[$tagType]);
    }
    
    public function hasTags($tagType)
    {
        return (count($this->_tags[$tagType]) > 0);
    }
}

class ComparisonSettings {
	public $compMatchDates = '1';
	public $compDateRangeType = 'ad';
	public $compDateCriteria = 'launched';
	public $compLearnerTags = '_all';
	public $compViewLearnerTagGroups = '_all';
	public $compViewCourseTagGroups = '_all';
	public $compViewRegistrationTagGroups = '_all';
}


function boolString($bValue = false) {                      
// returns string
  return ($bValue ? 'true' : 'false');
}

?>
