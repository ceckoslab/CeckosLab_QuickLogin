<?php
/**
 * @author      Tsvetan Stoychev <ceckoslab@gmail.com>
 * @website     http://www.ceckoslab.com
 * @license     http://opensource.org/licenses/osl-3.0.php Open Software Licence 3.0 (OSL-3.0)
 */


class CeckosLab_QuickLogin_Model_Source_AdminUsername
{

    /** @var array */
    protected $_options = array();

    public function toOptionArray($isMultiselect=false)
    {
        if (!$this->_options) {
            $users = Mage::getResourceModel('admin/user_collection')
                ->addFieldToFilter('is_active', array('eq' => 1))
                ->addFieldToSelect(array('username'))
                ->load();

            foreach($users as $user) {
                $this->_options[] = array('value' => $user->getUsername(), 'label' => $user->getUsername());
            }
        }

        $options = $this->_options;
        if(!$isMultiselect){
            array_unshift($options, array('value' =>'', 'label'=> Mage::helper('adminhtml')->__('--Please Select--')));
        }

        return $options;
    }
}
