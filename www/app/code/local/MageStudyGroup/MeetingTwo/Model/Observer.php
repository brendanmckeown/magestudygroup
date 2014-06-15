<?php
/**
 * @category	MageStudyGroup
 * @package		MageStudyGroup_MeetingTwo
 */

class MageStudyGroup_MeetingTwo_Model_Observer extends Mage_Core_Model_Abstract
{
	/**
	 * Create an observer that redirects the visitor to the base URL if the
	 * CMS home page URL key is accessed directly (i.e. /home -> /).
	 *
	 * @return void
	 */
	public function redirectCmsHomeKey($observer)
	{
		$action = $observer->getControllerAction();
		$pathInfo = $action->getRequest()->getPathInfo();
		$homePageUrlKey = Mage::getStoreConfig(Mage_Cms_Helper_Page::XML_PATH_HOME_PAGE);

		if (mb_strstr($pathInfo, $homePageUrlKey) !== false) {
			$action->getResponse()->setRedirect(Mage::getBaseUrl());
            $action->getRequest()->setDispatched(true);
		}
	}
}