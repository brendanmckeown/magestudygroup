<?php
/**
 * Create a frontend form block that allows visitors
 * to add comments to category and product pages.
 *
 * @package	MageStudyGroup
 * @module	MageStudyGroup_MeetingFour
 */

class MageStudyGroup_MeetingFour_Block_Comment_Form extends Mage_Core_Block_Template
{
	public function getFormAction()
	{
		return Mage::getUrl('meetingfour/comment/post');
	}
}