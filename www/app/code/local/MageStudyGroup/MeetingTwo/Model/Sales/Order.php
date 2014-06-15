<?php
/**
 * @category	MageStudyGroup
 * @package		MageStudyGroup_MeetingTwo
 */
class MageStudyGroup_MeetingTwo_Model_Sales_Order extends Mage_Sales_Model_Order
{
	/**
	 * Rewrite the sales/order model to add the customer group model as an email template variable
	 * in the `sendNewOrderEmail()` method, so the group code can be added to the email
	 * using `{{var customer_group.getCode()}}`
	 *
	 * @return Mage_Sales_Model_Order
	 * @throws Exception
	 */
	public function sendNewOrderEmail()
	{
		$storeId = $this->getStore()->getId();

		if (!Mage::helper('sales')->canSendNewOrderEmail($storeId)) {
			return $this;
		}

		$emailSentAttributeValue = $this->hasEmailSent()
			? $this->getEmailSent()
			: Mage::getModel('sales/order')->load($this->getId())->getData('email_sent');
		$this->setEmailSent((bool)$emailSentAttributeValue);
		if ($this->getEmailSent()) {
			return $this;
		}

		// Get the destination email addresses to send copies to
		$copyTo = $this->_getEmails(self::XML_PATH_EMAIL_COPY_TO);
		$copyMethod = Mage::getStoreConfig(self::XML_PATH_EMAIL_COPY_METHOD, $storeId);

		// Start store emulation process
		$appEmulation = Mage::getSingleton('core/app_emulation');
		$initialEnvironmentInfo = $appEmulation->startEnvironmentEmulation($storeId);

		try {
			// Retrieve specified view block from appropriate design package (depends on emulated store)
			$paymentBlock = Mage::helper('payment')->getInfoBlock($this->getPayment())
				->setIsSecureMode(true);
			$paymentBlock->getMethod()->setStore($storeId);
			$paymentBlockHtml = $paymentBlock->toHtml();
		} catch (Exception $exception) {
			// Stop store emulation process
			$appEmulation->stopEnvironmentEmulation($initialEnvironmentInfo);
			throw $exception;
		}

		// Stop store emulation process
		$appEmulation->stopEnvironmentEmulation($initialEnvironmentInfo);

		// Retrieve corresponding email template id and customer name
		if ($this->getCustomerIsGuest()) {
			$templateId = Mage::getStoreConfig(self::XML_PATH_EMAIL_GUEST_TEMPLATE, $storeId);
			$customerName = $this->getBillingAddress()->getName();
		} else {
			$templateId = Mage::getStoreConfig(self::XML_PATH_EMAIL_TEMPLATE, $storeId);
			$customerName = $this->getCustomerName();
		}

		$mailer = Mage::getModel('core/email_template_mailer');
		$emailInfo = Mage::getModel('core/email_info');
		$emailInfo->addTo($this->getCustomerEmail(), $customerName);
		if ($copyTo && $copyMethod == 'bcc') {
			// Add bcc to customer email
			foreach ($copyTo as $email) {
				$emailInfo->addBcc($email);
			}
		}
		$mailer->addEmailInfo($emailInfo);

		// Email copies are sent as separated emails if their copy method is 'copy'
		if ($copyTo && $copyMethod == 'copy') {
			foreach ($copyTo as $email) {
				$emailInfo = Mage::getModel('core/email_info');
				$emailInfo->addTo($email);
				$mailer->addEmailInfo($emailInfo);
			}
		}

		// Set all required params and send emails
		$mailer->setSender(Mage::getStoreConfig(self::XML_PATH_EMAIL_IDENTITY, $storeId));
		$mailer->setStoreId($storeId);
		$mailer->setTemplateId($templateId);
		$mailer->setTemplateParams(array(
				'order'		   => $this,
				'billing'	   => $this->getBillingAddress(),
				'payment_html' => $paymentBlockHtml,
				'customer_group' => $this->_getCustomerGroup()
			)
		);
		$mailer->send();

		$this->setEmailSent(true);
		$this->_getResource()->saveAttribute($this, 'email_sent');

		return $this;
	}

	/**
	 * Get customer group object
	 *
	 * @return object Mage_Customer_Model_Group
	 */
	protected function _getCustomerGroup()
	{
		return Mage::getModel('customer/group')->load($this->getCustomerGroupId());
	}
}