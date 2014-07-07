<?php
/**
 * Create a frontend form block that allows visitors
 * to add comments to category and product pages.
 *
 * @package	MageStudyGroup
 * @module	MageStudyGroup_MeetingFour
 */

class MageStudyGroup_MeetingFour_CommentController extends Mage_Core_Controller_Front_Action
{
	public function postAction()
	{
		if ($this->getRequest()->getPost()) {
			try {

				$request = $this->getRequest();
				$errors = array();

				// retrieve and validate data
				$email = $request->getPost('email');
				if (! Zend_Validate::is($email, 'EmailAddress')) {
					$errors[] = $this->__('Please enter your email address.');
				}

				$comment = htmlentities($request->getPost('comment'));
				if (! Zend_Validate::is($comment, 'NotEmpty')) {
					$errors[] = $this->__('Please enter a comment.');
				}

				if ($errors) {
					Mage::throwException(implode('<br/>\n', $errors));
				}

				// save comment
				Mage::getModel('magestudygroup_meetingfour/comment')
					->setEmail($email)
					->setComment($comment)
					->save();

				$this->_getMessageSession()->addSuccess(
					$this->__('Thank you for your comment.')
				);

			} catch (Exception $e) {
				$this->_getMessageSession()->addError($e->getMessage());
			}
		}

		$this->_redirectReferer();
	}

	protected function _getMessageSession()
	{
		return Mage::getSingleton('core/session');
	}
}