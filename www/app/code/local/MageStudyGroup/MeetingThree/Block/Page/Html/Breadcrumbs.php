<?php
/**
 * @category	MageStudyGroup
 * @package		MageStudyGroup_MeetingThree
 */

class MageStudyGroup_MeetingThree_Block_Page_Html_Breadcrumbs extends Mage_Page_Block_Html_Breadcrumbs
{

	/**
	 * Rewrite the breadcrumbs block and add a hardcoded crumb at the beginning
	 * without modifying the template. Note: Do not use the _toHtml() method
	 * to implement this customization
	 */
	public function _prepareLayout()
	{
		$this->addCrumb('crumb-one', array(
			'label' => 'Crumb One',
			'title' => 'The home page.',
			'link' => Mage::getUrl()
		));
		return parent::_prepareLayout();
	}
}