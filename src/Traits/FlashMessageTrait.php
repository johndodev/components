<?php

namespace Johndodev\Components\Traits;

use Johndodev\Components\Twig\BootstrapAlerts;

/**
 * Flash Messages with bootstrap (work with BoostrapAlertsExtension)
 */
Trait FlashMessageTrait
{
    public function addSuccessMessage($message)
    {
        $this->addMessage(BootstrapAlerts::GREEN, $message);
    }

    public function addWarningMessage($message)
    {
        $this->addMessage(BootstrapAlerts::YELLOW, $message);
    }

    public function addErrorMessage($message)
    {
        $this->addMessage(BootstrapAlerts::RED, $message);
    }

    public function addInfoMessage($message)
    {
        $this->addMessage(BootstrapAlerts::BLUE, $message);
    }

    protected function addMessage($type, $message)
    {
        $this->addFlash($type, $message);
    }
}
