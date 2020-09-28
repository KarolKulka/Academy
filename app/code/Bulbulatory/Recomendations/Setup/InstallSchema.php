<?php


namespace Bulbulatory\Recomendations\Setup;

use Magento\Framework\DB\Adapter\AdapterInterface;
use Magento\Framework\DB\Ddl\Table;
use Magento\Framework\Setup\InstallSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;

/**
 * @codeCoverageIgnore
 */
class InstallSchema implements InstallSchemaInterface
{
    /**
     * {@inheritdoc}
     * @SuppressWarnings(PHPMD.ExcessiveMethodLength)
     */
    public function install(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        /**
         * Create table 'recomendations'
         */
        $table = $setup->getConnection()
                       ->newTable($setup->getTable('recomendations'))
                       ->addColumn(
                           'recomendation_id',
                           Table::TYPE_INTEGER,
                           null,
                           ['identity' => true, 'unsigned' => true, 'nullable' => false, 'primary' => true],
                           'Recomendation Id'
                       )
                       ->addColumn(
                           'customer_id',
                           Table::TYPE_INTEGER,
                           255,
                           ['nullable' => false, 'default' => '', 'unsigned' => true],
                           'Reference Id'
                       )
                       ->addColumn(
                           'email',
                           Table::TYPE_TEXT,
                           100,
                           ['nullable' => false],
                           'Email to which was recomendation sent',
                       )
                       ->addColumn(
                           'recomendation_hash',
                           Table::TYPE_TEXT,
                           255,
                           ['nullable' => false],
                           'Unique hash of recomendation',
                       )
                       ->addColumn(
                           'status',
                           Table::TYPE_BOOLEAN,
                           null,
                           ['identity' => true, 'nullable' => false],
                           'Recomendation status'
                       )
                       ->addColumn(
                           'created_at',
                           Table::TYPE_TIMESTAMP,
                           null,
                           ['nullable' => false, 'default' => Table::TIMESTAMP_INIT],
                           'Creation time of recomendation'
                       )
                       ->addColumn(
                           'updated_at',
                           Table::TYPE_TIMESTAMP,
                           null,
                           ['nullable' => false, 'default' => Table::TIMESTAMP_UPDATE],
                           'Update time of recomendation'
                       )
                        ->addIndex(
                            $setup->getIdxName(
                                'recomendations',
                                ['recomendation_hash'],
                                AdapterInterface::INDEX_TYPE_UNIQUE
                            ),
                            'recomendation_hash',
                            ['type' => AdapterInterface::INDEX_TYPE_UNIQUE]
                        )
                       ->setComment("Recomendations Table");
        $setup->getConnection()->createTable($table);
    }
}


