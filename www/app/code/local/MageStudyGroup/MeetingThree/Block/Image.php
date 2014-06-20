<?php
/**
 * @category	MageStudyGroup
 * @package		MageStudyGroup_MeetingThree
 */

class MageStudyGroup_MeetingThree_Block_Image extends Mage_Core_Block_Abstract
	implements Mage_Widget_Block_Interface
{
	protected function _toHtml()
	{
		return '<h1>Oh boy, my very own widget.</h1>';
	}
}