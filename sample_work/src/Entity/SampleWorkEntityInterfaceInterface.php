<?php

namespace Drupal\sample_work\Entity;

use Drupal\Core\Entity\ContentEntityInterface;
use Drupal\user\EntityOwnerInterface;
use Drupal\Core\Entity\EntityChangedInterface;

/**
 * Provides an interface defining a adding an sample_work_entity entity.
 *
 * @ingroup sample_work_entity
 */
interface SampleWorkEntityInterfaceInterface extends ContentEntityInterface, EntityOwnerInterface, EntityChangedInterface {
}
