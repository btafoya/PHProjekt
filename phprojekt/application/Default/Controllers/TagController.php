<?php
/**
 * Tag Controller for PHProjekt 6
 *
 * This software is free software; you can redistribute it and/or
 * modify it under the terms of the GNU Lesser General Public
 * License version 2.1 as published by the Free Software Foundation
 *
 * This library is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU
 * Lesser General Public License for more details.
 *
 * @copyright  Copyright (c) 2008 Mayflower GmbH (http://www.mayflower.de)
 * @license    LGPL 2.1 (See LICENSE file)
 * @version    $Id$
 * @author     David Soria Parra <soria_parra@mayflower.de>
 * @package    PHProjekt
 * @link       http://www.phprojekt.com
 * @since      File available since Release 6.0
 */

/**
 * Tag Controller for PHProjekt 6
 *
 * The controller will get all the actions for manage tags
 *
 * @copyright  Copyright (c) 2008 Mayflower GmbH (http://www.mayflower.de)
 * @version    Release: @package_version@
 * @license    LGPL 2.1 (See LICENSE file)
 * @package    PHProjekt
 * @subpackage Default
 * @link       http://www.phprojekt.com
 * @since      File available since Release 6.0
 * @author     David Soria Parra <soria_parra@mayflower.de>
 */
class TagController extends IndexController
{
    /**
     * Get an array with tags
     * order by number of ocurrences
     *
     * @requestparam integer $limit Limit the number of tags for return
     *
     * @return void
     */
    public function jsonGetTagsAction()
    {
        $tagObj = Phprojekt_Tags::getInstance();
        $limit  = (int) $this->getRequest()->getParam('limit', 0);
        $tags   = $tagObj->getTags($limit);
        $fields = $tagObj->getFieldDefinition();

        Phprojekt_Converter_Json::echoConvert($tags, $fields);
    }

    /**
     * Get an array with tags for the $module and $id
     * order by number of ocurrences
     *
     * @requestparam integer $id        Item id
     * @requestparam integer $limit      Limit the number of tags for return
     * @requestparam string  $moduleName Module name
     *
     * @return void
     */
    public function jsonGetTagsByModuleAction()
    {
        $tagObj = Phprojekt_Tags::getInstance();

        $id        = (int) $this->getRequest()->getParam('id', 0);
        $limit     = (int) $this->getRequest()->getParam('limit', 0);
        $module    = Cleaner::sanitize('alnum', $this->getRequest()->getParam('moduleName', 'Project'));
        $moduleId  = (int) Phprojekt_Module::getId($module);

        if (!empty($id)) {
            $tags = $tagObj->getTagsByModule($moduleId, $id, $limit);
        } else {
            $tags = array();
        }
        $fields = $tagObj->getFieldDefinition();

        Phprojekt_Converter_Json::echoConvert($tags, $fields);
    }

    /**
     * Get an array with all the modules with a tag
     *
     * @requestparam string  $tag   Tag to search
     * @requestparam integer $limit Limit the number of tags for return
     *
     * @return void
     */
    public function jsonGetModulesByTagAction()
    {
        $tagObj = Phprojekt_Tags::getInstance();
        $tag    = (string) $this->getRequest()->getParam('tag', '');
        $limit  = (int) $this->getRequest()->getParam('limit', 0);
        $tags   = $tagObj->getModulesByTag($tag, $limit);

        Phprojekt_Converter_Json::echoConvert($tags);
    }

    /**
     * Saves the tags for the current item
     *
     * @requestparam integer $id         Item id
     * @requestparam string  $string     All the tags separated by space
     * @requestparam string  $moduleName Module name
     *
     * @return void
     */
    public function jsonSaveTagsAction()
    {
        $tagObj = Phprojekt_Tags::getInstance();
        $id     = (int) $this->getRequest()->getParam('id');
        $string = (string) $this->getRequest()->getParam('string', '');

        if (empty($id)) {
            throw new Phprojekt_PublishedException(self::ID_REQUIRED_TEXT);
        }

        $module   = Cleaner::sanitize('alnum', $this->getRequest()->getParam('moduleName', 'Project'));
        $moduleId = (int) Phprojekt_Module::getId($module);

        $tagObj->saveTags($moduleId, $id, $string);

        $message = Phprojekt::getInstance()->translate('The Tags were added correctly');

        $return = array('type'    => 'success',
                        'message' => $message,
                        'code'    => 0,
                        'id'      => 0);

        Phprojekt_Converter_Json::echoConvert($return);
    }

    /**
     * Delete the tags for one item
     *
     * @requestparam integer $id         Item id
     * @requestparam string  $string     All the tags separated by space
     * @requestparam string  $moduleName Module name
     *
     * @return void
     */
    public function jsonDeleteTagsAction()
    {
        $tagObj = Phprojekt_Tags::getInstance();
        $id     = (int) $this->getRequest()->getParam('id');

        if (empty($id)) {
            throw new Phprojekt_PublishedException(self::ID_REQUIRED_TEXT);
        }

        $module   = Cleaner::sanitize('alnum', $this->getRequest()->getParam('moduleName', 'Project'));
        $moduleId = (int) Phprojekt_Module::getId($module);

        $tagObj->deleteTagsByItem($moduleId, $id);

        $message = Phprojekt::getInstance()->translate('The Tags were deleted correctly');

        $return = array('type'    => 'success',
                        'message' => $message,
                        'code'    => 0,
                        'id'      => 0);

        Phprojekt_Converter_Json::echoConvert($return);
    }
}
