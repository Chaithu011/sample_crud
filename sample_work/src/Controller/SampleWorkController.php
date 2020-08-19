<?php
/**
 * @file
 * Contains \Drupal\sample_work\Controller\SampleWorkController.
 */
namespace Drupal\sample_work\Controller;

use Drupal\Core\Controller\ControllerBase;
use Symfony\Component\HttpFoundation\Request;
use Drupal\Core\Routing\RouteMatchInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Drupal\Core\Url;
use Drupal\Core\Access\AccessResult;
use Drupal\Core\Session\AccountInterface;
use Drupal\user\Entity\User;
use Drupal\sample_work\Entity\SampleWorkEntity;

/**
 * {@inheritdoc}
 */
class SampleWorkController extends ControllerBase {

  /**
   * Manage the generation of blocks in the controller.
   *
   * @var Drupal\Core\Block\BlockManager
   */
  private $blockManager;

  /**
   * {@inheritdoc}
   */
  public function __construct() {
    $this->blockManager = \Drupal::service('plugin.manager.block');
  }

  /**
   * Return the sample_work_entity form in add/edit mode.
   */
  public function content() {
    $path = (\Drupal::service('path.current')->getPath());
    $arg = explode('/', $path);
    $id = $arg[2];
    $uid = \Drupal::currentUser()->id();
    $entity = SampleWorkEntity::load($id);
    if (!empty($entity)) {
      $form = \Drupal::service('entity.form_builder')->getForm($entity, 'add');
      return $form;
    }
    else {
      $form = \Drupal::service('entity.form_builder')->getForm($entity, 'add');
      return $form;
    }
  }

/**
 * @file
 * Contains \Drupal\sample_work\Controller\SampleWorkController.
 */
  public function dashboard() {
    $render_array['add_sample_work_form_block'] = $this->addBlock('add_sample_work_form_block');
    $render_array['sample_work_entity_list'] = views_embed_view('sample_work_entity_list', 'block_1');
    return $render_array;
  }


  /**
   * Return render array for the block to be added.
   */
  private function addBlock($block_id) {
    $config = [];
    $render = [];
    $plugin_block = $this->blockManager->createInstance($block_id, $config);
    // Some blocks might implement access check.
    $access_result = $plugin_block->access(\Drupal::currentUser());

    // Return empty render array if user doesn't have access.
    // $access_result can be boolean or an AccessResult class.
    if (is_object($access_result) && !$access_result->isForbidden() || is_bool($access_result) && $access_result) {
      // You might need to add some cache tags/contexts.
      $render = $plugin_block->build();
    }
    return $render;
  }
}