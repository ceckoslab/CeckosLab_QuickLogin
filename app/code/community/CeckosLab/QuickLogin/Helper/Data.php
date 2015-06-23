<?php
/**
 * @author      Tsvetan Stoychev <ceckoslab@gmail.com>
 * @website     http://www.ceckoslab.com
 * @license     http://opensource.org/licenses/osl-3.0.php Open Software Licence 3.0 (OSL-3.0)
 */

class CeckosLab_QuickLogin_Helper_Data
    extends Mage_Core_Helper_Abstract
{

    const DEFAULT_AUTO_LOGIN_ADMIN_USERNAME_XML_PATH = 'dev/quicklogin/autologin_admin_username';
    const AUTO_LOGIN_ADMIN_ENABLED_XML_PATH          = 'dev/quicklogin/enabled';

    /**
     * @return bool
     */
    public function canAutoLogin()
    {
        $enabled = (bool) Mage::getStoreConfig(self::AUTO_LOGIN_ADMIN_ENABLED_XML_PATH);
        $autologinUsername = Mage::getStoreConfig(self::DEFAULT_AUTO_LOGIN_ADMIN_USERNAME_XML_PATH);

        return ($enabled && !empty($autologinUsername));
    }

    /**
     * @return string
     */
    public function getAutoLoginUsername()
    {
        return Mage::getStoreConfig(self::DEFAULT_AUTO_LOGIN_ADMIN_USERNAME_XML_PATH);
    }

}