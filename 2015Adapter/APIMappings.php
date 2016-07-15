<?php
use RusticiSoftware\ScormContentPlayer\api\model as model;
use RusticiSoftware\Engine\Client as client;

/**
 * Create by: jason.wisener
 * Date: 6/10/16
 * Time: 8:47 AM
 */
class APIMappings
{
    public static $attributeApiToLwsNameMap = null;
    public static $attributeLswToApiNameMap = null;
    public static $attributeApiToLwsValueMap = null;
    public static $attributeLwsToApiValueMap = null;
    public static $attributeApiDebugNames = null;
    public static $attributeLwsDebugNames = null;
    public static $apiToLwsLearningStandardTextMap = null;
    public static $lwsLearningStandardValueMap = null;


    const API_DIRECT_VALUE_TO_VALUE = "<-->";
    const API_PLAYER_ALLOW_COMPLETE_STATUS_CHANGE = "PlayerAllowCompleteStatusChange";
    const API_PLAYER_ALWAYS_FLOW_TO_FIRST_SCO = "PlayerAlwaysFlowToFirstSco";
    const API_PLAYER_APPLY_ROLLUP_STATUS_TO_SUCCESS = "PlayerApplyRollupStatusToSuccess";
    const API_PLAYER_COMM_COMMIT_FREQUENCY = "PlayerCommCommitFrequency";
    const API_PLAYER_COMM_MAX_FAILED_SUBMISSIONS = "PlayerCommMaxFailedSubmissions";
    const API_PLAYER_COURSE_STRUCTURE_STARTS_OPEN = "PlayerCourseStructureStartsOpen";
    const API_PLAYER_COURSE_STRUCTURE_WIDTH = "PlayerCourseStructureWidth";
    const API_PLAYER_DEBUG_CONTROL_AUDIT = "PlayerDebugControlAudit";
    const API_PLAYER_DEBUG_CONTROL_DETAILED = "PlayerDebugControlDetailed";
    const API_PLAYER_DEBUG_INCLUDE_TIMESTAMPS = "PlayerDebugIncludeTimestamps";
    const API_PLAYER_DEBUG_LOOK_AHEAD_AUDIT = "PlayerDebugLookAheadAudit";
    const API_PLAYER_DEBUG_LOOK_AHEAD_DETAILED = "PlayerDebugLookAheadDetailed";
    const API_PLAYER_DEBUG_RTE_AUDIT = "PlayerDebugRteAudit";
    const API_PLAYER_DEBUG_RTE_DETAILED = "PlayerDebugRteDetailed";
    const API_PLAYER_DEBUG_SEQUENCING_AUDIT = "PlayerDebugSequencingAudit";
    const API_PLAYER_DEBUG_SEQUENCING_DETAILED = "PlayerDebugSequencingDetailed";
    const API_PLAYER_DESIRED_FULL_SCREEN = "PlayerDesiredFullScreen";
    const API_PLAYER_DESIRED_HEIGHT = "PlayerDesiredHeight";
    const API_PLAYER_DESIRED_WIDTH = "PlayerDesiredWidth";
    const API_PLAYER_ENABLE_CHOICE_NAV = "PlayerEnableChoiceNav";
    const API_PLAYER_ENABLE_FLOW_NAV = "PlayerEnableFlowNav";
    const API_PLAYER_FINISH_CAUSES_IMMEDIATE_COMMIT = "PlayerFinishCausesImmediateCommit";
    const API_PLAYER_FIRST_SCO_IS_PRETEST = "PlayerFirstScoIsPretest";
    const API_PLAYER_INTERNET_EXPLORER_COMPATIBILITY_MODE = "PlayerInternetExplorerCompatibilityMode";
    const API_PLAYER_INVALID_MENU_ITEM_ACTION = "PlayerInvalidMenuItemAction";
    const API_PLAYER_LAUNCH_COMPLETED_REGS_AS_NO_CREDIT = "PlayerLaunchCompletedRegsAsNoCredit";
    const API_PLAYER_LOGOUT_CAUSES_API_PLAYER_EXIT = "PlayerLogoutCausesPlayerExit";
    const API_PLAYER_FINAL_SCO_COURSE_NOT_SATISFIED_LOGOUT_EXIT_ACTION = "PlayerFinalScoCourseNotSatisfiedLogoutExitAction";
    const API_PLAYER_FINAL_SCO_COURSE_SATISFIED_LOGOUT_EXIT_ACTION = "PlayerFinalScoCourseSatisfiedLogoutExitAction";
    const API_PLAYER_INTERMEDIATE_SCO_NOT_SATISFIED_LOGOUT_EXIT_ACTION = "PlayerIntermediateScoNotSatisfiedLogoutExitAction";
    const API_PLAYER_INTERMEDIATE_SCO_SATISFIED_LOGOUT_EXIT_ACTION = "PlayerIntermediateScoSatisfiedLogoutExitAction";
    const API_PLAYER_LOOKAHEAD_SEQUENCER_MODE = "PlayerLookaheadSequencerMode";
    const API_PLAYER_FINAL_SCO_COURSE_NOT_SATISFIED_NORMAL_EXIT_ACTION = "PlayerFinalScoCourseNotSatisfiedNormalExitAction";
    const API_PLAYER_FINAL_SCO_COURSE_SATISFIED_NORMAL_EXIT_ACTION = "PlayerFinalScoCourseSatisfiedNormalExitAction";
    const API_PLAYER_INTERMEDIATE_SCO_NOT_SATISFIED_NORMAL_EXIT_ACTION = "PlayerIntermediateScoNotSatisfiedNormalExitAction";
    const API_PLAYER_INTERMEDIATE_SCO_SATISFIED_NORMAL_EXIT_ACTION = "PlayerIntermediateScoSatisfiedNormalExitAction";
    const API_PLAYER_SCORE_ROLLUP_MODE_NUMBER_OF_SCORING_OBJECTS = "PlayerScoreRollupModeNumberOfScoringObjects";
    const API_PLAYER_LAUNCH_TYPE = "PlayerLaunchType";
    const API_PLAYER_PREVENT_RIGHT_CLICK = "PlayerPreventRightClick";
    const API_PLAYER_PREVENT_WINDOW_RESIZE = "PlayerPreventWindowResize";
    const API_WHEN_TO_RESTART_REGISTRATION = "WhenToRestartRegistration";
    const API_PLAYER_REQUIRED_FULL_SCREEN = "PlayerRequiredFullScreen";
    const API_PLAYER_REQUIRED_HEIGHT = "PlayerRequiredHeight";
    const API_PLAYER_REQUIRED_WIDTH = "PlayerRequiredWidth";
    const API_PLAYER_RESET_RUN_TIME_DATA = "PlayerResetRunTimeData";
    const API_PLAYER_ROLLUP_EMPTY_SET_TO_UNKNOWN = "PlayerRollupEmptySetToUnknown";
    const API_PLAYER_SCALE_RAW_SCORE = "PlayerScaleRawScore";
    const API_PLAYER_SCO_LAUNCH_TYPE = "PlayerScoLaunchType";
    const API_PLAYER_SCORE_OVERRIDES_STATUS = "PlayerScoreOverridesStatus";
    const API_PLAYER_SCORE_ROLLUP_MODE_VALUE = "PlayerScoreRollupModeValue";
    const API_PLAYER_SHOW_CLOSE_ITEM = "PlayerShowCloseItem";
    const API_PLAYER_SHOW_COURSE_STRUCTURE = "PlayerShowCourseStructure";
    const API_PLAYER_SHOW_FINISH_BUTTON = "PlayerShowFinishButton";
    const API_PLAYER_SHOW_HELP = "PlayerShowHelp";
    const API_PLAYER_SHOW_NAV_BAR = "PlayerShowNavBar";
    const API_PLAYER_SHOW_PROGRESS_BAR = "PlayerShowProgressBar";
    const API_PLAYER_SHOW_TITLE_BAR = "PlayerShowTitleBar";
    const API_PLAYER_STATUS_DISPLAY_PREFERENCE = "PlayerStatusDisplayPreference";
    const API_PLAYER_STATUS_ROLLUP_MODE_VALUE = "PlayerStatusRollupModeValue";
    const API_PLAYER_FINAL_SCO_COURSE_NOT_SATISFIED_SUSPEND_EXIT_ACTION = "PlayerFinalScoCourseNotSatisfiedSuspendExitAction";
    const API_PLAYER_FINAL_SCO_COURSE_SATISFIED_SUSPEND_EXIT_ACTION = "PlayerFinalScoCourseSatisfiedSuspendExitAction";
    const API_PLAYER_INTERMEDIATE_SCO_NOT_SATISFIED_SUSPEND_EXIT_ACTION = "PlayerIntermediateScoNotSatisfiedSuspendExitAction";
    const API_PLAYER_INTERMEDIATE_SCO_SATISFIED_SUSPEND_EXIT_ACTION = "PlayerIntermediateScoSatisfiedSuspendExitAction";
    const API_PLAYER_STATUS_ROLLUP_MODE_THRESHOLD_SCORE = "PlayerStatusRollupModeThresholdScore";
    const API_PLAYER_TIME_LIMIT = "PlayerTimeLimit";
    const API_PLAYER_FINAL_SCO_COURSE_NOT_SATISFIED_TIMEOUT_EXIT_ACTION = "PlayerFinalScoCourseNotSatisfiedTimeoutExitAction";
    const API_PLAYER_FINAL_SCO_COURSE_SATISFIED_TIMEOUT_EXIT_ACTION = "PlayerFinalScoCourseSatisfiedTimeoutExitAction";
    const API_PLAYER_INTERMEDIATE_SCO_NOT_SATISFIED_TIMEOUT_EXIT_ACTION = "PlayerIntermediateScoNotSatisfiedTimeoutExitAction";
    const API_PLAYER_INTERMEDIATE_SCO_SATISFIED_TIMEOUT_EXIT_ACTION = "PlayerIntermediateScoSatisfiedTimeoutExitAction";
    const API_PLAYER_VALIDATE_INTERACTION_RESPONSES = "PlayerValidateInteractionResponses";
    const API_PLAYER_WRAP_SCO_WINDOW_WITH_API = "PlayerWrapScoWindowWithApi";
    const API_PLAYER_OFFLINE_SYNCH_MODE = "PlayerOfflineSynchMode";
    const API_PLAYER_DEBUG_SEQUENCING_SIMPLE = "PlayerDebugSequencingSimple";

    const LWS_ALLOW_COMPLETE_STATUS_CHANGE = "allowCompleteStatusChange";
    const LWS_ALWAYS_FLOW_TO_FIRST_SCO = "alwaysFlowToFirstSco";
    const LWS_APPLY_ROLLUP_STATUS_TO_SUCCESS = "applyRollupStatusToSuccess";
    const LWS_COMM_COMMIT_FREQUENCY = "commCommitFrequency";
    const LWS_COMM_MAX_FAILED_SUBMISSIONS = "commMaxFailedSubmissions";
    const LWS_COURSE_STRUCTURE_STARTS_OPEN = "courseStructureStartsOpen";
    const LWS_COURSE_STRUCTURE_WIDTH = "courseStructureWidth";
    const LWS_DEBUG_INCLUDE_TIMESTAMPS = "debugIncludeTimestamps";
    const LWS_DESIRED_FULL_SCREEN = "desiredFullScreen";
    const LWS_DESIRED_HEIGHT = "desiredHeight";
    const LWS_DESIRED_WIDTH = "desiredWidth";
    const LWS_ENABLE_CHOICE_NAVIGATION = "enableChoiceNavigation";
    const LWS_ENABLE_PREV_NEXT = "enablePrevNext";
    const LWS_FINISH_CAUSES_IMMEDIATE_COMMIT = "finishCausesImmediateCommit";
    const LWS_FIRST_SCO_IS_PRETEST = "firstScoIsPretest";
    const LWS_IE_COMPATIBILITY_MODE = "ieCompatibilityMode";
    const LWS_INVALID_MENU_ITEM_ACTION = "invalidMenuItemAction";
    const LWS_LAUNCH_COMPLETED_REGS_AS_NO_CREDIT = "launchCompletedRegsAsNoCredit";
    const LWS_LOGOUT_CAUSES_API_PLAYER_EXIT = "logoutCausesPlayerExit";
    const LWS_LOGOUT_FINAL_NOT_SAT_ACTION = "logoutFinalNotSatAction";
    const LWS_LOGOUT_FINAL_SAT_ACTION = "logoutFinalSatAction";
    const LWS_LOGOUT_INT_NOT_SAT_ACTION = "logoutIntNotSatAction";
    const LWS_LOGOUT_INT_SAT_ACTION = "logoutIntSatAction";
    const LWS_LOOKAHEAD_SEQUENCER_MODE = "lookaheadSequencerMode";
    const LWS_NORMAL_FINAL_NOT_SAT_ACTION = "normalFinalNotSatAction";
    const LWS_NORMAL_FINAL_SAT_ACTION = "normalFinalSatAction";
    const LWS_NORMAL_INT_NOT_SAT_ACTION = "normalIntNotSatAction";
    const LWS_NORMAL_INT_SAT_ACTION = "normalIntSatAction";
    const LWS_NUMBER_OF_SCORING_OBJECTS = "numberOfScoringObjects";
    const LWS_API_PLAYER_LAUNCH_TYPE1 = "playerLaunchType";
    const LWS_PREVENT_RIGHT_CLICK = "preventRightClick";
    const LWS_PREVENT_WINDOW_RESIZE = "preventWindowResize";
    const LWS_REGISTRATION_INSTANCING_OPTION = "registrationInstancingOption";
    const LWS_REQUIRED_FULL_SCREEN = "requiredFullScreen";
    const LWS_REQUIRED_HEIGHT = "requiredHeight";
    const LWS_REQUIRED_WIDTH = "requiredWidth";
    const LWS_RESET_RUN_TIME_DATA_TIMING = "resetRunTimeDataTiming";
    const LWS_ROLLUP_EMPTY_SET_TO_UNKNOWN = "rollupEmptySetToUnknown";
    const LWS_RSOP_SYNCH_MODE = "rsopSynchMode";
    const LWS_SCALE_RAW_SCORE = "scaleRawScore";
    const LWS_SCO_LAUNCH_TYPE = "scoLaunchType";
    const LWS_SCORE_OVERRIDES_STATUS = "scoreOverridesStatus";
    const LWS_SCORE_ROLLUP_MODE = "scoreRollupMode";
    const LWS_SHOW_CLOSE_ITEM = "showCloseItem";
    const LWS_SHOW_COURSE_STRUCTURE = "showCourseStructure";
    const LWS_SHOW_FINISH_BUTTON = "showFinishButton";
    const LWS_SHOW_HELP = "showHelp";
    const LWS_SHOW_NAV_BAR = "showNavBar";
    const LWS_SHOW_PROGRESS_BAR = "showProgressBar";
    const LWS_SHOW_TITLE_BAR = "showTitleBar";
    const LWS_STATUS_DISPLAY = "statusDisplay";
    const LWS_STATUS_ROLLUP_MODE = "statusRollupMode";
    const LWS_SUSPEND_FINAL_NOT_SAT_ACTION = "suspendFinalNotSatAction";
    const LWS_SUSPEND_FINAL_SAT_ACTION = "suspendFinalSatAction";
    const LWS_SUSPEND_INT_NOT_SAT_ACTION = "suspendIntNotSatAction";
    const LWS_SUSPEND_INT_SAT_ACTION = "suspendIntSatAction";
    const LWS_THRESHOLD_SCORE = "thresholdScore";
    const LWS_TIME_LIMIT = "timeLimit";
    const LWS_TIMEOUT_FINAL_NOT_SAT_ACTION = "timeoutFinalNotSatAction";
    const LWS_TIMEOUT_FINAL_SAT_ACTION = "timeoutFinalSatAction";
    const LWS_TIMEOUT_INT_NOT_SAT_ACTION = "timeoutIntNotSatAction";
    const LWS_TIMEOUT_INT_SAT_ACTION = "timeoutIntSatAction";
    const LWS_VALIDATE_INTERACTION_RESPONSES = "validateInteractionResponses";
    const LWS_WRAP_SCO_WINDOW_WITH_API = "wrapScoWindowWithApi";

    const LWS_DEBUG_CONTROL = "debugControl";
    const LWS_DEBUG_LOOK_AHEAD = "debugLookAhead";
    const LWS_DEBUG_RUNTIME = "debugRuntime";
    const LWS_DEBUG_SEQUENCING = "debugSequencing";

    const LWS_AUDIT = "audit";

    const API_YES = "YES";
    const API_NO = 'NO';

    const LWS_DETAILED = "detailed";

    const API_TRUE = "True";

    const API_FALSE = 'False';

    const LWS_TRUE = 'true';
    const LWS_FALSE = 'false';

    const LWS_OFF = "off";



    public static function getAttributeApiToLwsNameMap()
    {
        if (is_null(self::$attributeApiToLwsNameMap)) {
            self::BuildApiToLwsAttributeNameMap();
        }
        return self::$attributeApiToLwsNameMap;
    }
    public static function getApiToLwsLearningStandardTextMap()
    {
        if (is_null(self::$apiToLwsLearningStandardTextMap )) {
            self::BuildApiToLwsLearningStandardTextMap ();
        }
        return self::$apiToLwsLearningStandardTextMap ;
    }
    public static function getLwsLearningStandardTextFromApiValue($apiLearningStandard)
    {
        return self::getApiToLwsLearningStandardTextMap()[(string)$apiLearningStandard];
    }

    public static function getAttributeLwsToApiNameMap()
    {
        if (is_null(self::$attributeLswToApiNameMap)) {
            self::BuildLwsToApiAttributeNameMap();
        }
        return self::$attributeLswToApiNameMap;
    }

    public static function getAttributeApiToLwsValueMap()
    {
        if (is_null(self::$attributeApiToLwsValueMap)) {
            self::BuildApiToLwsAttributeValueMap();
        }
        return self::$attributeApiToLwsValueMap;
    }
    
    public static function getAttributeLwsToApiValueMap()
    {
        if (is_null(self::$attributeLwsToApiValueMap)) {
            self::BuildLwsToApiAttributeValueMap();
        }
        return self::$attributeLwsToApiValueMap;
    }
    
    public static function getAttributeApiDebugNames()
    {
        if (is_null(self::$attributeApiDebugNames)) {
            self::BuildApiDebugNames();
        }
        return self::$attributeApiDebugNames;
    }

    public static function getAttributeLwsDebugNames()
    {
        if (is_null(self::$attributeLwsDebugNames)) {
            self::BuildLwsDebugNames();
        }
        return self::$attributeLwsDebugNames;

    }

    public static function getLwsLearningStandards(){
        if(is_null(self::$lwsLearningStandardValueMap)){
            self::BuildLwsLearningStandards();
        }
        return self::$lwsLearningStandardValueMap;
    }

    public static function MapDebugApiValuesToLws($apiDebugAttributes)
    {
        self::MapDebugApiValueToLws($apiDebugAttributes,
            APIMappings::API_PLAYER_DEBUG_CONTROL_AUDIT,
            APIMappings::API_PLAYER_DEBUG_CONTROL_DETAILED,
            $lwsAttributes);

        self::MapDebugApiValueToLws($apiDebugAttributes,
            APIMappings::API_PLAYER_DEBUG_LOOK_AHEAD_AUDIT,
            APIMappings::API_PLAYER_DEBUG_LOOK_AHEAD_DETAILED,
            $lwsAttributes);

        self::MapDebugApiValueToLws($apiDebugAttributes,
            APIMappings::API_PLAYER_DEBUG_SEQUENCING_AUDIT,
            APIMappings::API_PLAYER_DEBUG_SEQUENCING_DETAILED,
            $lwsAttributes);

        self::MapDebugApiValueToLws($apiDebugAttributes,
            APIMappings::API_PLAYER_DEBUG_RTE_AUDIT,
            APIMappings::API_PLAYER_DEBUG_RTE_DETAILED,
            $lwsAttributes);

        return $lwsAttributes;
    }

    public static function MapDebugLwsValuesToApi($lwsDebugAttributeName, $lwsAttributeValue)
    {
        $apiMappedValues = self::MapDebugLwsValueToApi($lwsDebugAttributeName,
                                                       $lwsAttributeValue,
                                                       self::LWS_DEBUG_CONTROL,
                                                       self::API_PLAYER_DEBUG_CONTROL_AUDIT,
                                                       self::API_PLAYER_DEBUG_CONTROL_DETAILED);


        $apiMappedValues = array_merge($apiMappedValues, self::MapDebugLwsValueToApi($lwsDebugAttributeName,
            $lwsAttributeValue,
            self::LWS_DEBUG_LOOK_AHEAD,
            self::API_PLAYER_DEBUG_LOOK_AHEAD_AUDIT,
            self::API_PLAYER_DEBUG_LOOK_AHEAD_DETAILED));

        $apiMappedValues = array_merge($apiMappedValues, self::MapDebugLwsValueToApi($lwsDebugAttributeName,
            $lwsAttributeValue,
            self::LWS_DEBUG_SEQUENCING,
            self::API_PLAYER_DEBUG_SEQUENCING_AUDIT,
            self::API_PLAYER_DEBUG_SEQUENCING_DETAILED));

        $apiMappedValues = array_merge($apiMappedValues, self::MapDebugLwsValueToApi($lwsDebugAttributeName,
            $lwsAttributeValue,
            self::LWS_DEBUG_RUNTIME,
            self::API_PLAYER_DEBUG_RTE_AUDIT,
            self::API_PLAYER_DEBUG_RTE_DETAILED));


        return $apiMappedValues;
    }

    public static function IsAnApiDebugAttribute($apiAttributeName)
    {
        self::getAttributeApiDebugNames();
        return key_exists($apiAttributeName, self::$attributeApiDebugNames);
    }

    public static function IsAnLwsDebugAttribute($lwsAttributeName)
    {
        self::getAttributeLwsDebugNames();
        return key_exists($lwsAttributeName, self::$attributeLwsDebugNames);
    }

    public static function MapApiValueToLwsValue($apiAttributeName, $apiAttributeValue)
    {
        //echo($apiAttributeName . " : " . $apiAttributeValue . "<br/>");
        //first check to ensure we have mapping
        if (key_exists($apiAttributeName, self::$attributeApiToLwsValueMap)) {
            //is this just a direct value to value (for example an integer value for limit or something).
            if (self::$attributeApiToLwsValueMap[$apiAttributeName] === self::API_DIRECT_VALUE_TO_VALUE) {
                if($apiAttributeName === self::API_PLAYER_INTERNET_EXPLORER_COMPATIBILITY_MODE)
                    return strtolower($apiAttributeValue);
                return $apiAttributeValue;
            }
            return self::$attributeApiToLwsValueMap[$apiAttributeName][$apiAttributeValue];
        }
        throw new Exception("Unknown value mapping api_attr_name: " . $apiAttributeName . " api_attr_value: " .  $apiAttributeValue);
    }

    public static function MapLwsValueToApiValue($lwsAttributeName, $lwsAttributeValue)
    {
        //first check to ensure we have mapping
        if (key_exists($lwsAttributeName, self::$attributeLwsToApiValueMap)) {
            //is this just a direct value to value (for example an integer value for limit or something).
            if (self::$attributeLwsToApiValueMap[$lwsAttributeName] === self::API_DIRECT_VALUE_TO_VALUE) {
                return $lwsAttributeValue;
            }
            //var_dump($lwsAttributeName);
            //var_dump($lwsAttributeValue);
            return self::$attributeLwsToApiValueMap[$lwsAttributeName][$lwsAttributeValue];
        }
        throw new Exception("Unknown value mapping");
    }

    public static function MapActivityCompletionToLws($apiCompleteStatus)
    {
        if($apiCompleteStatus == \RusticiSoftware\ScormContentPlayer\api\model\activityCompletion::COMPLETED)
        {
            return "complete";
        }

        return strtolower((string)$apiCompleteStatus);
    }

    public static function MapActivitySuccessToLws($apiActivitySuccess){
        return strtolower((string)$apiActivitySuccess);
    }

    public static function getApiRuntimeEntryToLws($apiEntryValue)
    {
        if(strtolower($apiEntryValue) == "abinitio")
            return "AbInitio";

        if(strtolower($apiEntryValue) == "resume")
            return "Resume";

        if(strtolower($apiEntryValue) == "other")
            return "Other";

        return "";
    }

    public static function getApiRuntimeCreditToLws($apiEntryValue)
    {
        if(strtolower($apiEntryValue) == "nocredit")
            return "NoCredit";

        if(strtolower($apiEntryValue) == "credit")
            return "Credit";

        return "";
    }

    public static function getApiRuntimeModeToLws($apiEntryValue)
    {
        if(strtolower($apiEntryValue) == "normal")
            return "Normal";

        if(strtolower($apiEntryValue) == "browse")
            return "Browse";

        if(strtolower($apiEntryValue) == "review")
            return "Review";

        return "";
    }

    public static function getApiRuntimeExitToLws($apiEntryValue)
    {
        if(strtolower($apiEntryValue) == "undefined")
            return "Undefined";

        if(strtolower($apiEntryValue) == "timeout")
            return "TimeOut";

        if(strtolower($apiEntryValue) == "suspend")
            return "Suspend";

        if(strtolower($apiEntryValue) == "logout")
            return "Logout";

        if(strtolower($apiEntryValue) == "normal")
            return "Normal";

        if(strtolower($apiEntryValue) == "unknown")
            return "Unknown";

        if(strtolower($apiEntryValue) == "override")
            return "Override";

        return "";
    }

    public static function getApiRuntimeSuccessStatusToLws($apiSuccessStat)
    {
        if(strtolower($apiSuccessStat) == "unknown")
            return "Unknown";

        if(strtolower($apiSuccessStat) == "passed")
            return "Passed";

        if(strtolower($apiSuccessStat) == "failed")
            return "Failed";

        return "";
    }

    public static function getApiRuntimeCompletionStatus($apiCompletionStatus)
    {
        if(strtolower($apiCompletionStatus) == "unknown")
            return "Unknown";

        if(strtolower($apiCompletionStatus) == "completed")
            return "Completed";

        if(strtolower($apiCompletionStatus) == "incomplete")
            return "Incomplete";

        if(strtolower($apiCompletionStatus) == "browsed")
            return "Browsed";

        if(strtolower($apiCompletionStatus) == "not_attempted")
            return "Not_Attempted";

        return "";
    }

    public static function addCData($name, $value, &$parent)
    {
        $child = $parent->addChild($name);

        if ($child !== NULL) {
            $child_node = dom_import_simplexml($child);
            $child_owner = $child_node->ownerDocument;
            $child_node->appendChild($child_owner->createCDATASection($value));
        }

        return $child;
    }

    public static function GetLwsLearningStandardFromApiValue($apiValue)
    {
        $apiValue = (string)$apiValue;
        $lwsLearningStandardMap = self::getLwsLearningStandards();
        $lwsValue = "unknown";
        if(array_key_exists($apiValue,$lwsLearningStandardMap)){
            $lwsValue = $lwsLearningStandardMap[$apiValue];
        }
        return $lwsValue;
    }

    public static function GetXmlString($rspXml)
    {
        $dom_sxe = dom_import_simplexml($rspXml);  // Returns a DomElement object
        $dom_output = new DOMDocument('1.0');
        $dom_output->formatOutput = false;
        $dom_sxe = $dom_output->importNode($dom_sxe, true);
        $dom_output->appendChild($dom_sxe);
        return $dom_output->saveXML($dom_output, LIBXML_NOEMPTYTAG);
    }

    private static function MapDebugApiValueToLws($debugAttributes, $apiAuditName, $apiDetailName, &$lwsAttributes)
    {
        //could use either _detail or _audit (const), because they both map
        //to the same lws field.
        $lwsName = APIMappings::getAttributeApiToLwsNameMap()[$apiAuditName];
        $lwsValue = self::LWS_OFF;

        if (strtolower($debugAttributes[$apiDetailName]) === strtolower(self::API_TRUE)) {
            $lwsValue = self::LWS_DETAILED;
        } elseif (strtolower($debugAttributes[$apiAuditName]) === strtolower(self::API_TRUE)) {
            $lwsValue = self::LWS_AUDIT;
        }

        $xml = new SimpleXMLElement("<attribute></attribute>");
        $xml->addAttribute('name', $lwsName);
        $xml->addAttribute('value', $lwsValue);
        $lwsAttributes[$lwsName] = $xml["value"];
    }

    private static function BuildLwsToApiAttributeNameMap()
    {
        if (is_null(self::$attributeApiToLwsNameMap)) {
            self::BuildApiToLwsAttributeNameMap();
        }
        self::$attributeLswToApiNameMap = array_flip(self::$attributeApiToLwsNameMap);

        //if these two are attempted exceptions will need to be thrown.
        self::$attributeLswToApiNameMap["title"] = "";
        self::$attributeLswToApiNameMap["scormVersion"] = "";
    }

    private static function BuildApiToLwsAttributeNameMap()
    {
        self::$attributeApiToLwsNameMap[self::API_PLAYER_ALLOW_COMPLETE_STATUS_CHANGE] = self::LWS_ALLOW_COMPLETE_STATUS_CHANGE;
        self::$attributeApiToLwsNameMap[self::API_PLAYER_ALWAYS_FLOW_TO_FIRST_SCO] = self::LWS_ALWAYS_FLOW_TO_FIRST_SCO;
        self::$attributeApiToLwsNameMap[self::API_PLAYER_APPLY_ROLLUP_STATUS_TO_SUCCESS] = self::LWS_APPLY_ROLLUP_STATUS_TO_SUCCESS;
        self::$attributeApiToLwsNameMap[self::API_PLAYER_COMM_COMMIT_FREQUENCY] = self::LWS_COMM_COMMIT_FREQUENCY;
        self::$attributeApiToLwsNameMap[self::API_PLAYER_COMM_MAX_FAILED_SUBMISSIONS] = self::LWS_COMM_MAX_FAILED_SUBMISSIONS;
        self::$attributeApiToLwsNameMap[self::API_PLAYER_COURSE_STRUCTURE_STARTS_OPEN] = self::LWS_COURSE_STRUCTURE_STARTS_OPEN;
        self::$attributeApiToLwsNameMap[self::API_PLAYER_COURSE_STRUCTURE_WIDTH] = self::LWS_COURSE_STRUCTURE_WIDTH;
        self::$attributeApiToLwsNameMap[self::API_PLAYER_DEBUG_INCLUDE_TIMESTAMPS] = self::LWS_DEBUG_INCLUDE_TIMESTAMPS;
        self::$attributeApiToLwsNameMap[self::API_PLAYER_DESIRED_FULL_SCREEN] = self::LWS_DESIRED_FULL_SCREEN;
        self::$attributeApiToLwsNameMap[self::API_PLAYER_DESIRED_HEIGHT] = self::LWS_DESIRED_HEIGHT;
        self::$attributeApiToLwsNameMap[self::API_PLAYER_DESIRED_WIDTH] = self::LWS_DESIRED_WIDTH;
        self::$attributeApiToLwsNameMap[self::API_PLAYER_ENABLE_CHOICE_NAV] = self::LWS_ENABLE_CHOICE_NAVIGATION;
        self::$attributeApiToLwsNameMap[self::API_PLAYER_ENABLE_FLOW_NAV] = self::LWS_ENABLE_PREV_NEXT;
        self::$attributeApiToLwsNameMap[self::API_PLAYER_FINISH_CAUSES_IMMEDIATE_COMMIT] = self::LWS_FINISH_CAUSES_IMMEDIATE_COMMIT;
        self::$attributeApiToLwsNameMap[self::API_PLAYER_FIRST_SCO_IS_PRETEST] = self::LWS_FIRST_SCO_IS_PRETEST;
        self::$attributeApiToLwsNameMap[self::API_PLAYER_INTERNET_EXPLORER_COMPATIBILITY_MODE] = self::LWS_IE_COMPATIBILITY_MODE;
        self::$attributeApiToLwsNameMap[self::API_PLAYER_INVALID_MENU_ITEM_ACTION] = self::LWS_INVALID_MENU_ITEM_ACTION;
        self::$attributeApiToLwsNameMap[self::API_PLAYER_LAUNCH_COMPLETED_REGS_AS_NO_CREDIT] = self::LWS_LAUNCH_COMPLETED_REGS_AS_NO_CREDIT;
        self::$attributeApiToLwsNameMap[self::API_PLAYER_LOGOUT_CAUSES_API_PLAYER_EXIT] = self::LWS_LOGOUT_CAUSES_API_PLAYER_EXIT;
        self::$attributeApiToLwsNameMap[self::API_PLAYER_FINAL_SCO_COURSE_NOT_SATISFIED_LOGOUT_EXIT_ACTION] = self::LWS_LOGOUT_FINAL_NOT_SAT_ACTION;
        self::$attributeApiToLwsNameMap[self::API_PLAYER_FINAL_SCO_COURSE_SATISFIED_LOGOUT_EXIT_ACTION] = self::LWS_LOGOUT_FINAL_SAT_ACTION;
        self::$attributeApiToLwsNameMap[self::API_PLAYER_INTERMEDIATE_SCO_NOT_SATISFIED_LOGOUT_EXIT_ACTION] = self::LWS_LOGOUT_INT_NOT_SAT_ACTION;
        self::$attributeApiToLwsNameMap[self::API_PLAYER_INTERMEDIATE_SCO_SATISFIED_LOGOUT_EXIT_ACTION] = self::LWS_LOGOUT_INT_SAT_ACTION;
        self::$attributeApiToLwsNameMap[self::API_PLAYER_LOOKAHEAD_SEQUENCER_MODE] = self::LWS_LOOKAHEAD_SEQUENCER_MODE;
        self::$attributeApiToLwsNameMap[self::API_PLAYER_FINAL_SCO_COURSE_NOT_SATISFIED_NORMAL_EXIT_ACTION] = self::LWS_NORMAL_FINAL_NOT_SAT_ACTION;
        self::$attributeApiToLwsNameMap[self::API_PLAYER_FINAL_SCO_COURSE_SATISFIED_NORMAL_EXIT_ACTION] = self::LWS_NORMAL_FINAL_SAT_ACTION;
        self::$attributeApiToLwsNameMap[self::API_PLAYER_INTERMEDIATE_SCO_NOT_SATISFIED_NORMAL_EXIT_ACTION] = self::LWS_NORMAL_INT_NOT_SAT_ACTION;
        self::$attributeApiToLwsNameMap[self::API_PLAYER_INTERMEDIATE_SCO_SATISFIED_NORMAL_EXIT_ACTION] = self::LWS_NORMAL_INT_SAT_ACTION;
        self::$attributeApiToLwsNameMap[self::API_PLAYER_SCORE_ROLLUP_MODE_NUMBER_OF_SCORING_OBJECTS] = self::LWS_NUMBER_OF_SCORING_OBJECTS;
        self::$attributeApiToLwsNameMap[self::API_PLAYER_LAUNCH_TYPE] = self::LWS_API_PLAYER_LAUNCH_TYPE1;
        self::$attributeApiToLwsNameMap[self::API_PLAYER_PREVENT_RIGHT_CLICK] = self::LWS_PREVENT_RIGHT_CLICK;
        self::$attributeApiToLwsNameMap[self::API_PLAYER_PREVENT_WINDOW_RESIZE] = self::LWS_PREVENT_WINDOW_RESIZE;
        self::$attributeApiToLwsNameMap[self::API_WHEN_TO_RESTART_REGISTRATION] = self::LWS_REGISTRATION_INSTANCING_OPTION;
        self::$attributeApiToLwsNameMap[self::API_PLAYER_REQUIRED_FULL_SCREEN] = self::LWS_REQUIRED_FULL_SCREEN;
        self::$attributeApiToLwsNameMap[self::API_PLAYER_REQUIRED_HEIGHT] = self::LWS_REQUIRED_HEIGHT;
        self::$attributeApiToLwsNameMap[self::API_PLAYER_REQUIRED_WIDTH] = self::LWS_REQUIRED_WIDTH;
        self::$attributeApiToLwsNameMap[self::API_PLAYER_RESET_RUN_TIME_DATA] = self::LWS_RESET_RUN_TIME_DATA_TIMING;
        self::$attributeApiToLwsNameMap[self::API_PLAYER_ROLLUP_EMPTY_SET_TO_UNKNOWN] = self::LWS_ROLLUP_EMPTY_SET_TO_UNKNOWN;
        self::$attributeApiToLwsNameMap[self::API_PLAYER_OFFLINE_SYNCH_MODE] = self::LWS_RSOP_SYNCH_MODE;
        self::$attributeApiToLwsNameMap[self::API_PLAYER_SCALE_RAW_SCORE] = self::LWS_SCALE_RAW_SCORE;
        self::$attributeApiToLwsNameMap[self::API_PLAYER_SCO_LAUNCH_TYPE] = self::LWS_SCO_LAUNCH_TYPE;
        self::$attributeApiToLwsNameMap[self::API_PLAYER_SCORE_OVERRIDES_STATUS] = self::LWS_SCORE_OVERRIDES_STATUS;
        self::$attributeApiToLwsNameMap[self::API_PLAYER_SCORE_ROLLUP_MODE_VALUE] = self::LWS_SCORE_ROLLUP_MODE;
        self::$attributeApiToLwsNameMap[self::API_PLAYER_SHOW_CLOSE_ITEM] = self::LWS_SHOW_CLOSE_ITEM;
        self::$attributeApiToLwsNameMap[self::API_PLAYER_SHOW_COURSE_STRUCTURE] = self::LWS_SHOW_COURSE_STRUCTURE;
        self::$attributeApiToLwsNameMap[self::API_PLAYER_SHOW_FINISH_BUTTON] = self::LWS_SHOW_FINISH_BUTTON;
        self::$attributeApiToLwsNameMap[self::API_PLAYER_SHOW_HELP] = self::LWS_SHOW_HELP;
        self::$attributeApiToLwsNameMap[self::API_PLAYER_SHOW_NAV_BAR] = self::LWS_SHOW_NAV_BAR;
        self::$attributeApiToLwsNameMap[self::API_PLAYER_SHOW_PROGRESS_BAR] = self::LWS_SHOW_PROGRESS_BAR;
        self::$attributeApiToLwsNameMap[self::API_PLAYER_SHOW_TITLE_BAR] = self::LWS_SHOW_TITLE_BAR;
        self::$attributeApiToLwsNameMap[self::API_PLAYER_STATUS_DISPLAY_PREFERENCE] = self::LWS_STATUS_DISPLAY;
        self::$attributeApiToLwsNameMap[self::API_PLAYER_STATUS_ROLLUP_MODE_VALUE] = self::LWS_STATUS_ROLLUP_MODE;

        self::$attributeApiToLwsNameMap[self::API_PLAYER_FINAL_SCO_COURSE_NOT_SATISFIED_SUSPEND_EXIT_ACTION] = self::LWS_SUSPEND_FINAL_NOT_SAT_ACTION;
        self::$attributeApiToLwsNameMap[self::API_PLAYER_FINAL_SCO_COURSE_SATISFIED_SUSPEND_EXIT_ACTION] = self::LWS_SUSPEND_FINAL_SAT_ACTION;
        self::$attributeApiToLwsNameMap[self::API_PLAYER_INTERMEDIATE_SCO_NOT_SATISFIED_SUSPEND_EXIT_ACTION] = self::LWS_SUSPEND_INT_NOT_SAT_ACTION;
        self::$attributeApiToLwsNameMap[self::API_PLAYER_INTERMEDIATE_SCO_SATISFIED_SUSPEND_EXIT_ACTION] = self::LWS_SUSPEND_INT_SAT_ACTION;
        self::$attributeApiToLwsNameMap[self::API_PLAYER_STATUS_ROLLUP_MODE_THRESHOLD_SCORE] = self::LWS_THRESHOLD_SCORE;
        self::$attributeApiToLwsNameMap[self::API_PLAYER_TIME_LIMIT] = self::LWS_TIME_LIMIT;
        self::$attributeApiToLwsNameMap[self::API_PLAYER_FINAL_SCO_COURSE_NOT_SATISFIED_TIMEOUT_EXIT_ACTION] = self::LWS_TIMEOUT_FINAL_NOT_SAT_ACTION;
        self::$attributeApiToLwsNameMap[self::API_PLAYER_FINAL_SCO_COURSE_SATISFIED_TIMEOUT_EXIT_ACTION] = self::LWS_TIMEOUT_FINAL_SAT_ACTION;
        self::$attributeApiToLwsNameMap[self::API_PLAYER_INTERMEDIATE_SCO_NOT_SATISFIED_TIMEOUT_EXIT_ACTION] = self::LWS_TIMEOUT_INT_NOT_SAT_ACTION;
        self::$attributeApiToLwsNameMap[self::API_PLAYER_INTERMEDIATE_SCO_SATISFIED_TIMEOUT_EXIT_ACTION] = self::LWS_TIMEOUT_INT_SAT_ACTION;
        self::$attributeApiToLwsNameMap[self::API_PLAYER_VALIDATE_INTERACTION_RESPONSES] = self::LWS_VALIDATE_INTERACTION_RESPONSES;
        self::$attributeApiToLwsNameMap[self::API_PLAYER_WRAP_SCO_WINDOW_WITH_API] = self::LWS_WRAP_SCO_WINDOW_WITH_API;

        //these are one to many, so we have include the attribute value as part of the key.";
        self::$attributeApiToLwsNameMap[self::API_PLAYER_DEBUG_CONTROL_AUDIT] = self::LWS_DEBUG_CONTROL;
        self::$attributeApiToLwsNameMap[self::API_PLAYER_DEBUG_CONTROL_DETAILED] = self::LWS_DEBUG_CONTROL;
        self::$attributeApiToLwsNameMap[self::API_PLAYER_DEBUG_LOOK_AHEAD_AUDIT] = self::LWS_DEBUG_LOOK_AHEAD;
        self::$attributeApiToLwsNameMap[self::API_PLAYER_DEBUG_LOOK_AHEAD_DETAILED] = self::LWS_DEBUG_LOOK_AHEAD;
        self::$attributeApiToLwsNameMap[self::API_PLAYER_DEBUG_RTE_AUDIT] = self::LWS_DEBUG_RUNTIME;
        self::$attributeApiToLwsNameMap[self::API_PLAYER_DEBUG_RTE_DETAILED] = self::LWS_DEBUG_RUNTIME;
        self::$attributeApiToLwsNameMap[self::API_PLAYER_DEBUG_SEQUENCING_AUDIT] = self::LWS_DEBUG_SEQUENCING;
        self::$attributeApiToLwsNameMap[self::API_PLAYER_DEBUG_SEQUENCING_DETAILED] = self::LWS_DEBUG_SEQUENCING;
        self::$attributeApiToLwsNameMap[self::API_PLAYER_DEBUG_SEQUENCING_SIMPLE] = "debugSequencing_simple";
    }

    private static function BuildApiDebugNames()
    {

        self::$attributeApiDebugNames[self::API_PLAYER_DEBUG_CONTROL_AUDIT] = "";
        self::$attributeApiDebugNames[self::API_PLAYER_DEBUG_CONTROL_DETAILED] = "";
        self::$attributeApiDebugNames[self::API_PLAYER_DEBUG_LOOK_AHEAD_AUDIT] = "";
        self::$attributeApiDebugNames[self::API_PLAYER_DEBUG_LOOK_AHEAD_DETAILED] = "";
        self::$attributeApiDebugNames[self::API_PLAYER_DEBUG_RTE_AUDIT] = "";
        self::$attributeApiDebugNames[self::API_PLAYER_DEBUG_RTE_DETAILED] = "";
        self::$attributeApiDebugNames[self::API_PLAYER_DEBUG_SEQUENCING_AUDIT] = "";
        self::$attributeApiDebugNames[self::API_PLAYER_DEBUG_SEQUENCING_DETAILED] = "";
        self::$attributeApiDebugNames[self::API_PLAYER_DEBUG_SEQUENCING_SIMPLE] = "";
    }

    private static function BuildLwsDebugNames()
    {
        self::$attributeLwsDebugNames[self::LWS_DEBUG_CONTROL] = "";
        self::$attributeLwsDebugNames[self::LWS_DEBUG_LOOK_AHEAD] = "";
        self::$attributeLwsDebugNames[self::LWS_DEBUG_RUNTIME] = "";
        self::$attributeLwsDebugNames[self::LWS_DEBUG_SEQUENCING] = "";
    }

    private static function BuildLwsToApiAttributeValueMap()
    {
        //note we are flipping these maps so that we can map the other way. localws value -> api value.
        $yesNoValues = array_flip(self::GetYesNoValues());
        $trueFalseValues = array_flip(self::GetTrueFalseValues());
        $showHideDisabledValues = array_flip(self::GetHideShowDisableValues());
        $exitActionValues = array_flip(self::GetExitActionValues());
        $lookaheadSequencerModeValues = array_flip(self::GetLookAheadValues());
        $launchTypeValues = array_flip(self::GetLaunchTypeValues());
        $registrationInstanceIncrementTimingValues = array_flip(self::GetRegistrationInstanceIncrementTimingValues());
        $resetRunTimeDataTimingValues = array_flip(self::GetResetRunTimeDataTimingValues());
        $scoreRollupMethodValues = array_flip(self::GetScoreRollupMethodValues());
        $statusDisplayValues = array_flip(self::GetStatusDisplayValues());
        $statusRollupMethodValues = array_flip(self::GetStatusRollupMethodValues());
        $rsopSynchModeTypeValues = array_flip(self::GetRsopSynchModeTypeValues());

        self::$attributeLwsToApiValueMap[self::LWS_ALLOW_COMPLETE_STATUS_CHANGE] = $yesNoValues;
        self::$attributeLwsToApiValueMap[self::LWS_ALWAYS_FLOW_TO_FIRST_SCO] = $yesNoValues;
        self::$attributeLwsToApiValueMap[self::LWS_APPLY_ROLLUP_STATUS_TO_SUCCESS] = $yesNoValues;
        self::$attributeLwsToApiValueMap[self::LWS_COMM_COMMIT_FREQUENCY] = self::API_DIRECT_VALUE_TO_VALUE;
        self::$attributeLwsToApiValueMap[self::LWS_COMM_MAX_FAILED_SUBMISSIONS] = self::API_DIRECT_VALUE_TO_VALUE;
        self::$attributeLwsToApiValueMap[self::LWS_COURSE_STRUCTURE_STARTS_OPEN] = $yesNoValues;
        self::$attributeLwsToApiValueMap[self::LWS_COURSE_STRUCTURE_WIDTH] = self::API_DIRECT_VALUE_TO_VALUE;

        self::$attributeLwsToApiValueMap[self::LWS_DEBUG_INCLUDE_TIMESTAMPS] = $trueFalseValues;
        self::$attributeLwsToApiValueMap[self::LWS_DESIRED_FULL_SCREEN] = $yesNoValues;

        self::$attributeLwsToApiValueMap[self::LWS_DESIRED_HEIGHT] = self::API_DIRECT_VALUE_TO_VALUE;
        self::$attributeLwsToApiValueMap[self::LWS_DESIRED_WIDTH] = self::API_DIRECT_VALUE_TO_VALUE;

        self::$attributeLwsToApiValueMap[self::LWS_ENABLE_CHOICE_NAVIGATION] = $yesNoValues;
        self::$attributeLwsToApiValueMap[self::LWS_ENABLE_PREV_NEXT] = $yesNoValues;
        self::$attributeLwsToApiValueMap[self::LWS_FINISH_CAUSES_IMMEDIATE_COMMIT] = $yesNoValues;
        self::$attributeLwsToApiValueMap[self::LWS_FIRST_SCO_IS_PRETEST] = $yesNoValues;

        self::$attributeLwsToApiValueMap[self::LWS_IE_COMPATIBILITY_MODE] = self::API_DIRECT_VALUE_TO_VALUE;

        self::$attributeLwsToApiValueMap[self::LWS_INVALID_MENU_ITEM_ACTION] = $showHideDisabledValues;
        self::$attributeLwsToApiValueMap[self::LWS_LAUNCH_COMPLETED_REGS_AS_NO_CREDIT] = $yesNoValues;
        self::$attributeLwsToApiValueMap[self::LWS_LOGOUT_CAUSES_API_PLAYER_EXIT] = $yesNoValues;
        self::$attributeLwsToApiValueMap[self::LWS_LOGOUT_FINAL_NOT_SAT_ACTION] = $exitActionValues;
        self::$attributeLwsToApiValueMap[self::LWS_LOGOUT_FINAL_SAT_ACTION] = $exitActionValues;
        self::$attributeLwsToApiValueMap[self::LWS_LOGOUT_INT_NOT_SAT_ACTION] = $exitActionValues;
        self::$attributeLwsToApiValueMap[self::LWS_LOGOUT_INT_SAT_ACTION] = $exitActionValues;
        self::$attributeLwsToApiValueMap[self::LWS_LOOKAHEAD_SEQUENCER_MODE] = $lookaheadSequencerModeValues;
        self::$attributeLwsToApiValueMap[self::LWS_NORMAL_FINAL_NOT_SAT_ACTION] = $exitActionValues;
        self::$attributeLwsToApiValueMap[self::LWS_NORMAL_FINAL_SAT_ACTION] = $exitActionValues;
        self::$attributeLwsToApiValueMap[self::LWS_NORMAL_INT_NOT_SAT_ACTION] = $exitActionValues;
        self::$attributeLwsToApiValueMap[self::LWS_NORMAL_INT_SAT_ACTION] = $exitActionValues;
        self::$attributeLwsToApiValueMap[self::LWS_NUMBER_OF_SCORING_OBJECTS] = self::API_DIRECT_VALUE_TO_VALUE;
        self::$attributeLwsToApiValueMap[self::LWS_API_PLAYER_LAUNCH_TYPE1] = $launchTypeValues;
        self::$attributeLwsToApiValueMap[self::LWS_PREVENT_RIGHT_CLICK] = $yesNoValues;
        self::$attributeLwsToApiValueMap[self::LWS_PREVENT_WINDOW_RESIZE] = $yesNoValues;
        self::$attributeLwsToApiValueMap[self::LWS_REGISTRATION_INSTANCING_OPTION] = $registrationInstanceIncrementTimingValues;
        self::$attributeLwsToApiValueMap[self::LWS_REQUIRED_FULL_SCREEN] = $yesNoValues;
        self::$attributeLwsToApiValueMap[self::LWS_REQUIRED_HEIGHT] = self::API_DIRECT_VALUE_TO_VALUE;
        self::$attributeLwsToApiValueMap[self::LWS_REQUIRED_WIDTH] = self::API_DIRECT_VALUE_TO_VALUE;
        self::$attributeLwsToApiValueMap[self::LWS_RESET_RUN_TIME_DATA_TIMING] = $resetRunTimeDataTimingValues;
        self::$attributeLwsToApiValueMap[self::LWS_ROLLUP_EMPTY_SET_TO_UNKNOWN] = $yesNoValues;
        self::$attributeLwsToApiValueMap[self::LWS_SCALE_RAW_SCORE] = $yesNoValues;
        self::$attributeLwsToApiValueMap[self::LWS_SCO_LAUNCH_TYPE] = $launchTypeValues;
        self::$attributeLwsToApiValueMap[self::LWS_SCORE_OVERRIDES_STATUS] = $yesNoValues;
        self::$attributeLwsToApiValueMap[self::LWS_SCORE_ROLLUP_MODE] = $scoreRollupMethodValues;
        self::$attributeLwsToApiValueMap[self::LWS_SHOW_CLOSE_ITEM] = $yesNoValues;
        self::$attributeLwsToApiValueMap[self::LWS_SHOW_COURSE_STRUCTURE] = $yesNoValues;
        self::$attributeLwsToApiValueMap[self::LWS_SHOW_FINISH_BUTTON] = $yesNoValues;
        self::$attributeLwsToApiValueMap[self::LWS_SHOW_HELP] = $yesNoValues;
        self::$attributeLwsToApiValueMap[self::LWS_SHOW_NAV_BAR] = $yesNoValues;
        self::$attributeLwsToApiValueMap[self::LWS_SHOW_PROGRESS_BAR] = $yesNoValues;
        self::$attributeLwsToApiValueMap[self::LWS_SHOW_TITLE_BAR] = $yesNoValues;

        self::$attributeLwsToApiValueMap[self::LWS_STATUS_DISPLAY] = $statusDisplayValues;
        self::$attributeLwsToApiValueMap[self::LWS_STATUS_ROLLUP_MODE] = $statusRollupMethodValues;

        self::$attributeLwsToApiValueMap[self::LWS_SUSPEND_FINAL_NOT_SAT_ACTION] = $exitActionValues;
        self::$attributeLwsToApiValueMap[self::LWS_SUSPEND_FINAL_SAT_ACTION] = $exitActionValues;
        self::$attributeLwsToApiValueMap[self::LWS_SUSPEND_INT_NOT_SAT_ACTION] = $exitActionValues;
        self::$attributeLwsToApiValueMap[self::LWS_SUSPEND_INT_SAT_ACTION] = $exitActionValues;
        self::$attributeLwsToApiValueMap[self::LWS_THRESHOLD_SCORE] = self::API_DIRECT_VALUE_TO_VALUE;
        self::$attributeLwsToApiValueMap[self::LWS_TIME_LIMIT] = self::API_DIRECT_VALUE_TO_VALUE;
        self::$attributeLwsToApiValueMap[self::LWS_TIMEOUT_FINAL_NOT_SAT_ACTION] = $exitActionValues;
        self::$attributeLwsToApiValueMap[self::LWS_TIMEOUT_FINAL_SAT_ACTION] = $exitActionValues;
        self::$attributeLwsToApiValueMap[self::LWS_TIMEOUT_INT_NOT_SAT_ACTION] = $exitActionValues;
        self::$attributeLwsToApiValueMap[self::LWS_TIMEOUT_INT_SAT_ACTION] = $exitActionValues;
        self::$attributeLwsToApiValueMap[self::LWS_VALIDATE_INTERACTION_RESPONSES] = $yesNoValues;
        self::$attributeLwsToApiValueMap[self::LWS_WRAP_SCO_WINDOW_WITH_API] = $yesNoValues;
        self::$attributeLwsToApiValueMap[self::LWS_RSOP_SYNCH_MODE] = $rsopSynchModeTypeValues;
    }

    private static function BuildApiToLwsAttributeValueMap()
    {
        //for the booleans.
        $yesNoValues = self::GetYesNoUndefinedValues();
        $trueFalseValues = self::GetTrueFalseValues();
        $showHideDisabledValues = self::GetHideShowDisableValues();
        $exitActionValues = self::GetExitActionValues();
        $lookaheadSequencerModeValues = self::GetLookAheadValues();
        $launchTypeValues = self::GetLaunchTypeValues();
        $registrationInstanceIncrementTimingValues = self::GetRegistrationInstanceIncrementTimingValues();
        $resetRunTimeDataTimingValues = self::GetResetRunTimeDataTimingValues();
        $scoreRollupMethodValues = self::GetScoreRollupMethodValues();
        $statusDisplayValues = self::GetStatusDisplayValues();
        $statusRollupMethodValues = self::GetStatusRollupMethodValues();
        $rsopSynchModeTypeValues = self::GetRsopSynchModeTypeValues();


        self::$attributeApiToLwsValueMap[self::API_PLAYER_ALLOW_COMPLETE_STATUS_CHANGE] = $yesNoValues;
        self::$attributeApiToLwsValueMap[self::API_PLAYER_ALWAYS_FLOW_TO_FIRST_SCO] = $yesNoValues;
        self::$attributeApiToLwsValueMap[self::API_PLAYER_APPLY_ROLLUP_STATUS_TO_SUCCESS] = $yesNoValues;
        self::$attributeApiToLwsValueMap[self::API_PLAYER_COMM_COMMIT_FREQUENCY] = self::API_DIRECT_VALUE_TO_VALUE;
        self::$attributeApiToLwsValueMap[self::API_PLAYER_COMM_MAX_FAILED_SUBMISSIONS] = self::API_DIRECT_VALUE_TO_VALUE;
        self::$attributeApiToLwsValueMap[self::API_PLAYER_COURSE_STRUCTURE_STARTS_OPEN] = $yesNoValues;
        self::$attributeApiToLwsValueMap[self::API_PLAYER_COURSE_STRUCTURE_WIDTH] = self::API_DIRECT_VALUE_TO_VALUE;

        self::$attributeApiToLwsValueMap[self::API_PLAYER_DEBUG_INCLUDE_TIMESTAMPS] = $trueFalseValues;
        self::$attributeApiToLwsValueMap[self::API_PLAYER_DESIRED_FULL_SCREEN] = $yesNoValues;


        self::$attributeApiToLwsValueMap[self::API_PLAYER_DESIRED_HEIGHT] = self::API_DIRECT_VALUE_TO_VALUE;
        self::$attributeApiToLwsValueMap[self::API_PLAYER_DESIRED_WIDTH] = self::API_DIRECT_VALUE_TO_VALUE;

        self::$attributeApiToLwsValueMap[self::API_PLAYER_ENABLE_CHOICE_NAV] = $yesNoValues;
        self::$attributeApiToLwsValueMap[self::API_PLAYER_ENABLE_FLOW_NAV] = $yesNoValues;
        self::$attributeApiToLwsValueMap[self::API_PLAYER_FINISH_CAUSES_IMMEDIATE_COMMIT] = $yesNoValues;
        self::$attributeApiToLwsValueMap[self::API_PLAYER_FIRST_SCO_IS_PRETEST] = $yesNoValues;

        self::$attributeApiToLwsValueMap[self::API_PLAYER_INTERNET_EXPLORER_COMPATIBILITY_MODE] = self::API_DIRECT_VALUE_TO_VALUE;

        self::$attributeApiToLwsValueMap[self::API_PLAYER_INVALID_MENU_ITEM_ACTION] = $showHideDisabledValues;
        self::$attributeApiToLwsValueMap[self::API_PLAYER_LAUNCH_COMPLETED_REGS_AS_NO_CREDIT] = $yesNoValues;
        self::$attributeApiToLwsValueMap[self::API_PLAYER_LOGOUT_CAUSES_API_PLAYER_EXIT] = $yesNoValues;
        self::$attributeApiToLwsValueMap[self::API_PLAYER_FINAL_SCO_COURSE_NOT_SATISFIED_LOGOUT_EXIT_ACTION] = $exitActionValues;
        self::$attributeApiToLwsValueMap[self::API_PLAYER_FINAL_SCO_COURSE_SATISFIED_LOGOUT_EXIT_ACTION] = $exitActionValues;
        self::$attributeApiToLwsValueMap[self::API_PLAYER_INTERMEDIATE_SCO_NOT_SATISFIED_LOGOUT_EXIT_ACTION] = $exitActionValues;
        self::$attributeApiToLwsValueMap[self::API_PLAYER_INTERMEDIATE_SCO_SATISFIED_LOGOUT_EXIT_ACTION] = $exitActionValues;
        self::$attributeApiToLwsValueMap[self::API_PLAYER_LOOKAHEAD_SEQUENCER_MODE] = $lookaheadSequencerModeValues;
        self::$attributeApiToLwsValueMap[self::API_PLAYER_FINAL_SCO_COURSE_NOT_SATISFIED_NORMAL_EXIT_ACTION] = $exitActionValues;
        self::$attributeApiToLwsValueMap[self::API_PLAYER_FINAL_SCO_COURSE_SATISFIED_NORMAL_EXIT_ACTION] = $exitActionValues;
        self::$attributeApiToLwsValueMap[self::API_PLAYER_INTERMEDIATE_SCO_NOT_SATISFIED_NORMAL_EXIT_ACTION] = $exitActionValues;
        self::$attributeApiToLwsValueMap[self::API_PLAYER_INTERMEDIATE_SCO_SATISFIED_NORMAL_EXIT_ACTION] = $exitActionValues;
        self::$attributeApiToLwsValueMap[self::API_PLAYER_SCORE_ROLLUP_MODE_NUMBER_OF_SCORING_OBJECTS] = self::API_DIRECT_VALUE_TO_VALUE;
        self::$attributeApiToLwsValueMap[self::API_PLAYER_LAUNCH_TYPE] = $launchTypeValues;
        self::$attributeApiToLwsValueMap[self::API_PLAYER_PREVENT_RIGHT_CLICK] = $yesNoValues;
        self::$attributeApiToLwsValueMap[self::API_PLAYER_PREVENT_WINDOW_RESIZE] = $yesNoValues;
        self::$attributeApiToLwsValueMap[self::API_WHEN_TO_RESTART_REGISTRATION] = $registrationInstanceIncrementTimingValues;
        self::$attributeApiToLwsValueMap[self::API_PLAYER_REQUIRED_FULL_SCREEN] = $yesNoValues;
        self::$attributeApiToLwsValueMap[self::API_PLAYER_REQUIRED_HEIGHT] = self::API_DIRECT_VALUE_TO_VALUE;
        self::$attributeApiToLwsValueMap[self::API_PLAYER_REQUIRED_WIDTH] = self::API_DIRECT_VALUE_TO_VALUE;
        self::$attributeApiToLwsValueMap[self::API_PLAYER_RESET_RUN_TIME_DATA] = $resetRunTimeDataTimingValues;
        self::$attributeApiToLwsValueMap[self::API_PLAYER_ROLLUP_EMPTY_SET_TO_UNKNOWN] = $yesNoValues;
        self::$attributeApiToLwsValueMap[self::API_PLAYER_SCALE_RAW_SCORE] = $yesNoValues;
        self::$attributeApiToLwsValueMap[self::API_PLAYER_SCO_LAUNCH_TYPE] = $launchTypeValues;
        self::$attributeApiToLwsValueMap[self::API_PLAYER_SCORE_OVERRIDES_STATUS] = $yesNoValues;
        self::$attributeApiToLwsValueMap[self::API_PLAYER_SCORE_ROLLUP_MODE_VALUE] = $scoreRollupMethodValues;
        self::$attributeApiToLwsValueMap[self::API_PLAYER_SHOW_CLOSE_ITEM] = $yesNoValues;
        self::$attributeApiToLwsValueMap[self::API_PLAYER_SHOW_COURSE_STRUCTURE] = $yesNoValues;
        self::$attributeApiToLwsValueMap[self::API_PLAYER_SHOW_FINISH_BUTTON] = $yesNoValues;
        self::$attributeApiToLwsValueMap[self::API_PLAYER_SHOW_HELP] = $yesNoValues;
        self::$attributeApiToLwsValueMap[self::API_PLAYER_SHOW_NAV_BAR] = $yesNoValues;
        self::$attributeApiToLwsValueMap[self::API_PLAYER_SHOW_PROGRESS_BAR] = $yesNoValues;
        self::$attributeApiToLwsValueMap[self::API_PLAYER_SHOW_TITLE_BAR] = $yesNoValues;

        self::$attributeApiToLwsValueMap[self::API_PLAYER_STATUS_DISPLAY_PREFERENCE] = $statusDisplayValues;
        self::$attributeApiToLwsValueMap[self::API_PLAYER_STATUS_ROLLUP_MODE_VALUE] = $statusRollupMethodValues;

        self::$attributeApiToLwsValueMap[self::API_PLAYER_FINAL_SCO_COURSE_NOT_SATISFIED_SUSPEND_EXIT_ACTION] = $exitActionValues;
        self::$attributeApiToLwsValueMap[self::API_PLAYER_FINAL_SCO_COURSE_SATISFIED_SUSPEND_EXIT_ACTION] = $exitActionValues;
        self::$attributeApiToLwsValueMap[self::API_PLAYER_INTERMEDIATE_SCO_NOT_SATISFIED_SUSPEND_EXIT_ACTION] = $exitActionValues;
        self::$attributeApiToLwsValueMap[self::API_PLAYER_INTERMEDIATE_SCO_SATISFIED_SUSPEND_EXIT_ACTION] = $exitActionValues;
        self::$attributeApiToLwsValueMap[self::API_PLAYER_STATUS_ROLLUP_MODE_THRESHOLD_SCORE] = self::API_DIRECT_VALUE_TO_VALUE;
        self::$attributeApiToLwsValueMap[self::API_PLAYER_TIME_LIMIT] = self::API_DIRECT_VALUE_TO_VALUE;
        self::$attributeApiToLwsValueMap[self::API_PLAYER_FINAL_SCO_COURSE_NOT_SATISFIED_TIMEOUT_EXIT_ACTION] = $exitActionValues;
        self::$attributeApiToLwsValueMap[self::API_PLAYER_FINAL_SCO_COURSE_SATISFIED_TIMEOUT_EXIT_ACTION] = $exitActionValues;
        self::$attributeApiToLwsValueMap[self::API_PLAYER_INTERMEDIATE_SCO_NOT_SATISFIED_TIMEOUT_EXIT_ACTION] = $exitActionValues;
        self::$attributeApiToLwsValueMap[self::API_PLAYER_INTERMEDIATE_SCO_SATISFIED_TIMEOUT_EXIT_ACTION] = $exitActionValues;
        self::$attributeApiToLwsValueMap[self::API_PLAYER_VALIDATE_INTERACTION_RESPONSES] = $yesNoValues;
        self::$attributeApiToLwsValueMap[self::API_PLAYER_WRAP_SCO_WINDOW_WITH_API] = $yesNoValues;
        self::$attributeApiToLwsValueMap[self::API_PLAYER_OFFLINE_SYNCH_MODE] = $rsopSynchModeTypeValues;

        //no debugging mapping is done here, because that requires looking at multiple instance values.
    }

    private static function GetLookAheadValues()
    {
        $lookaheadSequencerModeValues = Array('UNKNOWN' => '-9223372036854775808',
            'DISABLED' => '1',
            'ENABLED' => '2',
            'REALTIME' => '3');
        return $lookaheadSequencerModeValues;
    }

    private static function GetExitActionValues()
    {
        $exitActionValues = Array('UNDEFINED' => '-9223372036854775808',
            'EXIT_COURSE' => '1',
            'EXIT_COURSE_AFTER_CONFIRM' => '2',
            'GO_TO_NEXT_SCO' => '3',
            'DISPLAY_MESSAGE' => '4',
            'DO_NOTHING' => '5');
        return $exitActionValues;
    }

    private static function GetHideShowDisableValues()
    {
        $undefinedShowHideDisabled = Array('UNDEFINED' => '-9223372036854775808',
            'SHOW' => 1,
            'HIDE' => 2,
            'DISABLE' => 3);
        return $undefinedShowHideDisabled;
    }

    private static function GetTrueFalseValues()
    {
        $yesNoUndefined = Array(self::API_TRUE => self::LWS_TRUE,
            self::API_FALSE => self::LWS_FALSE,
            strtolower(self::API_TRUE) => self::LWS_TRUE,
            strtolower(self::API_FALSE) => self::LWS_FALSE
        );
        return $yesNoUndefined;
    }

    private static function GetYesNoUndefinedValues()
    {
        $yesNoUndefined = Array(self::API_YES => self::LWS_TRUE,
            self::API_NO => self::LWS_FALSE,
            'UNDEFINED' => self::LWS_FALSE);
        return $yesNoUndefined;
    }

    private static function GetYesNoValues()
    {
        $yesNo = Array(self::API_YES => self::LWS_TRUE,
            self::API_NO => self::LWS_FALSE);
        return $yesNo;
    }

    private static function GetLaunchTypeValues()
    {
        $launchTypeValue = Array('UNDEFINED' => '-9223372036854775808',
            'FRAMESET' => '1',
            'NEW_WINDOW' => '2',
            'NEW_WINDOW_AFTER_CLICK' => '3',
            'NEW_WINDOW_WITHOUT_BROWSER_TOOLBAR' => '4',
            'NEW_WINDOW_AFTER_CLICK_WITHOUT_BROWSER_TOOLBAR' => '5');
        return $launchTypeValue;
    }

    private static function GetRegistrationInstanceIncrementTimingValues()
    {
        $registrationInstanceIncrementTimingValues = Array(
            'UNDEFINED' => '-9223372036854775808',
            'NEVER' => '1',
            'WHEN_EXISTING_REG_IS_COMPLETE_AND_NEWER_PACKAGE_VERSION_EXISTS' => '2',
            'WHEN_NEWER_PACKAGE_VERSION_EXISTS' => '3',
            'WHEN_EXISTING_REG_IS_COMPLETE' => '4',
            'WHEN_EXISTING_REG_IS_SATISFIED' => '5',
            'WHEN_EXISTING_REG_IS_SATISFIED_AND_NEWER_PACKAGE_VERSION_EXISTS' => '6',
            'WHEN_EXISTING_REG_IS_INCOMPLETE_AND_NEWER_PACKAGE_VERSION_EXISTS' => '7');
        return $registrationInstanceIncrementTimingValues;
    }

    private static function GetResetRunTimeDataTimingValues()
    {
        $resetRunTimeDataTimingValue = Array('UNDEFINED' => '-9223372036854775808',
            'NEVER' => '1',
            'WHEN_EXIT_IS_NOT_SUSPEND' => '2',
            'ON_EACH_NEW_SEQUENCING_ATTEMPT' => '3');
        return $resetRunTimeDataTimingValue;
    }

    private static function GetScoreRollupMethodValues()
    {
        $scoreRollupMethodValues = Array('UNDEFINED' => '-9223372036854775808',
            'SCORE_PROVIDED_BY_COURSE' => '1',
            'AVERAGE_SCORE_OF_ALL_UNITS' => '2',
            'AVERAGE_SCORE_OF_ALL_UNITS_WITH_SCORES' => '3',
            'FIXED_AVERAGE' => '4',
            'AVERAGE_SCORE_OF_ALL_UNITS_WITH_NONZERO_SCORES' => '5',
            'LAST_SCO_SCORE' => '6');
        return $scoreRollupMethodValues;
    }


    private static function BuildLwsLearningStandards()
    {
        self::$lwsLearningStandardValueMap = Array('UNKNOWN' => '-9223372036854775808',
            'SCORM_11' => 'scorm11',
            'SCORM_12' => 'scorm12',
            'SCORM_2004_2ND_EDITION' => 'scorm20042ndedition',
            'AICC' => 'aicc',
            'SCORM_2004_3RD_EDITION' => 'scorm20043rdedition',
            'SCORM_2004_4TH_EDITION' => 'scorm20044thedition',
            'TINCAN' => 'tincan');
    }



    private static function BuildApiToLwsLearningStandardTextMap ()
    {
        self::$apiToLwsLearningStandardTextMap = Array('UNKNOWN' => '-9223372036854775808',
            'SCORM_11' => 'SCORM 1.1',
            'SCORM_12' => 'SCORM 1.2',
            'SCORM_2004_2ND_EDITION' => 'SCORM 2004 3rd Edition',
            'AICC' => 'AICC',
            'SCORM_2004_3RD_EDITION' => 'SCORM 2004 2nd Edition',
            'SCORM_2004_4TH_EDITION' => 'SCORM 2004 4th Edition',
            'TINCAN' => 'Tin Can');
    }

    private static function GetStatusDisplayValues()
    {
        $statusDisplayValues = Array('UNDEFINED' => '-9223372036854775808',
            'SUCCESS_ONLY' => '1',
            'COMPLETION_ONLY' => '2',
            'SEPARATE' => '3',
            'COMBINED' => '4',
            'NONE' => '5');
        return $statusDisplayValues;
    }

    private static function GetStatusRollupMethodValues()
    {
        $statusRollupMethodValues = Array('UNDEFINED' => '-9223372036854775808',
            'STATUS_PROVIDED_BY_COURSE' => '1',
            'COMPLETE_WHEN_ALL_UNITS_COMPLETE' => '2',
            'COMPLETE_WHEN_ALL_UNITS_COMPLETE_AND_NOT_FAILED' => '3',
            'COMPLETE_WHEN_THRESHOLD_SCORE_IS_MET' => '4',
            'COMPLETE_WHEN_ALL_UNITS_COMPLETE_AND_THRESHOLD_SCORE_IS_MET' => '5',
            'COMPLETE_WHEN_ALL_UNITS_ARE_PASSED' => '6');
        return $statusRollupMethodValues;
    }

    private static function GetRsopSynchModeTypeValues()
    {
        $rsopSynchModeTypeValues = Array(
            'Undefined' => '-9223372036854775808',
            'MostRecent' => '1',
            'Simple' => '2',
            'MostComplete' => '3',
            'MostSatisfied' => '4',
            'MostDone' => '5',
            'BestDone' => '6');
        return $rsopSynchModeTypeValues;
    }

    private static function MapDebugLwsValueToApi($lwsDebugAttributeName,
                                                  $lwsAttributeValue,
                                                  $lwsDebugAttributeNameConst,
                                                  $apiAuditNameConst,
                                                  $apiDetailNameConst)
    {
        $mappedNameValue = Array();

        if ($lwsDebugAttributeName === $lwsDebugAttributeNameConst) {
            if ($lwsAttributeValue === self::LWS_AUDIT)
            {
                $mappedNameValue[$apiAuditNameConst] = self::API_TRUE;
                $mappedNameValue[$apiDetailNameConst] = self::API_FALSE;
            }
            elseif ($lwsAttributeValue === self::LWS_DETAILED)
            {
                $mappedNameValue[$apiDetailNameConst] = self::API_TRUE;
                $mappedNameValue[$apiAuditNameConst] = self::API_FALSE;
            }
            elseif ($lwsAttributeValue === self::LWS_OFF)
            {
                $mappedNameValue[$apiAuditNameConst] = self::API_FALSE;
                $mappedNameValue[$apiDetailNameConst] = self::API_FALSE;
            }
        }
        return $mappedNameValue;
    }


}