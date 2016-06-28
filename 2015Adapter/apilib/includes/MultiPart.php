<?php
namespace RusticiSoftware\ScormContentPlayer\api\model;
{
	
	class multiPart
	{
		private $fileName;
		private $filePath;

		public function getFileName()
		{
			return $this->fileName;
		}

		public function getFilePath()
		{
			return $this->filePath;
		}

		public function getFilePathAndName()
		{
			return $this->filePath . "/" . $this->fileName;
		}

		public function closeFile()
		{
			if(!empty($this->fileHandler))
				fclose($this->fileHandler);
		}

		public function readWholeFile()
		{
			$handle = fopen($this->getFilePathAndName(), "rb");
			$contents = fread($handle, filesize($this->getFilePathAndName()));
			fclose($handle);		
			return $contents;
		}

		public function __construct($filePath, $fileName)
		{
			$this->filePath = $filePath;
			$this->fileName = $fileName;
		}

		public function __destruct()
		{
			$this->closeFile();	
		}
    }
}
?>