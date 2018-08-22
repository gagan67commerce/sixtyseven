<?php
/**
 * FAQ Extension
 *
 * @package SixtySeven Commerce
 * @author SixtySeven Commerce - All Rights Reserved
 * @copyright 2018 SixtySeven Commerce
 * Unauthorized copying of this file, via any medium is strictly prohibited
 * Proprietary and confidential
 */

namespace SixtySeven\Faq\Setup;

use Magento\Framework\Model\AbstractModel;
use Magento\Framework\Setup\UninstallInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;
use Magento\Config\Model\ResourceModel\Config\Data;
use Magento\Config\Model\ResourceModel\Config\Data\CollectionFactory;

class Uninstall implements UninstallInterface
{
    /**
     * @var CollectionFactory
     */
    protected $collectionFactory;
    /**
     * @var Data
     */
    protected $configResource;
    /**
     * {@inheritdoc}
     *
     * @param SchemaSetupInterface $setup
     * @param ModuleContextInterface $context
     * @SuppressWarnings(PHPMD.ExcessiveMethodLength)
     */
    public function __construct(
        CollectionFactory $collectionFactory,
        Data $configResource
    )
    {
        $this->collectionFactory = $collectionFactory;
        $this->configResource    = $configResource;
    }
    public function uninstall(
        SchemaSetupInterface $setup,
        ModuleContextInterface $context
    ) {
        $installer = $setup;

        $installer->startSetup();
        $connection = $installer->getConnection();
        $connection->dropTable($connection->getTableName('sixtyseven_faq'));        
        $connection->dropTable($connection->getTableName('sixtyseven_faq_store'));
        $connection->dropTable($connection->getTableName('sixtyseven_faq_category'));
        $connection->dropTable($connection->getTableName('sixtyseven_faq_category_store'));
        $connection->dropTable($connection->getTableName('sixtyseven_faq_category_id'));
        $connection->dropTable($connection->getTableName('sixtyseven_faq_like'));
        $connection->dropTable($connection->getTableName('sixtyseven_faq_attachment_rel'));
        $collection = $this->collectionFactory->create()
            ->addPathFilter('sixtyseven_faq/general/ajax');
        foreach ($collection as $config) {
            $this->deleteConfig($config);
        }
        $installer->endSetup();
    }
    protected function deleteConfig(AbstractModel $config)
    {
        $this->configResource->delete($config);
    }
}