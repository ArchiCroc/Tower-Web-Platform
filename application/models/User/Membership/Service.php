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
 * @subpackage User
 * @copyright Copyright (c) 2011 Matthew Doll <mdoll at homenet.me>.
 * @license http://www.gnu.org/licenses/gpl-3.0.html GNU/GPLv3
 */
class Core_Model_User_Membership_Service {

    /**
     * @var Core_Model_Content_MapperInterface
     */
    protected $_mapper;

    /**
     * @return Core_Model_Content_MapperInterface
     */
    public function getMapper() {

        if (empty($this->_mapper)) {
            $this->_mapper = new Core_Model_User_Membership_MapperDbTable();
        }

        return $this->_mapper;
    }

    public function setMapper(Core_Model_User_Membership_MapperInterface $mapper) {
        $this->_mapper = $mapper;
    }

    /**
     * @param int $id
     * @return Core_Model_Group_Interface 
     */
    public function getObjectById($id) {
        $content = $this->getMapper()->fetchObjectById($id);

        if (empty($content)) {
            throw new Exception('Content not found', 404);
        }
        return $content;
    }

//    public function getObjectsBySection($section){
//        $contents = $this->getMapper()->fetchObjectsBySection($section);
//
////        if (empty($contents)) {
////            throw new Exception('Apikey not found', 404);
////        }
//        return $contents;
//    }
//    public function getObjectsByIdHouse($id,$house){
//        $apikeys = $this->getMapper()->fetchObjectsByIdHouse($id,$house);
//
//        if (empty($apikeys)) {
//            return array();
//            //throw new Core_Model_Exception('Apikey not found', 404);
//        }
//        return $apikeys;
//    }

    /**
     * @param mixed $membership
     * @throws InvalidArgumentException 
     */
    public function create($membership) {
        if ($membership instanceof Core_Model_User_Membership_Interface) {
            $h = $membership;
        } elseif (is_array($membership)) {
            $h = new Core_Model_User_Membership(array('data' => $membership));
        } else {
            throw new InvalidArgumentException('Invalid Content');
        }

        return $this->getMapper()->save($h);
    }

    /**
     * @param mixed $membership
     * @throws InvalidArgumentException 
     */
    public function update($membership) {
        if ($membership instanceof Core_Model_User_Membership_Interface) {
            $h = $membership;
        } elseif (is_array($membership)) {
            $h = new Core_Model_User_Membership(array('data' => $membership));
        } else {
            throw new InvalidArgumentException('Invalid Content');
        }

        return $this->getMapper()->save($h);
    }

    /**
     * @param mixed $membership
     * @throws InvalidArgumentException 
     */
    public function delete($membership) {
        if (is_int($membership)) {
            $h = new Core_Model_User_Membership();
            $h->id = $membership;
        } elseif ($membership instanceof Core_Model_User_Membership_Interface) {
            $h = $membership;
        } elseif (is_array($membership)) {
            $h = new Core_Model_User_Membership(array('data' => $membership));
        } else {
            throw new InvalidArgumentException('Invalid Content');
        }

        return $this->getMapper()->delete($h);
    }

}