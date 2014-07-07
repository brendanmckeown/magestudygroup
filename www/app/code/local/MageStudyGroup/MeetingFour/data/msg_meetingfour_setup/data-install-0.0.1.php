<?php

/**
 * Create a data upgrade script that uses
 * the comments model classes to populate the database.
 *
 * @package    MageStudyGroup
 * @module     MageStudyGroup_MeetingFour
 */

try {

	$comment = Mage::getModel('magestudygroup_meetingfour/comment');
	if ($comment) {
		$datetime = date("Y:m:d H:i:s");
		$comment->setEmail('brenmckeown@gmail.com')
			->setComment('This comment was added by a data script.')
			->setPage(Mage::getBaseUrl())
			->setCreatedAt($datetime)
			->setUpdatedAt($datetime)
			->save();
	}

} catch (Exception $e) {
	echo '<pre><code>' . print_r($e, true) . '</code></pre>';
	die;
}
