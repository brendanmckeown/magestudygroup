<?php
/**
 * @category	MageStudyGroup
 * @package		MageStudyGroup_MeetingTwo
 */

class MageStudyGroup_MeetingTwo_Helper_Payment_Data extends Mage_Payment_Helper_Data
{
	/**
	 * Retrieve all payment methods
	 *
	 * @param mixed $store
	 * @return array
	 */
	public function getPaymentMethods($store = null)
	{
		//Mage::log("MageStudyGroup_MeetingTwo_Helper_Payment_Data");
		return Mage::getStoreConfig(self::XML_PATH_PAYMENT_METHODS, $store);
	}
}