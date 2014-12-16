<?php

/**
* Author: Magegiant.com
*
**/
require 'app/Mage.php';

if (!Mage::isInstalled()) {
    echo "Application is not installed yet, please complete install wizard first.";
    exit;
}


Mage::app()->getCacheInstance()->flush();
echo 'Flushed cache successfully<br>';
