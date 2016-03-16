<?php
/**
 * PYCOGROUP
 * Author: phuong.nvh
 * Testimonials Install Script
 */

/* @var $installer Mage_Core_Model_Resource_Setup */
$installer = $this;

$installer->startSetup();
try {
    $infoTbl = $installer->getTable('testimonials/info');
    if ($installer->tableExists($infoTbl)) {
        $installer->getConnection()->dropTable($infoTbl);
    }

    $installer->run("
        CREATE TABLE IF NOT EXISTS {$this->getTable('testimonials/info')} (
            `id` int( 11 ) unsigned NOT NULL AUTO_INCREMENT ,
            `testimonial_name` varchar( 255 ) NOT NULL default '',
            `content` text NOT NULL ,
            `status` int( 2 ) unsigned NOT NULL default '0',
            `created_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ,
            `update_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ,
            PRIMARY KEY ( `id` )
        ) ENGINE = InnoDB DEFAULT CHARSET = utf8;
    ");

    $fbTable = $installer->getTable('testimonials/feedback');
    if ($installer->tableExists($fbTable)) {
        $installer->getConnection()->dropTable($fbTable);
    }

    $feedbackTbl = $installer->getConnection()->newTable($fbTable);

    $feedbackTbl
        ->addColumn('id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
            'primary' => true,
            'identity' => true,
            'unsigned' => true,
            'nullable' => false
        ), 'id')
        ->addColumn('testimonial_id', Varien_Db_Ddl_Table::TYPE_INTEGER, 11, array(
            'nullable' => false,
            'unsigned' => true,
        ), 'Testimonial Id')
        ->addColumn('username', Varien_Db_Ddl_Table::TYPE_VARCHAR, 25, array(
            'nullable' => false
        ), 'Username')
        ->addColumn('content', Varien_Db_Ddl_Table::TYPE_TEXT, null, array(
            'nullable' => false
        ), 'Content')
        ->addColumn('status', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
            'unsigned' => true,
            'nullable' => false,
            'default' => '0'
        ), 'Status')
        ->addColumn('created_time', Varien_Db_Ddl_Table::TYPE_TIMESTAMP, null, array(
            'default' => Varien_Db_Ddl_Table::TIMESTAMP_INIT,
            'nullable' => false
        ), 'Created Time')
        ->addColumn('update_time', Varien_Db_Ddl_Table::TYPE_TIMESTAMP, null, array(
            'default' => Varien_Db_Ddl_Table::TIMESTAMP_INIT,
            'nullable' => false
        ), 'Update Time')
        ->addForeignKey(
            $installer->getFkName(
                'testimonials/feedback',
                'testimonial_id',
                'testimonials/info',
                'id'),
            'testimonial_id',
            $installer->getTable('testimonials/info'),
            'id',
            Varien_Db_Ddl_Table::ACTION_CASCADE,
            Varien_Db_Ddl_Table::ACTION_CASCADE
        );
    $installer->getConnection()->createTable($feedbackTbl);
} catch (Exception $e) {
    Mage::logException($e);
}

$installer->endSetup();