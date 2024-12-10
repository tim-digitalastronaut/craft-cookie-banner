<?php

namespace diginaut\cookiebanner;

use Craft;
use craft\base\Model;
use craft\base\Plugin;
use craft\events\TemplateEvent;
use craft\web\View;
use diginaut\cookiebanner\resources\CookieBannerAsset;
use diginaut\cookiebanner\models\Settings;
use yii\base\Event;
use yii\base\InvalidConfigException;

/**
 * craft-cookie-banner plugin
 *
 * @method static CookieBanner getInstance()
 * @method Settings getSettings()
 */
class CookieBanner extends Plugin
{
    public string $schemaVersion = '1.0.0';
    public bool $hasCpSettings = true;

    public static function config(): array
    {
        return [
            'components' => [
                // Define component configs here...
            ],
        ];
    }

    public function init(): void
    {
        parent::init();

        $this->attachEventHandlers();

        // Any code that creates an element query or loads Twig should be deferred until
        // after Craft is fully initialized, to avoid conflicts with other plugins/modules
        Craft::$app->onInit(function() {
            // ...
        });
    }

    protected function createSettingsModel(): ?Model
    {
        return Craft::createObject(Settings::class);
    }

    protected function settingsHtml(): ?string
    {
        return Craft::$app->view->renderTemplate('_craft-cookie-banner/_settings.twig', [
            'plugin' => $this,
            'settings' => $this->getSettings(),
        ]);
    }

    private function attachEventHandlers(): void
    {
        // Register event handlers here ...
        // (see https://craftcms.com/docs/5.x/extend/events.html to get started)

        Event::on(
            View::class,
            View::EVENT_BEFORE_RENDER_PAGE_TEMPLATE,
            function (TemplateEvent $event) {
                try {
                    $view = Craft::$app->getView();
                    $view->registerAssetBundle(CookieBannerAsset::class);
                } catch (InvalidConfigException $e) {
                    Craft::error( 'Error registering AssetBundle - ' . $e->getMessage(), __METHOD__ );
                }
            }
        );

        Event::on(
            View::class,
            View::EVENT_END_BODY,
            function () {
                if (Craft::$app->request->isSiteRequest) {
                    $this->addCookieBanner();
                }
            }
        );
    }

    private function addCookieBanner()
    {
        $view = Craft::$app->getView();
        $plugin = CookieBanner::getInstance();

        try {
            $view->setTemplatesPath($plugin->getBasePath());
            $injectedContent = $view->renderTemplate(
                'templates/_banner',
                [
                    'settings' => $plugin->getSettings()
                ],
                View::TEMPLATE_MODE_SITE
            );

            echo $injectedContent;
        } catch (InvalidConfigException $e) {
            Craft::error( 'Error rendering the template - ' . $e->getMessage(), __METHOD__ );
        }
    }
}
