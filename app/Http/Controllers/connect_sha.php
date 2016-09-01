       <?php
       //WSDL URl
       $url="http://52.33.102.127:8080/DibsChannelingServicesVerrrr/C2BPaymentValidationAndConfirmationService?wsdl";
       $sc = new SoapClient($url);
       $username="username_provided_by_dibon" // e.g. 7777777
       $key="key_provided_by_dibon" // e.g. qNI29dyUR89Fc4FgtcB3lg==
       $confirmationURL="your_confimation_url";
       // e.g http://xx.xx.xx.xx/wppot/inventories/receivePayments.php
       $shortcode="your_short_code";
       //pass parameters username , key , shortcode, confirmationURL
       $params = array(
       'username' => $username, 
       'key' => $key, 
       'shortcode' => $shortcode, 
       'confirmationURL' => $confirmationURL
       );
       $result = $sc->__soapCall('confirmC2BPayment', array('parameters' => $params));
      $response= $result->ResponseDesc;
      ?>
