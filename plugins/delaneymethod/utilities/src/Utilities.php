<?php
/**
 * DelaneyMethod Utilities plugin for Craft CMS 3.x
 *
 * Custom helpers and Twig filters
 *
 * @link      https://delaneymethod.com
 * @copyright Copyright (c) 2022 DelaneyMethod
 */

namespace delaneymethod\utilities;

use Craft;
use craft\web\twig\variables\CraftVariable;
use delaneymethod\utilities\variables\UtilitiesVariable;
use Jawira\CaseConverterTwig\CaseConverterExtension;
use Twig\Extra\String\StringExtension;
use yii\base\Event;
use craft\base\Plugin;
use delaneymethod\utilities\twigextensions\UtilitiesTwigExtension;

/**
 * Class Utilities
 *
 * @author    DelaneyMethod
 * @package   Utilities
 * @since     1.0.0
 */
class Utilities extends Plugin
{
	/**
	 * @var Utilities
	 */
	public static Utilities $plugin;

	/**
	 * @var string
	 */
	public string $schemaVersion = '1.0.0';

	/**
	 * @var bool
	 */
	public bool $hasCpSettings = false;

	/**
	 * @var bool
	 */
	public bool $hasCpSection = false;

	/**
	 * @inheritdoc
	 */
	public function init()
	{
		parent::init();

		self::$plugin = $this;

		Craft::$app->view->registerTwigExtension(new UtilitiesTwigExtension());
		Craft::$app->view->registerTwigExtension(new CaseConverterExtension());
		Craft::$app->view->registerTwigExtension(new StringExtension());

    Event::on(
      CraftVariable::class,
      CraftVariable::EVENT_INIT,
      function (Event $event) {
        /** @var CraftVariable $variable */
        $variable = $event->sender;
        $variable->set('delaneyMethodUtilities', UtilitiesVariable::class);
      }
    );

		Craft::info(
			Craft::t(
				'delaneymethod-utilities',
				'{name} plugin loaded',
				['name' => $this->name]
			),
			__METHOD__
		);
	}
}
