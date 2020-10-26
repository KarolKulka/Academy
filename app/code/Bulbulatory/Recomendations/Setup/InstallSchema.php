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
        $setup->startSetup();

        if (!$setup->tableExists('recomendations')) {
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
                               ['nullable' => false, 'unsigned' => true],
                               'Reference Id'
                           )
                           ->addColumn(
                               'email',
                               Table::TYPE_TEXT,
                               100,
                               ['nullable' => false],
                               'Email to which was recomendation sent'
                           )
                           ->addColumn(
                               'recomendation_hash',
                               Table::TYPE_TEXT,
                               255,
                               ['nullable' => false],
                               'Unique hash of recomendation'
                           )
                           ->addColumn(
                               'status',
                               Table::TYPE_BOOLEAN,
                               null,
                               ['nullable' => false, 'default' => 0],
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
                               'confirmed_at',
                               Table::TYPE_TIMESTAMP,
                               null,
                               ['nullable' => false],
                               'Confirmation time of the recommendation'
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
                           ->setComment("Recomendations Table")
                           ->addForeignKey(
                               $setup->getFkName(
                                   'recomendations',
                                   'customer_id',
                                   'customer_entity',
                                   'entity_id'),
                               'customer_id',
                               $setup->getTable('customer_entity'),
                               'entity_id'
                           );
            $setup->getConnection()->createTable($table);
        }

        $setup->endSetup();
    }
}


