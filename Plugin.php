<?php

namespace Kanboard\Plugin\ClearDueDateTaskNotMovedColumn;
use Kanboard\Core\Plugin\Base;
use Kanboard\Plugin\ClearDueDateTaskNotMovedColumn\Action\ClearDueDateTaskNotMovedColumn;

use Kanboard\Core\Translator;

class Plugin extends Base
{
    public function initialize()
    {
      $this->actionManager->register(new ClearDueDateTaskNotMovedColumn($this->container));
    }

    public function onStartup() {
        // load Translation
        Translator::load($this->languageModel->getCurrentLanguage(), __DIR__ . '/Locale');
    }

    public function getPluginName()
    {
        return 'ClearDueDateTaskNotMovedColumn';
    }

    public function getPluginDescription()
    {
        return t('Clear the due date of a task in a specific column when not moved during a given period');
    }

    public function getPluginAuthor()
    {
        return 'Manfred Hoffmann';
    }

    public function getPluginVersion()
    {
        return '0.8.0';
    }

    public function getPluginHomepage()
    {
        return 'https://github.com/manne65-hd/kanboard-ClearDueDateTaskNotMovedColumn';
    }

    public function getCompatibleVersion()
    {
        return '>=1.2.19';
    }
}
