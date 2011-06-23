<?php

/*
 * ApikeyMapperDbTable.php
 *
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
 * along with HomeNet.  If not, see <http ://www.gnu.org/licenses/>.
 */

require "MapperInterface.php";

/**
 * @package Core
 * @subpackage Group
 * @copyright Copyright (c) 2011 Matthew Doll <mdoll at homenet.me>.
 * @license http://www.gnu.org/licenses/gpl-3.0.html GNU/GPLv3
 */
class Core_Model_Group_Acl_MapperDbTable implements Core_Model_Group_Acl_MapperInterface {

    protected $_table = null;

    /**
     *
     * @return Core_Model_DbTable_Group_Acl;
     */
    public function getTable() {
        if (is_null($this->_table)) {
            $this->_table = new Core_Model_DbTable_GroupAcls();
        }
        return $this->_table;
    }

    public function setTable($table) {
        $this->_table = $table;
    }







    public function fetchObjectById($id){
        return $this->getTable()->find($id)->current();
    }
    
    public function fetchObjectsByGroup($group){
       $select = $this->getTable()->select()->where('group = ?',$group);
      return $this->getTable()->fetchAll($select);
    }

    public function save(Core_Model_Group_Acl_Interface $membership) {

        if (($membership instanceof Core_Model_DbTableRow_GroupAcl) && ($membership->isConnected())) {
            return $membership->save();

        } elseif (!is_null($membership->id)) {
            $row = $this->getTable()->find($membership->id)->current();
            if(empty($row)){
               $row = $this->getTable()->createRow();
            }

        } else {
            $row = $this->getTable()->createRow();
        }

        $row->fromArray($membership->toArray());
       // die(debugArray($row));
        $row->save();

        return $row;
    }

    public function delete(Core_Model_Group_Acl_Interface $membership) {

        if (($membership instanceof Core_Model_DbTableRow_GroupAcl) && ($membership->isConnected())) {
            $membership->delete();
            return true;
        } elseif (!is_null($membership->id)) {
            $row = $this->getTable()->find($membership->id)->current()->delete();
            return;
        }

        throw new Exception('Invalid Group Object');
    }
    
    public function deleteByGroup($group){
         $select = $this->getTable()->select()->where('group = ?',$group);
    }
    
    public function deleteAll(){
        if(APPLICATION_ENV == 'testing'){
            $this->getTable()->getAdapter()->query('TRUNCATE TABLE `'. $this->getTable()->info('name').'`');
        }
    }
}