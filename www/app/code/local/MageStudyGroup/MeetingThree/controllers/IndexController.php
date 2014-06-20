<?php
/**
 * @category	MageStudyGroup
 * @package		MageStudyGroup_MeetingThree
 */

class MageStudyGroup_MeetingThree_IndexController extends Mage_Core_Controller_Front_Action
{

	/**
	 * In a custom action controller, render the contents of a single custom update handle.
	 */
	public function indexAction()
	{
		$this->loadLayout('meeting_three')->renderLayout();
	}
}