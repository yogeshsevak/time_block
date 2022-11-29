<?php

namespace Drupal\time_block\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Implements TimeConfigrationForm form.
 */
class TimeConfigrationForm extends ConfigFormBase {	
	
  /** 
   * Config settings.
   *
   * @var string
   */
  const SETTINGS = 'time_block.settings';

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'time_configration_form';
  }
  
  /** 
   * {@inheritdoc}
   */
  protected function getEditableConfigNames() {
    return [
      static::SETTINGS,
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $config = $this->config(static::SETTINGS);
    $form['country'] = [
      '#type' => 'textfield',      
      '#attributes' => [
        'placeholder' => $this->t("Country"),
        'class' => ['country'],
      ],
		  '#default_value' => $config->get('country'),
    ];
    $form['city'] = [
      '#type' => 'textfield',      
      '#attributes' => [
        'placeholder' => $this->t("City"),
        'class' => ['city'],
      ],
      '#default_value' => $config->get('city'),
    ];	
    $options = ["America/Chicago" => "America/Chicago", "America/New_York" => "America/New_York", "Asia/Tokyo" => "Asia/Tokyo", "Asia/Dubai" => "Asia/Dubai", "Asia/Kolkata" => "Asia/Kolkata", "Europe/Amsterdam" => "Europe/Amsterdam", "Europe/Oslo" => "Europe/Oslo", "Europe/London" => "Europe/London"];
    $form['timezone'] = [
      '#title' => $this->t('Timezone'),
      '#type' => 'select',
      '#description' => $this->t('Select which timezone time you want to show.'),
      '#options' => $options,
      '#default_value' => $config->get('timezone'),
    ];	
    $form['actions']['#type'] = 'actions';
    $form['actions']['submit'] = [
      '#type' => 'submit',
      '#value' => $this->t('Submit'),
    ];	
    return parent::buildForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function validateForm(array &$form, FormStateInterface $form_state) {
    parent::validateForm($form, $form_state);
  }

  /** 
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    // Retrieve the configuration.
    $this->config(static::SETTINGS)
      // Set the submitted configuration setting.
      ->set('country', $form_state->getValue('country'))
      ->set('city', $form_state->getValue('city'))
      ->set('timezone', $form_state->getValue('timezone'))
      ->save();
    parent::submitForm($form, $form_state);
  }
}
