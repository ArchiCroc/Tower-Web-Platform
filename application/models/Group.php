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
 * @subpackage Group
 * @copyright Copyright (c) 2011 Matthew Doll <mdoll at homenet.me>.
 * @license http://www.gnu.org/licenses/gpl-3.0.html GNU/GPLv3
 */
class Core_Model_Group implements Core_Model_Group_Interface {
/**
 * id 	int(10) 		UNSIGNED 	No 		auto_increment 	Browse distinct values 	Change 	Drop 	Primary 	Unique 	Index 	Fulltext
	parent 	int(10) 		UNSIGNED 	Yes 	NULL 		Browse distinct values 	Change 	Drop 	Primary 	Unique 	Index 	Fulltext
	status 	tinyint(4) 			No 			Browse distinct values 	Change 	Drop 	Primary 	Unique 	Index 	Fulltext
	name 	varchar(64) 	utf8_general_ci 		No 			Browse distinct values 	Change 	Drop 	Primary 	Unique 	Index 	Fulltext
	description 	tinytext 	utf8_general_ci 		No 			Browse distinct values 	Change 	Drop 	Primary 	Unique 	Index 	Fulltext
	user_count 	int(11)
 */
    /**
     * @var int
     */
    public $id;
    /**
     * @var int
     */
    public $parent = null;
    /**
     * @var int
     */
    public $type = -1;
    /**
     * @var string
     */
    public $title;
    /**
     * @var string
     */
    public $description = null;
    
    /**
     * @var bool
     */
    public $visible = true;
    /**
     * @var int
     */
    public $user_count = 0;
    
    /**
     * @var array
     */
    public $settings = array();
    
    public function __construct(array $config = array()) {
        if (isset($config['data'])) {
            $this->fromArray($config['data']);
        }
    }

    public function fromArray(array $array) {

        $vars = get_object_vars($this);

        // die(debugArray($vars));

        foreach ($array as $key => $value) {
            if (array_key_exists($key, $vars)) {
                $this->$key = $value;
            }
        }
    }

    /**
     * @return array
     */
    public function toArray() {

        return get_object_vars($this);
    }
    public function getSetting($setting){
        if(isset($this->settings[$setting])){
            return $this->settings[$setting];
        }
        return null;
    }

    public function setSetting($setting, $value){
        if(is_null($this->settings)){
            $this->settings = array($setting => $value);
            return;
        }
        //die(debugArray($this->settings));

        $this->settings = array_merge($this->settings,array($setting => $value));
    }

    public function clearSetting($setting){
        unset($this->settings[$setting]);
    }

}