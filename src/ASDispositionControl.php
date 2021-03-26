<?php declare(strict_types=1);

namespace ASDispositionControl;

use ASDispositionControl\Core\Api\ASDispoControlController;
use Doctrine\DBAL\Connection;
use Shopware\Core\Framework\Plugin\Context\UninstallContext;
use Shopware\Core\Framework\Plugin\Context\InstallContext;
use Shopware\Core\Framework\Plugin\Context\UpdateContext;
use Shopware\Core\Framework\Plugin\Context\ActivateContext;
use Shopware\Core\Framework\Plugin\Context\DeactivateContext;
use Shopware\Core\Framework\Plugin;

class ASDispositionControl extends Plugin
{
    /** @inheritDoc */
    public function install(InstallContext $installContext): void
    {
    }

    /** @inheritDoc */
    public function postInstall(InstallContext $installContext): void
    {
    }

    /** @inheritDoc */
    public function update(UpdateContext $updateContext): void
    {
    }

    /** @inheritDoc */
    public function postUpdate(UpdateContext $updateContext): void
    {
    }

    /** @inheritDoc */
    public function activate(ActivateContext $activateContext): void
    {
        /** @var ASDispoControlController $dispoController */
        $dispoController = $this->container->get('ASDispositionControl\Core\Api\ASDispoControlController');
        $dispoController->updateDispoControlData($activateContext->getContext());
    }

    /** @inheritDoc */
    public function deactivate(DeactivateContext $deactivateContext): void
    {
    }

    /** @inheritDoc */
    public function uninstall(UninstallContext $context): void
    {
        if ($context->keepUserData()) {
            parent::uninstall($context);

            return;
        }

        $connection = $this->container->get(Connection::class);

        $connection->executeUpdate('DROP TABLE IF EXISTS `as_dispo_control_data`');

        parent::uninstall($context);
    }
}