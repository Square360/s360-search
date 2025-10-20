<?php

namespace Drupal\s360_search\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Entity\EntityTypeManagerInterface;
use Drupal\Core\Messenger\MessengerInterface;
use Drupal\node\NodeInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Controller for displaying search index view of nodes.
 */
class SearchIndexController extends ControllerBase {

  /**
   * The entity type manager.
   *
   * @var \Drupal\Core\Entity\EntityTypeManagerInterface
   */
  protected $entityTypeManager;

  /**
   * The messenger service.
   *
   * @var \Drupal\Core\Messenger\MessengerInterface
   */
  protected $messenger;

  /**
   * Constructs a SearchIndexController object.
   *
   * @param \Drupal\Core\Entity\EntityTypeManagerInterface $entity_type_manager
   *   The entity type manager.
   * @param \Drupal\Core\Messenger\MessengerInterface $messenger
   *   The messenger service.
   */
  public function __construct(EntityTypeManagerInterface $entity_type_manager, MessengerInterface $messenger) {
    $this->entityTypeManager = $entity_type_manager;
    $this->messenger = $messenger;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('entity_type.manager'),
      $container->get('messenger')
    );
  }

  /**
   * Displays a node using the search_index view mode.
   *
   * @param \Drupal\node\NodeInterface $node
   *   The node to display.
   *
   * @return array
   *   A render array.
   */
  public function viewSearchIndex(NodeInterface $node) {
    $view_builder = $this->entityTypeManager->getViewBuilder('node');
    $build = $view_builder->view($node, 'search_index');

    // Add prefix message before content.
    $build['#prefix'] = '<div class="search-index-prefix"><hr><p><strong>' . $this->t('Search Index content begins here:') . '</strong></p><hr></div>';

    // Add suffix message after content.
    $build['#suffix'] = '<div class="search-index-suffix"><hr><p><strong>' . $this->t('Search Index content ends here.') . '</strong></p><hr></div>';

    return $build;
  }

}
