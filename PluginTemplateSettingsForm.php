<?php
namespace APP\plugins\generic\pluginTemplate;

use APP\core\Application;
use APP\notification\Notification;
use APP\notification\NotificationManager;
use APP\template\TemplateManager;
use PKP\form\Form;
use PKP\form\validation\FormValidatorCSRF;
use PKP\form\validation\FormValidatorPost;

class PluginTemplateSettingsForm extends Form {

    public PluginTemplatePlugin $plugin;

    /**
     * Defines the settings form's template and adds
     * validation checks.
     *
     * Always add POST and CSRF validation to secure
     * your form.
     */
    public function __construct(PluginTemplatePlugin $plugin)
    {
        parent::__construct($plugin->getTemplateResource('settings.tpl'));

        $this->plugin = $plugin;

        $this->addCheck(new FormValidatorPost($this));
        $this->addCheck(new FormValidatorCSRF($this));
    }

    /**
     * Load settings already saved in the database
     *
     * Settings are stored by context, so that each journal, press,
     * or preprint server can have different settings.
     */
    public function initData()
    {
        $context = Application::get()
            ->getRequest()
            ->getContext();

        $contextId = $context
            ? $context->getId()
            : Application::CONTEXT_SITE;

        $this->setData(
            'publicationStatement',
            $this->plugin->getSetting(
                $contextId,
                'publicationStatement'
            )
        );

        parent::initData();
    }

    /**
     * Load data that was submitted with the form
     */
    public function readInputData()
    {
        $this->readUserVars(['publicationStatement']);

        parent::readInputData();
    }

    /**
     * Fetch any additional data needed for your form.
     *
     * Data assigned to the form using $this->setData() during the
     * initData() or readInputData() methods will be passed to the
     * template.
     *
     * In the example below, the plugin name is passed to the
     * template so that it can be used in the URL that the form is
     * submitted to.
     */
    public function fetch($request, $template = null, $display = false)
    {
        $templateMgr = TemplateManager::getManager($request);
        $templateMgr->assign('pluginName', $this->plugin->getName());

        return parent::fetch($request, $template, $display);
    }

    /**
     * Save the plugin settings and notify the user
     * that the save was successful
     */
    public function execute(...$functionArgs)
    {
        $context = Application::get()
            ->getRequest()
            ->getContext();

        $contextId = $context
            ? $context->getId()
            : Application::CONTEXT_SITE;

        $this->plugin->updateSetting(
            $contextId,
            'publicationStatement',
            $this->getData('publicationStatement')
        );

        $notificationMgr = new NotificationManager();
        $notificationMgr->createTrivialNotification(
            Application::get()->getRequest()->getUser()->getId(),
            Notification::NOTIFICATION_TYPE_SUCCESS,
            ['contents' => __('common.changesSaved')]
        );

        return parent::execute();
    }
}
