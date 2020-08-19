<?php

namespace Drupal\sample_work;

use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Entity\EntityListBuilder;
use Drupal\Core\Link;

/**
 * Defines a class to build a listing of Sample work entity entities.
 *
 * @ingroup sample_work_entity
 */
class SampleWorkEntityListBuilder extends EntityListBuilder {

  /**
   * {@inheritdoc}
   */
  public function buildHeader() {
    $header['id'] = $this->t('Sample work entity record ID');
    $header['name'] = $this->t('Name');
    return $header + parent::buildHeader();
  }

  /**
   * {@inheritdoc}
   */
  public function buildRow(EntityInterface $entity) {
    /* @var \Drupal\sample_work\Entity\SampleWorkEntity $entity */
    $row['id'] = $entity->id();
    $row['name'] = Link::createFromRoute(
      $entity->label(),
      'entity.sample_work_entity.edit_form',
      ['sample_work_entity' => $entity->id()]
    );
    return $row + parent::buildRow($entity);
  }

}
