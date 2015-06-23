<?php
/**
 * @author      Tsvetan Stoychev <ceckoslab@gmail.com>
 * @website     http://www.ceckoslab.com
 * @license     http://opensource.org/licenses/osl-3.0.php Open Software Licence 3.0 (OSL-3.0)
 */

class CeckosLab_QuickLogin_Model_Observer
{

    /**
     * @param Varien_Event_Observer $observer
     * @return $this
     */
    public function adminAutoLogin(Varien_Event_Observer $observer)
    {
        if(!$this->_getHelper()->canAutoLogin()) {
            return $this;
        }

        if (Mage::getSingleton('admin/session')->isLoggedIn()) {
            return $this;
        }

        $user = Mage::getModel('admin/user')->loadByUsername($this->_getHelper()->getAutoLoginUsername());

        if (Mage::getSingleton('adminhtml/url')->useSecretKey()) {
            Mage::getSingleton('adminhtml/url')->renewSecretUrls();
        }

        $session = Mage::getSingleton('admin/session');
        $session->setIsFirstVisit(true);
        $session->setUser($user);
        $session->setAcl(Mage::getResourceModel('admin/acl')->loadAcl());

        Mage::dispatchEvent('admin_session_user_login_success', array('user' => $user));

        if ($session->isLoggedIn()) {
            $this->_getSession()->addWarning(
                $this->_getHelper()->__('You were automatically logged in by the extension CeckosLab_QuickLogin! Please don\'t use CeckosLab_QuickLogin on production environment! It may lead to serious security issues!')
            );

            $redirectUrl = Mage::getSingleton('adminhtml/url')
                ->getUrl(Mage::getModel('admin/user')->getStartupPageUrl(), array('_current' => false));

            header('Location: ' . $redirectUrl);
            exit;
        }
    }

    /**
     * @return CeckosLab_QuickLogin_Helper_Data
     */
    private function _getHelper()
    {
        return Mage::helper('ceckoslab_quicklogin');
    }

    /**
     * Retrieve adminhtml session model object
     *
     * @return Mage_Adminhtml_Model_Session
     */
    protected function _getSession()
    {
        return Mage::getSingleton('adminhtml/session');
    }

}