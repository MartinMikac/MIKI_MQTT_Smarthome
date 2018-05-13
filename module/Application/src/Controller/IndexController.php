<?php

/**
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\View\Model\JsonModel;
use Bluerhinos\phpMQTT;

class IndexController extends AbstractActionController {
    
    public $stavySenzoru = array();

    public function indexAction() {
        return new ViewModel();
    }

    /**
     * The "ALERT" action displays the info about currently logged in user.
     */
    public function checkSensorStatusAction() {

        $request = $this->getRequest();
        $query = $request->getQuery();


        $server = "m21.cloudmqtt.com";     // change if necessary
        $port = 14212;                     // change if necessary
        $username = "ozgbbnce";                   // set your username
        $password = "7APK8RexzIGr";                   // set your password
        $client_id = "Miki_007-Home_sokolov"; // make sure this is unique for connecting to sever - you could use uniqid()        



        if ($request->isXmlHttpRequest() || $query->get('showJson') == 1) {



            $mqtt = new phpMQTT($server, $port, $client_id);
            
            $mqtt->debug = true;

            if (!$mqtt->connect(true, NULL, $username, $password)) {
                exit(1);
            }

            $topics['kvetiny/senzor'] = array("qos" => 0, "function" => "procmsg");
            $mqtt->subscribe($topics, 0);
            
            error_log("povedl se subscribe!!!!! ");

            /*
            while ($mqtt->proc()) {
                if (array_count_values($this->stavySenzoru) > 0){
                    
                }
                break;
                
                
            }
            */

            $mqtt->close();

            $jsonData = array();
            $idx = 0;
//
//            foreach ($data as $sampledata) {
            /*
              $temp = array(
                'isAlert' => "true",
                'balkon_1p' => "34,5",
                'cele_jmeno' => "Novák",
                'umisteni' => "Čítárna",
                'telefon' => "723 027 278"
            );
              
             $jsonData[$idx++] = $temp;
             
             */
            
            
            
            $jsonData[$idx++] = $this->stavySenzoru;
//            }
//$view = new JsonModel($alerts);

            $view = new JsonModel($jsonData);
            $view->setTerminal(true);
        } else {
            $view = new ViewModel();
        }
        return $view;
    }

    function procmsg($topic, $msg) {
        echo "Msg Recieved: " . date("r") . "\n";
        echo "Topic: {$topic}\n\n";
        echo "\t$msg\n\n";
        
        error_log("procmsg!!!!! ");
        error_log($topic);
        error_log($msg);
        
    }

}
