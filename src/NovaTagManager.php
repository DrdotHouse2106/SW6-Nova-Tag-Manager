<?php declare(strict_types=1);

namespace Nova\TagManager;

use Doctrine\DBAL\Connection;
use Shopware\Core\Framework\Plugin;
use Shopware\Core\Framework\Plugin\Context\UpdateContext;
use Shopware\Core\Framework\Uuid\Uuid;
use Shopware\Core\System\SystemConfig\SystemConfigService;

/**
 * Nova Tag Manager – Google Tag Manager mit GA4-E-Commerce-Datenlayer und Consent Mode v2.
 */
class NovaTagManager extends Plugin
{
    private const LOAD_STRATEGY = 'NovaTagManager.config.loadStrategy';

    public function update(UpdateContext $updateContext): void
    {
        parent::update($updateContext);

        // 1.2.0: Container überall erst nach Zustimmung laden (einmalig beim Update von älteren Versionen)
        if (version_compare($updateContext->getCurrentPluginVersion(), '1.2.0', '<')) {
            $this->loadOnlyAfterConsent();
        }
    }

    private function loadOnlyAfterConsent(): void
    {
        if ($this->container === null) {
            return;
        }

        /** @var Connection $connection */
        $connection = $this->container->get(Connection::class);
        /** @var SystemConfigService $config */
        $config = $this->container->get(SystemConfigService::class);

        $salesChannelIds = $connection->fetchFirstColumn(
            'SELECT LOWER(HEX(sales_channel_id)) FROM system_config WHERE configuration_key = :key',
            ['key' => self::LOAD_STRATEGY]
        );

        $config->set(self::LOAD_STRATEGY, 'consent');
        foreach ($salesChannelIds as $salesChannelId) {
            if (\is_string($salesChannelId) && Uuid::isValid($salesChannelId)) {
                $config->set(self::LOAD_STRATEGY, 'consent', $salesChannelId);
            }
        }
    }
}
