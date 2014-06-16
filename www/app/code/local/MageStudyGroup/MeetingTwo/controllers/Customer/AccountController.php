<?php
/**
 * @category	Package
 * @package		Package_Module
 */

require_once 'Mage/Customer/controllers/AccountController.php';

class MageStudyGroup_MeetingTwo_Customer_AccountController extends Mage_Customer_AccountController
{
	/**
	 * Rewrite the `Mage_Customer_AccountController::loginAction()` method
	 * to set a category view of your choice as the `before_auth_url`
	 */
	public function loginAction()
	{
		$category = Mage::getModel('catalog/category')->load(18);
		if ($category && $category->getId()) {
			$this->_getSession()->setBeforeAuthUrl($category->getUrl());
		}
		parent::loginAction();
	}
}