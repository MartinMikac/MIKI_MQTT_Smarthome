<?php

/**
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class IndexController extends AbstractActionController {

    public function indexAction() {
        return new ViewModel();
    }

    
    /**
     * The "ALERT" action displays the info about currently logged in user.
     */
    public function checkSensorStatusAction() {

        $request = $this->getRequest();
        $query = $request->getQuery();

        if ($request->isXmlHttpRequest() || $query->get('showJson') == 1) {


            $jsonData = array();
            $idx = 0;
            //
            //            foreach ($data as $sampledata) {
            $temp = array(
                'isAlert' => "true",
                'cele_jmeno' => "Novák",
                'umisteni' => "Čítárna",
                'telefon' => "723 027 278"
            );
            $jsonData[$idx++] = $temp;
            //            }
            //$view = new JsonModel($alerts);
            
            $view = new JsonModel($jsonData);
            $view->setTerminal(true);
        } else {
            $view = new ViewModel();
        }
        return $view;
    }    

    
}
