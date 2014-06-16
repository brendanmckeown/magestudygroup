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

	/**
	 * Create a dynamic rewrite of the payment/data helper only
	 * if the version of Magento is older than version 1.4, and
	 * if the ccsave payment option is enabled for the current store.
	 *
	 * http://magento-quickies.alanstorm.com/post/41293158874/programmatically-undo-a-magento-rewrite
	 *
	 * @return void
	 */
	public function dynamicRewriteHelper($observer)
	{
		if (version_compare(Mage::getVersion(), '1.4.0', '<')) {
			if (Mage::getStoreConfigFlag('payment/ccsave/active')) {
				Mage::getConfig()->setNode(
					'global/helpers/payment/rewrite/data',
					'MageStudyGroup_MeetingTwo_Helper_Payment_Data'
				);
			}
		}
	}
}