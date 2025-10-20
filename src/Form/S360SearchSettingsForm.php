<?php

namespace Drupal\s360_search\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Entity\EntityTypeManagerInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Configure S360 Search settings.
 */
class S360SearchSettingsForm extends ConfigFormBase {

  /**
   * The entity type manager.
   *
   * @var \Drupal\Core\Entity\EntityTypeManagerInterface
   */
  protected $entityTypeManager;

  /**
   * Constructs a S360SearchSettingsForm object.
   *
   * @param \Drupal\Core\Entity\EntityTypeManagerInterface $entity_type_manager
   *   The entity type manager.
   */
  public function __construct(EntityTypeManagerInterface $entity_type_manager) {
    $this->entityTypeManager = $entity_type_manager;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('entity_type.manager')
    );
  }

  /**
   * {@inheritdoc}
   */
  protected function getEditableConfigNames() {
    return ['s360_search.settings'];
  }

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 's360_search_settings_form';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $config = $this->config('s360_search.settings');

    // Get all paragraph types.
    $paragraph_types = $this->entityTypeManager
      ->getStorage('paragraphs_type')
      ->loadMultiple();

    $options = [];
    foreach ($paragraph_types as $type) {
      $options[$type->id()] = $type->label();
    }

    $form['exclude_paragraph_types'] = [
      '#type' => 'checkboxes',
      '#title' => $this->t('Exclude Paragraphs from Search Index'),
      '#description' => $this->t('Select paragraph types that should be excluded from the search_index view mode.'),
      '#options' => $options,
      '#default_value' => $config->get('exclude_paragraph_types') ?: [],
    ];

    return parent::buildForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    // Filter out unchecked values.
    $exclude_paragraph_types = array_filter($form_state->getValue('exclude_paragraph_types'));

    $this->config('s360_search.settings')
      ->set('exclude_paragraph_types', $exclude_paragraph_types)
      ->save();

    parent::submitForm($form, $form_state);
  }

}

