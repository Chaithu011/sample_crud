<?php
namespace Drupal\sample_work\Plugin\Block;

use Drupal\Core\Access\AccessResult;
use Drupal\Core\Block\BlockBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Session\AccountInterface;
use Drupal\sample_work\Entity\SampleWorkEntity;


/**
 * Provides a block with a simple text.
 *
 * @Block(
 *   id = "add_sample_work_form_block",
 *   admin_label = @Translation("Add Sample Work Entity Form Block"),
 * )
 */
class SampleWorkFormBlock extends BlockBase {
  /**
   * {@inheritdoc}
   */
  public function build() {
    $entity = SampleWorkEntity::create();
    $user_form = \Drupal::service('entity.form_builder')->getForm($entity, 'default');
    return $user_form;
  }

  /**
   * {@inheritdoc}
   */
  protected function blockAccess(AccountInterface $account) {
    return AccessResult::allowedIfHasPermission($account, 'access content');
  }
}