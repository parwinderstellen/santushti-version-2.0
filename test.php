<?php
require 'app/Mage.php';
    $mail = Mage::getModel('core/email');
    $mail->setToName("Gurname Singh");
    $mail->setToEmail("gurnamesingh@gmail.com");
    $mail->setBody("This is for testing");
    $mail->setSubject("Testing");
    $mail->setFromEmail("test@gmail.com");
    $mail->setFromName("Testing");
    $mail->setType("html");// YOu can use Html or text as Mail format
     
    try {
    $mail->send();
    Mage::getSingleton("core/session")->addSuccess("Your request has been sent");
    //$this->_redirect();
    }
    catch (Exception $e) {
    Mage::getSingleton("core/session")->addError("Unable to send.");
  // $this->_redirect(”);
    }
?> 
