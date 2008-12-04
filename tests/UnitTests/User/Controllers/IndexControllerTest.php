<?php
/**
 * Unit test
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
 * @copyright  Copyright (c) 2007 Mayflower GmbH (http://www.mayflower.de)
 * @license    LGPL 2.1 (See LICENSE file)
 * @version    CVS: $Id:
 * @link       http://www.phprojekt.com
 * @since      File available since Release 1.0
 */
require_once 'PHPUnit/Framework.php';

/**
 * Tests for Index Controller
 *
 * @copyright  Copyright (c) 2007 Mayflower GmbH (http://www.mayflower.de)
 * @license    LGPL 2.1 (See LICENSE file)
 * @version    Release: @package_version@
 * @link       http://www.phprojekt.com
 * @since      File available since Release 1.0
 * @author     Gustavo Solt <solt@mayflower.de>
 */
class User_IndexController_Test extends FrontInit
{
    /**
     * Test the user list
     */
    public function testGetUsersAction()
    {
        $this->request->setParams(array('action' => 'jsonList', 'controller' => 'index', 'module' => 'user'));
        $this->request->setBaseUrl($this->config->webpath . 'index.php/Core/user/jsonGetUsers');
        $this->request->setPathInfo('/Core/user/jsonGetUsers');
        $this->request->setRequestUri('/Core/user/jsonGetUsers');
        $response = $this->getResponse();
        $this->assertTrue(strpos(strtolower($response), strtolower('"numRows":1')) > 0);
    }
}
