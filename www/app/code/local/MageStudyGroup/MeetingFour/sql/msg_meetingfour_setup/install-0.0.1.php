<?php
/**
 * Create a custom entity table for comments using a setup script.
 *
 * @package	MageStudyGroup
 * @module	MeetingFour
 *
 */

try {
	/* @var $installer Mage_Core_Model_Resource_Setup */
	$installer = $this;
	$installer->startSetup();

	$table = $installer->getConnection()
		->newTable($installer->getTable('magestudygroup_meetingfour/comment'))
		->addColumn('entity_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
			'identity' => true,
			'unsigned' => true,
			'nullable' => false,
			'primary'  => true,
		), 'Entity ID')
		->addColumn('email', Varien_Db_Ddl_Table::TYPE_TEXT, 255, array(
			'nullable' => true,
			'default'  => ''
		), 'Email')
		->addColumn('page', Varien_Db_Ddl_Table::TYPE_TEXT, 255, array(
			'nullable' => true,
			'default'  => ''
		), 'Page')
		->addColumn('comment', Varien_Db_Ddl_Table::TYPE_TEXT, '1k', array(
			'nullable' => false,
			'default'  => ''
		), 'Comment')
		->addColumn('created_at', Varien_Db_Ddl_Table::TYPE_DATETIME, null, array(
			'nullable' => false
		), 'Created At')
		->addColumn('updated_at', Varien_Db_Ddl_Table::TYPE_DATETIME, null, array(
			'nullable' => false
		), 'Updated At');


	$installer->getConnection()->createTable($table);

	$installer->endSetup();

} catch (Exception $e) {
	echo '<pre><code>' . print_r($e, true) . '</code></pre>';
	die;
}
