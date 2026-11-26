<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('log_errors', 'On');
ini_set('error_log', '/path/to/php_errors.log');

ob_start();

function modMath1Out($pagesOut, $mod1Out) {
    if ($mod1Out == 1) {
        // Normal: 1 point per page
        $pagesOutMod1 = $pagesOut * 1;
        return $pagesOutMod1;
    } elseif ($mod1Out == 2) {
        //Manga/Comics: 50% per page
        $pagesOutMod1 = $pagesOut * 0.5;
        return $pagesOutMod1;
    } elseif ($mod1Out == 3) {
        //Challenge: 110% points per page
        $pagesOutMod1 = $pagesOut * 1.10;
        return $pagesOutMod1;
    } elseif ($mod1Out == 4) {
        //Challenge: Manga/Comics: 60% points per page
        $pagesOutMod1 = $pagesOut * 0.60;
        return $pagesOutMod1;
    } elseif ($mod1Out == 5) {
        //Buddy Read: 125% points per page
        $pagesOutMod1 = $pagesOut * 1.25;
        return $pagesOutMod1;
    } elseif ($mod1Out == 6) {
        //Friend Recommendation: 125% points per page
        $pagesOutMod1 = $pagesOut * 1.25;
        return $pagesOutMod1;
    } elseif ($mod1Out == 7) {
        //Seasonal: 125% points per page
        $pagesOutMod1 = $pagesOut * 1.25;
        return $pagesOutMod1;
    } elseif ($mod1Out == 9) {
        //Education: 300% points per page
        $pagesOutMod1 = $pagesOut * 3;
        return $pagesOutMod1;
    }  elseif ($mod1Out == 10) {
        //Education: Manga/Comics: 150% points per page
        $pagesOutMod1 = $pagesOut * 1.5;
        return $pagesOutMod1;
    } else {
        $pagesOutMod1 = $pagesOut;
        return $pagesOutMod1;
    }
}

function modMath2Out($pagesOut, $mod2Out) {
    if ($mod2Out == 1) {
        // Normal: no extra points
        $pagesOutMod2 = $pagesOut * 0;
        return $pagesOutMod2;
    } elseif ($mod2Out == 2) {
        //Challenge: extra 10%
        $pagesOutMod2 = $pagesOut * 0.10;
        return $pagesOutMod2;
    } elseif ($mod2Out == 3) {
        //Buddy Read: extra 25%
        $pagesOutMod2 = $pagesOut * 0.25;
        return $pagesOutMod2;
    } elseif ($mod2Out == 4) {
        //Friend Recommendation: extra 25%
        $pagesOutMod2 = $pagesOut * 0.25;
        return $pagesOutMod2;
    } elseif ($mod2Out == 5) {
        //Seasonal: extra 25%
        $pagesOutMod2 = $pagesOut * 0.25;
        return $pagesOutMod2;
    } elseif ($mod2Out == 7) {
        //Education: extra 200%
        $pagesOutMod2 = $pagesOut * 2;
        return $pagesOutMod2;
    }  elseif ($mod2Out == 8) {
        //Education: Manga/Comics: extra 100%
        $pagesOutMod2 = $pagesOut * 1;
        return $pagesOutMod2;
    } else {
        $pagesOutMod2 = $pagesOut;
        return $pagesOutMod2;
    }
}

function modMath1In($pagesIn) {
    //Read-a-thon: 125% points per page
    $pagesInMod1 = $pagesIn * 1.25;
    return $pagesInMod1;
}

function modMath2In($pagesIn, $mod2In) {
    if ($mod2In == 1) {
        // Normal: no extra points
        $pagesInMod2 = $pagesIn * 0;
        return $pagesInMod2;
    } elseif ($mod2In == 2) {
        //Challenge: extra 10%
        $pagesInMod2 = $pagesIn * 0.10;
        return $pagesInMod2;
    } elseif ($mod2In == 3) {
        //Buddy Read: extra 25%
        $pagesInMod2 = $pagesIn * 0.25;
        return $pagesInMod2;
    } elseif ($mod2In == 4) {
        //Friend Recommendation: extra 25%
        $pagesInMod2 = $pagesIn * 0.25;
        return $pagesInMod2;
    } elseif ($mod2In == 5) {
        //Seasonal: extra 25%
        $pagesInMod2 = $pagesIn * 0.25;
        return $pagesInMod2;
    } elseif ($mod2In == 7) {
        //Education: extra 200%
        $pagesInMod2 = $pagesIn * 2;
        return $pagesInMod2;
    }  elseif ($mod2In == 8) {
        //Education: Manga/Comics: extra 100%
        $pagesInMod2 = $pagesIn * 1;
        return $pagesInMod2;
    } else {
        $pagesInMod2 = $pagesIn;
        return $pagesInMod2;
    }
}

function calculateTotalPoints($pagesOut, $pagesIn, $mod1Out, $mod2Out, $mod2In) {
    $pointsMod1Out = modMath1Out($pagesOut, $mod1Out);
    $pointsMod2Out = modMath2Out($pagesOut, $mod2Out);
    $pointsMod1In = modMath1In($pagesIn);
    $pointsMod2In = modMath2In($pagesIn, $mod2In);
    $totalPoints = $pointsMod1Out + $pointsMod2Out + $pointsMod1In + $pointsMod2In;
    return round($totalPoints);
}