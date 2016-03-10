<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

function readFromImageService($objectType, $objectId){
    $url = getenv('IMAGE_SERVICE_URL')."?objectType=$objectType&objectId=".$objectId;
    return $url;
}

function replaceSpaces($string){
	$output = preg_replace('!\s+!', ' ', $string);
	return $output;
}

function createProjectURL($city, $locality, $builderName, $projectName, $projectId) {
    $city = trim(strtolower($city));
    $locality = trim(strtolower($locality));
    $builder = trim(strtolower($builderName));
    $project = trim(strtolower($projectName));
    $projectId = getIdByType($projectId, 'project');
    $projectURL = $city . '/' . $locality . '/' . $builder . '-' . $project . '-' . $projectId;
    $projUrl = preg_replace('/\s+/', '-', $projectURL);
    $makaanProjUrlSTr = $city . "/" . "" . $builder . "-" . $project . "-in-" . $locality . "-" . $projectId;
    $makaanProjUrl = preg_replace('/\s+/', '-', $makaanProjUrlSTr);
    return array($projUrl, $makaanProjUrl);
}

