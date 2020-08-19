<?php

namespace Drupal\sample_work\Plugin\Block;

use Drupal\user\Entity\User;
use Drupal\Core\Block\BlockBase;
use Drupal\Core\Link;
use Drupal\Core\Url;

/**
 * Provides a 'Admin List Menu' block.
 *
 * @Block(
 *   id = "admin_menu_block",
 *   admin_label = @Translation("Admin List Menu")
 * )
 */
class SampleEntityListMenu extends BlockBase {

  /**
   * {@inheritdoc}
   */
  public function build() {
    $user = User::load(\Drupal::currentUser()->id());
    $current_user = \Drupal::currentUser();
    $roles = $current_user->getRoles();
    $link_option = [
      'attributes' => [
        'class' => [
          'use-ajax',
        ],
        'data-dialog-type' => 'modal',
        'data-dialog-options' => '{"width":"70%"}'
      ],
    ];
    $add_url = Url::fromRoute('entity.sample_work_entity.edit_form', [['id' => '5']])->toString();
    $url_list = [
        $add_url => 'Create Sample Entity',
      ];
    foreach ($url_list as $path => $title) {
      $url = Url::fromUserInput($path);
      // Check if the current user has access to this URL.
      // Add to array for the menu links only if the user has access.
      // This menu is cached by user by page. So should be good.
      if ($url->access()) {
        $url = Url::fromUserInput($path);
        $url->setOptions($link_option);
        $list[] = Link::fromTextAndUrl($title, $url);
      }
    }
    $output['admin_menu_block'] = [
      '#attributes' => [
        'class' => ['contextual-menu'],
        'id' => 'appeal-list-menus',
      ],
      '#theme' => 'item_list',
      '#items' => $list,
      '#cache' => [
        'contexts' => ['user', 'url.path'],
        'tags' => $user->getCacheTags(),
      ],
    ];
    return $output;
  }

}
