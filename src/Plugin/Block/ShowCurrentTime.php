<?php

namespace Drupal\time_block\Plugin\Block;

use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Drupal\Core\Block\BlockBase;
use Drupal\time_block\Services\CurrentTimeService;

/**
 * Provides a 'Current time' Block.
 *
 * @Block(
 *   id = "current_time_block",
 *   admin_label = @Translation("Show current time"),
 *   category = @Translation("Custom"),
 * )
 */
class ShowCurrentTime extends BlockBase implements ContainerFactoryPluginInterface {
	
  /**
   * Current time.
   *
   * @var Drupal\time_block\Services\CurrentTimeService
   */
  protected $current_time;
  
  /**
   * Constructs a new ShowCurrentTime object.
   */
  public function __construct(array $configuration, $plugin_id, $plugin_definition, CurrentTimeService $current_time) {
    parent::__construct($configuration, $plugin_id, $plugin_definition);
    $this->current_time = $current_time;
  }
  
  /**
   * {@inheritdoc}
   */  
  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
    return new static(
      $configuration,
      $plugin_id,
      $plugin_definition,
      $container->get('time_block.current_time_services')
    );
  }
  
  /**
   * {@inheritdoc}
   */
  public function defaultConfiguration() {
    return ['label_display' => FALSE];
  }

  /**
   * {@inheritdoc}
   */
  public function build() {
    $current_time = $this->current_time->showCurrentTime();
    $renderable = [
      '#theme' => 'current_time_template',
      '#current_time' => $current_time,
	    '#cache' => [
          'max-age' => 0,
       ]
    ];
	
    return $renderable;
  }
}
