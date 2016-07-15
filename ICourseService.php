<?php
interface ICourseService
{

	public function ImportCourse($courseId, $absoluteFilePathToZip, $itemIdToImport = null);
	public function ImportUploadedCourse($courseId, $path, $permissionDomain = null);
	public function Exists($courseId);
	public function GetCourseList($courseIdFilterRegex = null);
	public function DeleteCourse($courseId, $deleteLatestVersionOnly = False);
	public function DeleteCourseVersion($courseId, $versionId);
	public function GetCourseDetail($courseId);
	public function GetMetadata($courseId, $versionId, $scope, $format);
	public function GetPreviewUrl($courseId, $redirectOnExitUrl, $cssUrl = null);
	public function GetPropertyEditorUrl($courseId, $stylesheetUrl, $notificationFrameUrl);
	public function GetImportCourseUrl($courseId, $redirectUrl);
	public function GetUpdateAssetsUrl($courseId, $redirectUrl);
	public function GetAttributes($courseId, $versionId=Null);
	public function UpdateAttributes($courseId, $versionId, $attributePairs);
	public function UpdateAssetsFromUploadedFile($courseId, $uploadLocation);
}

?>