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
class Core_Model_User_Service {

    /**
     * @var Core_Model_User_MapperInterface
     */
    protected $_mapper;

    /**
     * @return Core_Model_User_MapperInterface
     */
    public function getMapper() {

        if (empty($this->_mapper)) {
            $this->_mapper = new Core_Model_User_MapperDbTable();
        }

        return $this->_mapper;
    }

    /**
     * @param Content_Model_Section_MapperInterface $mapper 
     */
    public function setMapper(Core_Model_User_MapperInterface $mapper) {
        $this->_mapper = $mapper;
    }

     /**
     * @return int number of items in table
     */
    public function getCount() {
        $result = $this->getMapper()->fetchCount();
        return $result;
    }
 
    /**
     * @return Core_Model_User[]
     */
    public function getObjects() {
        $result = $this->getMapper()->fetchObjects();
        return $result;
    }
    
    /**
     * @param int $id
     * @return Core_Model_User_Interface
     * @throws NotFoundException
     */
    public function getObjectById($id) {
        $result = $this->getMapper()->fetchObjectById($id);
        if (empty($result)) {
            throw new NotFoundException('Id: '.$id.' Not Found', 404);
        }
        return $result;
    }

    /**
     * @param int $group
     * @return Core_Model_User_Interface[] 
     */
    public function getObjectsByPrimaryGroup($group) {
        $results = $this->getMapper()->fetchObjectsByPrimaryGroup($group);
        return $results;
    }

    /**
     * @param Core_Model_User_Interface|array $mixed
     * @return Core_Model_User
     * @throws InvalidArgumentException 
     */
    public function create($user) {

        if ($user instanceof Core_Model_User_Interface) {
            $h = $user;
        } elseif (is_array($user)) {
            $h = new Core_Model_User(array('data' => $user));
        } else {
            throw new InvalidArgumentException('Invalid Object');
        }

        $gService = new Core_Model_Group_Service();

        try {
            $group = $gService->getObjectById($h->primary_group);
        } catch (NotFoundException $e) {
            throw new InvalidArgumentException('Invalid Primary Group');
        }

        $user = $this->getMapper()->save($h);
        $mService = new Core_Model_User_Membership_Service();
        $result = $mService->create(array(
            'user' => $user->id,
            'group' => $user->primary_group));

        return $user;
    }

    /**
     * @param Core_Model_User_Interface|array $mixed
     * @return Core_Model_User
     * @throws InvalidArgumentException 
     */
    public function update($user) {
        if ($user instanceof Core_Model_User_Interface) {
            $h = $user;
        } elseif (is_array($user)) {
            $h = new Core_Model_User(array('data' => $user));
        } else {
            throw new InvalidArgumentException('Invalid Object');
        }

        return $this->getMapper()->save($h);
    }

    /**
     * @param Core_Model_User_Interface|array|int $mixed
     * @return boolean Success
     * @throws InvalidArgumentException 
     */
    public function delete($user) {
        if (is_int($user)) {
            $h = new Core_Model_User();
            $h->id = $user;
        } elseif ($user instanceof Core_Model_User_Interface) {
            $h = $user;
        } elseif (is_array($user)) {
            $h = new Core_Model_User(array('data' => $user));
        } else {
            throw new InvalidArgumentException('Invalid Object');
        }

        return $this->getMapper()->delete($h);
    }

    /**
     * Delete all data. Used for unit testing/Will not work in production 
     *
     * @return boolean Success
     * @throws NotAllowedException
     */
    public function deleteAll() {
        if (APPLICATION_ENV == 'production') {
            throw new Exception("Not Allowed");
        }
        return $this->getMapper()->deleteAll();
    }

}