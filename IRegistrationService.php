<?php

/**
 * Created by PhpStorm.
 * User: jason.wisener
 * Date: 6/8/16
 * Time: 12:23 PM
 */
interface IRegistrationService
{
    public function CreateRegistration($registrationId,
                                       $courseId,
                                       $learnerId,
                                       $learnerFirstName,
                                       $learnerLastName,
                                       $email = null,
                                       $authtype = null,
                                       $resultsformat = 'xml',
                                       $resultsPostbackUrl = null,
                                       $postBackLoginName = null,
                                       $postBackLoginPassword = null,
                                       $versionId = null);

    public function Exists($registrationId);

    public function GetRegistrationResult($registrationId, $resultsFormat, $dataFormat);

    public function GetRegistrationResultUrl($registrationId, $resultsFormat, $dataFormat);

    public function GetRegistrationSummary($registrationId);

    public function GetRegistrationList($courseId, $learnerId);

    public function GetRegistrationDetail($registrationId);

    public function GetRegistrationListResults($courseId, $learnerId, $resultsFormat);

    public function DeleteRegistration($registrationId, $deleteLatestInstanceOnly = False);

    public function ResetRegistration($registrationId);

    public function ResetGlobalObjectives($registrationId, $deleteLatestInstanceOnly = true);

    public function DeleteRegistrationInstance($registrationId, $instanceId);

    public function GetLaunchUrl($registrationId, $redirectOnExitUrl = null, $cssUrl = null, $debugLogPointerUrl = null, $courseTags = null, $learnerTags = null, $registrationTags = null);

    public function GetLaunchHistory($registrationId);

    public function GetLaunchInfo($launchId);

    public function UpdateLearnerInfo($learnerid, $fname, $lname, $newid = null);
}