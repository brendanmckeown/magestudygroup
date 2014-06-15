<?php
/**
 * @category	MageStudyGroup
 * @package		MageStudyGroup_MeetingTwo
 */

class MageStudyGroup_MeetingTwo_IndexController extends Mage_Core_Controller_Front_Action
{

	/**
	 * Add a new frontend route and create an index controller and an index action that
	 * sets the return value of `$this->getFullActionName()` to the response body
	 *
	 * @return void
	 */
	public function indexAction()
	{
		$this->getResponse()->setBody($this->getFullActionName());
	}
}