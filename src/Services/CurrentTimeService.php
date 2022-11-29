<?php

namespace Drupal\time_block\Services;

use Drupal\Core\Config\ConfigFactory;
use Drupal\Core\Datetime\DateFormatter;

/**
 * Class CurrentTimeService.
 */
class CurrentTimeService {
  /**
   * Config factory.
   *
   * @var Drupal\Core\Config\ConfigFactory
   */
  protected $config_factory;	
	
  /**
   * The Date Fromatter.
   *
   * @var Drupal\Core\Datetime\DateFormatter
   */
  protected $date_formatter;

  /**
   * Constructs a new CurrentTimeService object.
   */
  public function __construct(ConfigFactory $config_factory, DateFormatter $date_formatter) {
    $this->config_factory = $config_factory;
    $this->date_formatter = $date_formatter;
  }

  public function showCurrentTime() {
    $time_config = $this->config_factory->getEditable('time_block.settings');
    return [
      'time' => $this->date_formatter->format(REQUEST_TIME, 'custom', 'h:i A', $time_config->get('timezone')),
      'date' => $this->date_formatter->format(REQUEST_TIME, 'custom', 'l, d F Y', $time_config->get('timezone')),
      'place' => t('Times in') . ' ' . $time_config->get('city') . ', ' . $time_config->get('country')
    ];
  }
}