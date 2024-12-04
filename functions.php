<?php

//I really don't know how to check the geofencing is within the range 
//where I got reference from these links:-


//RECTANGLE
//which was given in stack overflow :- https://stackoverflow.com/questions/27928/calculate-distance-between-two-latitude-longitude-points-haversine-formula */


function isWithinRange($userLat, $userLng) {
    return ($userLat >= MIN_LAT && $userLat <= MAX_LAT) && ($userLng >= MIN_LNG && $userLng <= MAX_LNG);
}


//CIRCLE
//reference link :- https://blog.dreamfactory.com/creating-a-geofence-api-using-the-haversine-formula-php-and-dreamfactorys-scripted-api-services

//define('ALLOWED_LAT', 40.6700);
//define('ALLOWED_LNG', 72.4670);
//define('ALLOWED_RADIUS', 89.271);

/*function isWithinRadius($userLat, $userLng, $allowedLat, $allowedLng, $allowedRadius) {

    $earthRadius = 6371000; 

    // Convert degrees to radians
    $latFrom = deg2rad($allowedLat);
    $lngFrom = deg2rad($allowedLng);
    $latTo = deg2rad($userLat);
    $lngTo = deg2rad($userLng);

    // Haversine formula
    $latDelta = $latTo - $latFrom;
    $lngDelta = $lngTo - $lngFrom;
    $angle = 2 * asin(sqrt(pow(sin($latDelta / 2), 2) + cos($latFrom) * cos($latTo) * pow(sin($lngDelta / 2), 2)));
    $distance = $earthRadius * $angle;


    echo "Calculated distance: $distance meters<br>";
    echo "Allowed radius: $allowedRadius meters<br>";

    return $distance <= $allowedRadius;
}


if(isWithinRadius($userLat, $userLng, ALLOWED_LAT, ALLOWED_LNG, ALLOWED_RADIUS)){
    insert the image
}
*/

?>