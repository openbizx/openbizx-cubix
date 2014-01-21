<?php
/**
 * Openbiz Cubi Application Platform
 *
 * LICENSE http://code.google.com/p/openbiz-cubi/wiki/CubiLicense
 *
 * @package   cubi.picture.lib
 * @copyright Copyright (c) 2005-2011, Openbiz Technology LLC
 * @license   http://code.google.com/p/openbiz-cubi/wiki/CubiLicense
 * @link      http://code.google.com/p/openbiz-cubi/
 * @version   $Id: PictureLoadHandler.php 3367 2012-05-31 06:10:21Z rockyswen@gmail.com $
 */

use Openbiz\Openbiz;

include_once (OPENBIZ_APP_MODULE_PATH."/system/lib/ModuleLoadHandler.php");

class PictureLoadHandler implements ModuleLoadHandler
{
    public function beforeLoadingModule($moduelLoader)
    {
    }
    
    public function postLoadingModule($moduelLoader)
    {
    	
    	$roleRec = Openbiz::getObject("system.do.RoleDO")->fetchOne("[name]='Cubi Member'");
    	$roleId = $roleRec['Id'];

    	$actionRec = Openbiz::getObject("system.do.AclActionDO")->fetchOne("[module]='picture' AND [resource]='picture' AND [action]='access'");
    	$actionId = $actionRec["Id"];
    	
    	$aclRecord = array(
    		"role_id" =>  $roleId,
    		"action_id" => $actionId,
    		"access_level" => 1
    	);
    	Openbiz::getObject("system.do.AclRoleActionDO")->insertRecord($aclRecord);
    }
}

