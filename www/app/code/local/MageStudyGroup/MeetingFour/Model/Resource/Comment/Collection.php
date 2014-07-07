<?php
/**
 * Create a comments entity model, flat table resource model, and a matching resource collection model.
 *
 * @package    MageStudyGroup
 * @module     MageStudyGroup_MeetingFour
 */

class MageStudyGroup_MeetingFour_Model_Resource_Comment_Collection extends Mage_Core_Model_Resource_Db_Collection_Abstract
{
	protected function _construct()
	{
		$this->_init("magestudygroup_meetingfour/comment");
	}
}
