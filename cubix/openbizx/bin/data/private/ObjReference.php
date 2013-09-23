<?php
/**
 * PHPOpenBiz Framework
 *
 * LICENSE
 *
 * This source file is subject to the BSD license that is bundled
 * with this package in the file LICENSE.txt.
 *
 * @package   openbiz.bin.data.private
 * @copyright Copyright (c) 2005-2011, Rocky Swen
 * @license   http://www.opensource.org/licenses/bsd-license.php
 * @link      http://www.phpopenbiz.org/
 * @version   $Id: ObjReference.php 3858 2011-04-23 01:14:49Z jixian2003 $
 */


/**
 * ObjReference class defines the object reference of a BizDataObj
 *
 * @package openbiz.bin.data.private
 * @author Rocky Swen
 * @copyright Copyright (c) 2005-2009
 */
class ObjReference extends MetaObject
{
    public $m_Relationship;
    /**
     * Table name
     *
     * @var string
     */
    public $m_Table;
    /**
     * Column name
     *
     * @var string
     */
    public $column;
    public $column2;
    /**
     * Field name for reference
     *
     * @var string
     */
    public $m_FieldRef;
    public $m_FieldRef2;
    public $m_XTable;
    public $m_XColumn1;
    public $m_XColumn2;
    public $m_XKeyColumn;   // may not be used any more due to XDataObj
    public $m_XDataObj;
    /**
     * Is cascade action
     *
     * @var boolean
     */
    public $cascadeDelete=false;
    public $m_OnDelete;
    public $m_OnUpdate;
    
    public $condField;
    public $condValue;
    public $condition;
    //public $association;

    /**
     * Initialize ObjReference with xml array
     *
     * @param array $xmlArr
     * @param BizDataObj $bizObj
     * @return void
     */
    function __construct(&$xmlArr, $bizObj)
    {
        $this->objectName = isset($xmlArr["ATTRIBUTES"]["NAME"]) ? $xmlArr["ATTRIBUTES"]["NAME"] : null;
        $this->m_Package = $bizObj->m_Package;
        $this->objectDescription= isset($xmlArr["ATTRIBUTES"]["DESCRIPTION"]) ? $xmlArr["ATTRIBUTES"]["DESCRIPTION"] : null;
        $this->m_Relationship = isset($xmlArr["ATTRIBUTES"]["RELATIONSHIP"]) ? $xmlArr["ATTRIBUTES"]["RELATIONSHIP"] : null;
        $this->m_Table = isset($xmlArr["ATTRIBUTES"]["TABLE"]) ? $xmlArr["ATTRIBUTES"]["TABLE"] : null;
        $this->column = isset($xmlArr["ATTRIBUTES"]["COLUMN"]) ? $xmlArr["ATTRIBUTES"]["COLUMN"] : null;
        $this->m_FieldRef = isset($xmlArr["ATTRIBUTES"]["FIELDREF"]) ? $xmlArr["ATTRIBUTES"]["FIELDREF"] : null;
        $this->column2 = isset($xmlArr["ATTRIBUTES"]["COLUMN2"]) ? $xmlArr["ATTRIBUTES"]["COLUMN2"] : null;
        $this->m_FieldRef2 = isset($xmlArr["ATTRIBUTES"]["FIELDREF2"]) ? $xmlArr["ATTRIBUTES"]["FIELDREF2"] : null;
        $this->cascadeDelete = (isset($xmlArr["ATTRIBUTES"]["CASCADEDELETE"]) && $xmlArr["ATTRIBUTES"]["CASCADEDELETE"] == "Y");
        $this->m_OnDelete = isset($xmlArr["ATTRIBUTES"]["ONDELETE"]) ? $xmlArr["ATTRIBUTES"]["ONDELETE"] : null;
        $this->m_OnUpdate = isset($xmlArr["ATTRIBUTES"]["ONUPDATE"]) ? $xmlArr["ATTRIBUTES"]["ONUPDATE"] : null;
        $this->condColumn = isset($xmlArr["ATTRIBUTES"]["CONDCOLUMN"]) ? $xmlArr["ATTRIBUTES"]["CONDCOLUMN"] : null;
        $this->condValue = isset($xmlArr["ATTRIBUTES"]["CONDVALUE"]) ? $xmlArr["ATTRIBUTES"]["CONDVALUE"] : null;
        $this->condition = isset($xmlArr["ATTRIBUTES"]["CONDITION"]) ? $xmlArr["ATTRIBUTES"]["CONDITION"] : null;
        if ($this->cascadeDelete) $this->m_OnDelete = "Cascade";
        if ($this->m_Relationship == "M-M" || $this->m_Relationship == "Self-Self")
        {
            $this->m_XTable = isset($xmlArr["ATTRIBUTES"]["XTABLE"]) ? $xmlArr["ATTRIBUTES"]["XTABLE"] : null;
            $this->m_XColumn1 = isset($xmlArr["ATTRIBUTES"]["XCOLUMN1"]) ? $xmlArr["ATTRIBUTES"]["XCOLUMN1"] : null;
            $this->m_XColumn2 = isset($xmlArr["ATTRIBUTES"]["XCOLUMN2"]) ? $xmlArr["ATTRIBUTES"]["XCOLUMN2"] : null;
            $this->m_XKeyColumn = isset($xmlArr["ATTRIBUTES"]["XKEYCOLUMN"]) ? $xmlArr["ATTRIBUTES"]["XKEYCOLUMN"] : null;
            $this->m_XDataObj = isset($xmlArr["ATTRIBUTES"]["XDATAOBJ"]) ? $xmlArr["ATTRIBUTES"]["XDATAOBJ"] : null;
            $this->m_XDataObj = $this->prefixPackage($this->m_XDataObj);
        }
        //$this->association = @$xmlArr["ATTRIBUTES"]["ASSOCIATION"];

        $this->objectName = $this->prefixPackage($this->objectName);
    }
}

?>