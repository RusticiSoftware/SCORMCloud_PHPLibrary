<?php
namespace RusticiSoftware\Engine\Client
{
    require_once (dirname(__FILE__) . '/JsonMapper.php');

    use RusticiSoftware\Engine\Client as client;
    use RusticiSoftware\ScormContentPlayer\api\model as model;

    class BaseClient
    {

        protected function wrapRequest(IRestRequest $request)
        {
            $request->setFormat(Formats::JSON);
            return $request;
        }

        protected function getResponse(RestClient $client, IRestRequest $request)
        {

            $fullApiEndPoint = $this->getApiEndPoint($client, $request);
            $cred = base64_encode( $client->getAuthenticator()->getUsername() . ':' . $client->getAuthenticator()->getPassword());
            return $this->processResponse($fullApiEndPoint, $request, $cred);
        }

        protected function ConvertJsonToType($data, &$class)
        {
            $mapper = new JsonMapper();
            $class = $mapper->map($data, $class);
        }

        private function processResponse($fullApiEndPoint, $request, $cred)
        {

            //use curl for better control.
            $ch = curl_init($fullApiEndPoint);
            $file = $request->getFile();

            $options = array(
                CURLOPT_RETURNTRANSFER => true,   // return the output
                CURLOPT_HEADER         => false,  // don't return headers
                CURLOPT_FOLLOWLOCATION => true,   // follow redirects
                CURLOPT_MAXREDIRS      => 10,     // stop after 10 redirects
                CURLOPT_ENCODING       => "",     // handle compressed
                CURLOPT_USERAGENT      => "test", // name of client
                CURLOPT_AUTOREFERER    => true,   // set referrer on redirect
                CURLOPT_CONNECTTIMEOUT => 30,     // time-out on connect
                CURLOPT_TIMEOUT        => 500,    // time-out on response
                CURLOPT_CUSTOMREQUEST  => $request->getVerb(), //GET, PUT, POST, DELETE ...
                CURLOPT_POSTFIELDS     => $request->getBody(), //Set the Json.,
                CURLOPT_FAILONERROR    => false,    // rest endpoint should return issues.
                CURLOPT_HTTPHEADER     => array(
                                                    'Expect:',
                                                    'Authorization: Basic ' . $cred,
                                                    'Content-Type: ' . (!is_null($file) ? "multipart/form-data" : "application/" . strtolower($request->getFormat()))
                                               )
            );


            if(!is_null($file))
            {
                $finfo = finfo_open(FILEINFO_MIME_TYPE);
                $mimeType = finfo_file($finfo, $file->getFilePathAndName());
                //setup a curl file.
                $cfile = $this->getCurlValue($file->getFilePathAndName(),$mimeType, $file->getFileName());
                $fileData = array('file' => $cfile);
                $options[CURLOPT_POSTFIELDS] = $fileData;
            }
            curl_setopt_array($ch, $options);


            // set the PHP script's timeout to be greater than CURL's
            set_time_limit(30 + 500 + 5);

            $result = curl_exec($ch);
            $http_status_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);

            // check for errors
            if ($http_status_code == "200") {
                curl_close($ch);
                $data = json_decode($result,false);
                return $data;

            }
            else if($http_status_code == "204" or $http_status_code == "202")
            {
                curl_close($ch);
                return null;
            }
            else
            {
                $this->processMessage($result, $http_status_code);
                curl_close($ch);
            }
        }

        function getCurlValue($filename, $contentType, $postname)
        {
            // PHP 5.5 introduced a CurlFile object that deprecates the old @filename syntax
            // See: https://wiki.php.net/rfc/curl-file-upload
            if (function_exists('curl_file_create')) {
                return curl_file_create($filename, $contentType, $postname);
            }

            // Use the old style if using an older version of PHP
            $value = "@{$filename};filename=" . $postname;
            if ($contentType) {
                $value .= ';type=' . $contentType;
            }

            return $value;
        }

        private function processMessage($response, $responseCode)
        {
            $message = "";
            try
            {
                //var_dump($response);
                $data = json_decode($response,false);
                if(is_array($data))
                {
                    $messageSchema = new model\MessageSchema();
                    $this->ConvertJsonToType($data, $messageSchema);
                    $message = $messageSchema->Message;
                    error_log($message);
                    //var_dump($message);
                }
                else
                {
                    throw new \Exception($responseCode . " -- Failed to parse message response");
                }
            }
            catch (\Exception $e)
            {
                error_log($e->getMessage());
            }
            throw new \Exception($response, $responseCode);
        }


        private function getApiEndPoint(RestClient $client, IRestRequest $request)
        {
            $apiEndPoint = rtrim($client->getBaseUri() ,"/") . "/" . ltrim($request->getUri(),"/");
            return $apiEndPoint;
        }
    }
}
?>