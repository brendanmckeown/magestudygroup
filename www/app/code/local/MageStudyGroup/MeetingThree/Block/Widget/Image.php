<?php
/**
 * @category	MageStudyGroup
 * @package		MageStudyGroup_MeetingThree
 */

class MageStudyGroup_MeetingThree_Block_Widget_Image extends Mage_Core_Block_Template
	implements Mage_Widget_Block_Interface
{
	protected function _toHtml()
	{
		return $this->getAltText();
	}
}