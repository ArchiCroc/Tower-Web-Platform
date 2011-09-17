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
 * @subpackage Menu
 * @copyright Copyright (c) 2011 Matthew Doll <mdoll at homenet.me>.
 * @license http://www.gnu.org/licenses/gpl-3.0.html GNU/GPLv3
 */
class Core_Model_Menu_Service {
    
    /**
     * @var Core_Model_Menu_MapperInterface
     */
    protected $_mapper;

    /**
     * @return Core_Model_Menu_MapperInterface
     */
    public function getMapper() {

        if (empty($this->_mapper)) {
            $this->_mapper = new Core_Model_Menu_MapperDbTable();
        }

        return $this->_mapper;
    }

    public function setMapper(Core_Model_Menu_MapperInterface $mapper) {
        $this->_mapper = $mapper;
    }
    /**
     * @param int $id
     * @return Core_Model_Menu_Interface 
     */
    public function getObjectById($id){
        $menu = $this->getMapper()->fetchObjectById($id);

        if (empty($menu)) {
            throw new Exception('Menu Not Found', 404);
        }
        return $menu;
    }

  /**
    * @param mixed $menu
    * @throws InvalidArgumentException 
    */
    public function create($menu) {
        if ($menu instanceof Core_Model_Menu_Interface) {
            $h = $menu;
        } elseif (is_array($menu)) {
            $h = new Core_Model_Menu(array('data' => $menu));
        } else {
            throw new InvalidArgumentException('Invalid Menu');
        }

        return $this->getMapper()->save($h);
    }

  /**
    * @param mixed $menu
    * @throws InvalidArgumentException 
    */
    public function update($menu) {
        if ($menu instanceof Core_Model_Menu_Interface) {
            $h = $menu;
        } elseif (is_array($menu)) {
            $h = new Core_Model_Menu(array('data' => $menu));
        } else {
            throw new InvalidArgumentException('Invalid Menu');
        }
        
        return $this->getMapper()->save($h);
    }
  /**
    * @param mixed $menu
    * @throws InvalidArgumentException 
    */
    public function delete($menu) {
        if (is_int($menu)) {
            $h = new Core_Model_Menu();
            $h->id = $menu;
        } elseif ($menu instanceof Core_Model_Menu_Interface) {
            $h = $menu;
        } elseif (is_array($menu)) {
            $h = new Core_Model_Menu(array('data' => $menu));
        } else {
            throw new InvalidArgumentException('Invalid Menu');
        }

        return $this->getMapper()->delete($h);
    }
}