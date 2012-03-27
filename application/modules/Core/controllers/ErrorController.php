<?php

/*
 * Copyright (c) 2011 Matthew Doll <mdoll at homenet.me>.
 *
 * This file is part of HomeNet.
 *
 * HomeNet is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * HomeNet is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with HomeNet.  If not, see <http://www.gnu.org/licenses/>.
 */

/**
 * @package Core
 * @subpackage Error
 * @copyright Copyright (c) 2011 Matthew Doll <mdoll at homenet.me>.
 * @license http://www.gnu.org/licenses/gpl-3.0.html GNU/GPLv3
 */
class ErrorController extends Zend_Controller_Action {

    public function notFoundAction(){
        $message = $this->_getParam('error_message');

        $this->view->message = 'Unknown Error';
        if (!empty($message)) {
            $this->view->message = $message;
        }
        
        $this->getResponse()->setHttpResponseCode(404);
        $this->view->title = '404 Page not found';
    }
    
    public function errorAction() {
        if(APPLICATION_ENV == 'testing'){
            die(debugArray($this->_getParam('error_handler')));
        }
        $errors = $this->_getParam('error_handler');

        if (!$errors) {
            $this->view->message = 'You have reached the error page';
            return;
        }

        $code = $errors->exception->getCode();

        switch ($errors->type) {
            case Zend_Controller_Plugin_ErrorHandler::EXCEPTION_NO_ROUTE:
            case Zend_Controller_Plugin_ErrorHandler::EXCEPTION_NO_CONTROLLER:
            case Zend_Controller_Plugin_ErrorHandler::EXCEPTION_NO_ACTION:
                // 404 error -- controller or action not found
                $code = 404;
                break;
            default:
                // application error
                //$code = 500;
                break;
        }



        switch ($code) {
            case 404:
                // 404 error -- controller or action not found
                $this->getResponse()->setHttpResponseCode(404);
                $this->view->message = '404 Page not found';
                break;
            default:
                $code = 500;
                // application error
                $this->getResponse()->setHttpResponseCode(500);
                $this->view->message = '500 Application error';
                break;
        }


        // Log exception, if logger available
        if ($log = $this->getLog()) {
            $log->crit($this->view->message, $errors->exception);
        }

        // conditionally display exceptions
        // if ($this->getInvokeArg('displayExceptions') == true) {
        $this->view->exception = $errors->exception;
        //  }

        $this->view->request = $errors->request;
    }

    public function getLog() {
        $bootstrap = $this->getInvokeArg('bootstrap');
        if (!$bootstrap->hasResource('Log')) {
            return false;
        }
        $log = $bootstrap->getResource('Log');
        return $log;
    }

    public function noauthAction() {
        // action body
    }

}

