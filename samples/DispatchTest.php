<?php

require_once('config.php');
require_once('../ScormEngineService.php');

$ScormService = new ScormEngineService($CFG->scormcloudurl,$CFG->scormcloudappid,$CFG->scormcloudsecretkey,$CFG->scormcloudorigin);
$dispatchService = $ScormService->getDispatchService();

function printDispatch($disp){
    echo "\nDispatch\n";
    echo "\t id: " . $disp->getId() . "\n";
    echo "\t destinationId: " . $disp->getDestinationId() . "\n";
    echo "\t appId: " . $disp->getAppId() . "\n";
    echo "\t courseAppId: " . $disp->getCourseAppId() . "\n";
    echo "\t courseId: " . $disp->getCourseId() . "\n";
    echo "\t enabled: " . $disp->getEnabled() . "\n";
    echo "\t notes: " . $disp->getNotes() . "\n";
    echo "\t createdBy: " . $disp->getCreatedBy() . "\n";
    echo "\t createDate: " . $disp->getCreateDate() . "\n";
    echo "\t updateDate: " . $disp->getUpdateDate() . "\n";
    echo "\t tags: " . implode(',',$disp->getTags()) . "\n";
}

function printDispatchList($disps){
    foreach($disps as $disp){
        printDispatch($disp);
    }
}

function printDestination($dest){
    echo "\nDestination: " . $dest->getName() . "\n";
    echo "\t id: " . $dest->getId() . "\n";
    echo "\t name: " . $dest->getName() . "\n";
    echo "\t notes: " . $dest->getNotes() . "\n";
    echo "\t createdBy: " . $dest->getCreatedBy() . "\n";
    echo "\t createDate: " . $dest->getCreateDate() . "\n";
    echo "\t updateDate: " . $dest->getUpdateDate() . "\n";
    echo "\t tags: " . implode(',',$dest->getTags()) . "\n";
}

function printDestinationList($dests){
    foreach ($dests as $dest) {
        printDestination($dest);
    }
}


function testDestinationMethods(){
    global $dispatchService;
    $newDestId = null;
    $exception = null;
    
    try{
        //Get rid of our test destination if it's already in there
        $dests = $dispatchService->GetDestinationList(1, array("test"));
        foreach ($dests as $dest) {
            if($dest->getName() == "phplibtest" || $dest->getName() == "phplibtest2"){
                $dispatchService->deleteDestination( $dest->getId() );
            }
        }

        //Create our test destination
        $newDestId = $dispatchService->createDestination( "phplibtest", array("php","test") );

        //Check to make sure it's in our list
        $dests = $dispatchService->GetDestinationList(1, array("test"));
        $found = false;
        foreach ($dests as $dest) {
            if($dest->getName() == "phplibtest"){
                if($dest->getId() != $newDestId){
                    throw new Exception("Expected $newDestId , got " . $dest->getId());
                }
                $found = true;
                break;
            }
        }
        if(!$found){
            throw new Exception("Did not find phplibtest in destination list");
        }

        //Update the info
        $dispatchService->UpdateDestination($newDestId, "phplibtest2", array("php2","test2"));

        //Check all the info
        $dest = $dispatchService->GetDestinationInfo($newDestId);
        if($dest->getId() != $newDestId){
            throw new Exception("Result of get dest info was wrong!");
        }
        if($dest->getName() != "phplibtest2"){
            throw new Exception("Expected phplibtest2, got " . $dest->getName());
        }
        if(!in_array("php2", $dest->getTags()) || !in_array("test2", $dest->getTags())){
            throw new Exception("Tags were not updated properly for new destination");
        }

    } 
    catch (Exception $ex) {
        $exception = $ex;
    }

    //Delete the test destination
    if($newDestId != null){
        try {$dispatchService->DeleteDestination( $newDestId );}
        catch (Exception $ex2) {}
    }

    if($exception != null){
        throw $exception;
    }
}

function testDispatchMethods($testCourseId) {
    global $dispatchService;

    $newDestId = null;
    $exception = null;
    
    try{
        //Get rid of our test destination if it's already in there
        $dests = $dispatchService->GetDestinationList(1, array("test"));
        foreach ($dests as $dest) {
            if($dest->getName() == "phplibtest" || $dest->getName() == "phplibtest2"){
                $dispatchService->deleteDestination( $dest->getId() );
            }
        }

        //Create our test destination
        $newDestId = $dispatchService->createDestination( "phplibtest", array("php","test") );

        //Create our test dispatch
        $newDispatchId = $dispatchService->CreateDispatch($newDestId, $testCourseId, array("php","test"));

        //Find our new test dispatch
        $dispatches = $dispatchService->GetDispatchList(1);
        $found = false;
        foreach ($dispatches as $dispatch) {
            if($dispatch->getId() == $newDispatchId){
                $found = true;
                break;
            }
        }
        if($found == false){
            throw new Exception("Did not find newly created dispatch");
        }

        //Try updating it, using the parent destination id
        $dispatchService->UpdateDispatches($newDestId,null,null,null,0,array("test2"),array("test"));

        //Check some values
        $dispatch = $dispatchService->GetDispatchInfo($newDispatchId);
        printDispatch($dispatch);
        if($dispatch->getEnabled() != "false"){
            throw new Exception("Dispatch did not update (enabled) correctly");
        }
        if(!in_array("test2",$dispatch->getTags())){
            throw new Exception("Dispatch did not update (tagsToAdd) correctly");
        }
        if(in_array("test",$dispatch->getTags())){
            throw new Exception("Dispatch did not update (tagsToRemove) correctly");
        }
    } 
    catch (Exception $ex) {
        $exception = $ex;
    }

    //Delete the test destination (which also deletes child dispatches)
    if($newDestId != null){
        try {$dispatchService->DeleteDestination( $newDestId );}
        catch (Exception $ex2) {}
    }

    if($exception != null){
        throw $exception;
    }
    
}

echo "Running testDestinationMethods...\n";
testDestinationMethods();
echo "Passed!\n";

$testCourseId = "[existing course id here]";
echo "Running testDispatchMethods...\n";
testDispatchMethods($testCourseId);
echo "Passed!\n";

?>
