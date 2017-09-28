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


class AsyncImportResult {
    private $_status = "";
    private $_message = "";
    private $_progress = 0;
    private $_xml;

    private $_importResults = array();

    function __construct($xmlDoc) {
        $xml = simplexml_load_string($xmlDoc);

        $this->_status = $xml->status;

        if (isset($xml->message)) {
            $this->_message = $xml->message;
        }

        if (isset($xml->progress)) {
            $this->_progress = $xml->progress;
        }

        if (isset($xml->importresult)) {
            $importResults = $xml->importresult;
            foreach ($importResults as $result) {
                $this->_importResults[] = new ImportResult($result);
            }
        }

        $this->_xml = $xml;
    }

    // Can be created/running/finished/error
    public function getStatus() {
        return $this->_status;
    }

    // A user-readable message describing current import step
    public function getMessage() {
        return $this->_message;
    }

    // (Optional) a list of import results
    public function getImportResults() {
        return $this->_importResults;
    }

    // (Optional) The progress of the import 0 - 100
    public function getProgress() {
        return $this->_progress;
    }

    // Get the xml doc for the response
    public function getXml() {
        return $this->_xml;
    }
}

?>
