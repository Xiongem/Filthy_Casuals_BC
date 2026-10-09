<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('log_errors', 'On');
ini_set('error_log', '/path/to/php_errors.log');

ob_start();
require($_SERVER['DOCUMENT_ROOT'] . '/php/utilities.php');
dbConnect();

function modMath1($pages, $mod1) {
    if ($mod1 == 1) {
        // Normal: 1 point per page
        $pagesMod1 = $pages * 1;
        return $pagesMod1;
    } elseif ($mod1 == 2) {
        //Manga/Comics: 50% per page
        $pagesMod1 = $pages * 0.5;
        return $pagesMod1;
    } elseif ($mod1 == 3) {
        //Challenge: 110% points per page
        $pagesMod1 = $pages * 1.10;
        return $pagesMod1;
    } elseif ($mod1 == 4) {
        //Challenge: Manga/Comics: 60% points per page
        $pagesMod1 = $pages * 0.60;
        return $pagesMod1;
    } elseif ($mod1 == 5) {
        //Buddy Read: 125% points per page
        $pagesMod1 = $pages * 1.25;
        return $pagesMod1;
    } elseif ($mod1 == 6) {
        //Friend Recommendation: 125% points per page
        $pagesMod1 = $pages * 1.25;
        return $pagesMod1;
    } elseif ($mod1 == 7) {
        //Seasonal: 125% points per page
        $pagesMod1 = $pages * 1.25;
        return $pagesMod1;
    } elseif ($mod1 == 8) {
        //Read-a-thon: 125% points per page
        $pagesMod1 = $pages * 1.25;
        return $pagesMod1;
    } elseif ($mod1 == 9) {
        //Education: 300% points per page
        $pagesMod1 = $pages * 3;
        return $pagesMod1;
    }  elseif ($mod1 == 10) {
        //Education: Manga/Comics: 150% points per page
        $pagesMod1 = $pages * 1.5;
        return $pagesMod1;
    } else {
        $pagesMod1 = $pages;
        return $pagesMod1;
    }
}

function modMath2($pagesMod1, $mod2) {
    if ($mod2 == 1) {
        // Normal: no extra points
        $pagesMod2 = $pagesMod1 * 0;
        return $pagesMod2;
    } elseif ($mod2 == 2) {
        //Challenge: extra 10%
        $pagesMod2 = $pagesMod1 * 0.10;
        return $pagesMod2;
    } elseif ($mod2 == 3) {
        //Buddy Read: extra 25%
        $pagesMod2 = $pagesMod1 * 0.25;
        return $pagesMod2;
    } elseif ($mod2 == 4) {
        //Friend Recommendation: extra 25%
        $pagesMod2 = $pagesMod1 * 0.25;
        return $pagesMod2;
    } elseif ($mod2 == 5) {
        //Seasonal: extra 25%
        $pagesMod2 = $pagesMod1 * 0.25;
        return $pagesMod2;
    } elseif ($mod2 == 6) {
        //Read-a-thon: extra 25%
        $pagesMod2 = $pagesMod1 * 0.25;
        return $pagesMod2;
    } elseif ($mod2 == 7) {
        //Education: extra 200%
        $pagesMod2 = $pagesMod1 * 2;
        return $pagesMod2;
    }  elseif ($mod2 == 8) {
        //Education: Manga/Comics: extra 100%
        $pagesMod2 = $pagesMod1 * 1;
        return $pagesMod2;
    } else {
        $pagesMod2 = $pagesMod1;
        return $pagesMod2;
    }
}

function calculateTotalPoints($pages, $mod1, $mod2) {
    $pointsMod1 = modMath1($pages, $mod1);
    $pointsMod2 = modMath2($pointsMod1, $mod2);
    $totalPoints = $pointsMod1 + $pointsMod2;
    return round($totalPoints);
}