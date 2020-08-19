<?php

namespace Drupal\sample_work\Form;

use Drupal\Core\Entity\ContentEntityForm;
use Drupal\Core\Language\Language;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Url;
use Drupal\Core\Form\FormBase;
use Drupal\node\Entity\Node;
use Symfony\Component\DependencyInjection\ContainerInterface;



/**
 * Form controller for the sample_work_entity entity edit forms.
 *
 * @ingroup sample_work_entity
 */
class AddSampleWorkEntity extends ContentEntityForm {

  /**
   * The current user account.
   *
   * @var \Drupal\Core\Session\AccountProxyInterface
   */
  protected $account;

  /**
   * {@inheritdoc}
  */
  public function getFormId() {
    return 'add_sample_work_entity';
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    // Instantiates this form class.
    $instance = parent::create($container);
    $instance->account = $container->get('current_user');
    $instance->database = $container->get('database');
    $instance->now = \Drupal::time()->getCurrentTime();
    $instance->isAdmin = in_array('administrator', $instance->account->getAccount()->getRoles());
    $instance->wait = 0;
    return $instance;
  }
  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    /* @var $entity \Drupal\sample_work_entity\Entity\SampleWorkEntity */
    $form = parent::buildForm($form, $form_state);
    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function validateForm(array &$form, FormStateInterface $form_state) {
    $form_values = $form_state->getValues();
    if (!empty($form_values['start_date'][0]['value'])) {
      $start_date = $form_values['start_date'][0]['value']->format("Y-m-d H:i:s");
    }
    if (!empty($form_values['end_date'][0]['value'])) {
      $end_date = $form_values['end_date'][0]['value']->format("Y-m-d H:i:s");
    }
    if (!empty($start_date) && !empty($end_date)) {
      if (strtotime($start_date) > strtotime($end_date)) {
        $form_state->setErrorByName('start_date', t('Start Date must be less than end date'));
      }
    }
    parent::validateForm($form, $form_state);
  }
  /**
   * {@inheritdoc}
   */
  public function cancelSubmit($form, FormStateInterface $form_state) {
    $form_state->setRedirect('sample_work.dashboard');
  }
  /**
   * {@inheritdoc}
   */
  public function save(array $form, FormStateInterface $form_state) {
    $status = parent::save($form, $form_state);
    $this->messenger()->addMessage($this->t('Successfully Added/Updated entity.'));
    $form_state->setRedirect('sample_work.dashboard');
  }
}
