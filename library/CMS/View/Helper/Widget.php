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
 * @package CMS
 * @subpackage View
 * @copyright Copyright (c) 2011 Matthew Doll <mdoll at homenet.me>.
 * @license http://www.gnu.org/licenses/gpl-3.0.html GNU/GPLv3
 */
class CMS_View_Helper_Widget extends Zend_View_Helper_Abstract
{
	/**
	 * Render a Color Picker in an FormText field.
	 *
	 * @link   http://docs.jquery.com/UI/ColorPicker
	 * @param  string $id
	 * @param  string $value
	 * @param  array  $params
	 * @param  array  $attribs
	 * @return string
	 */
    public function widget($module,$widgetName, $options = array())
    {
        $class = ucfirst($module).'_Plugin_Widget_'.ucfirst($widgetName).'_Widget';
        if(!class_exists($class,true)){
            throw new Exception('Widget Not Found: '.$class);
        }
        $object = new $class(array('view'=>$this->view,'options'=>$options));
        return $object->render();
    }
    
    
    
    
}