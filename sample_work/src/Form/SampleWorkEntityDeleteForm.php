<?php

namespace Drupal\sample_work\Form;

use Drupal\Core\Entity\ContentEntityConfirmFormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Url;
use Drupal\Core\Routing\RouteMatchInterface;
use Symfony\Component\HttpFoundation\Request;

/**
 * Defines a confirmation form to confirm deletion of something by id.
 */
class SampleWorkEntityDeleteForm extends ContentEntityConfirmFormBase {

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    return parent::buildForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   *
   * Delete the entity and log the event. logger() replaces the watchdog.
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $currUrl = \Drupal::service('path.current')->getPath();
    $urlArg = explode('/', $currUrl);
    $entity_id = $urlArg[2];
    $controller = \Drupal::entityManager()->getStorage('sample_work_entity');
    $entity = $controller->load($entity_id);
    $entity->delete();
    $this->messenger()->addMessage($this->t('Successfully Deleted the record.'));
    $url_path = '/dashboard';
    $form_state->setRedirectUrl(Url::fromUserInput($url_path));
  }

  /**
   * {@inheritdoc}
   */
  public function getFormId() : string {
    return "sample_work_entity_delete_form";
  }

  /**
   * {@inheritdoc}
   */
  public function getCancelUrl() {
    $cancel_url = Url::fromRoute('sample_work.dashboard')->toString();
    return $cancel_url;
  }

  /**
   * {@inheritdoc}
   */
  public function getQuestion() {
    $entity = $this->getEntity();
    return t('Do you want to delete ?', ['%id' => $entity->id()]);
  }

}
