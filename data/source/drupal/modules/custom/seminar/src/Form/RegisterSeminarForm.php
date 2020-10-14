<?php
/**
 * @file
 * Contains \Drupal\seminar\Form\RegisterSeminarForm.
 */
namespace Drupal\seminar\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Url;
use Drupal\seminar\Controller\SeminarController;
use Drupal\Core\Database\Database;
use Connection\Database\Connection;

class RegisterSeminarForm extends FormBase
{
    protected $request;
    protected $session;
    protected $conn;
    protected $user;
    
    public function __construct()
    {
        $this->seminar = new SeminarController();
        $this->request = \Drupal::request();
        $this->session = \Drupal::request()->getSession();
        $this->conn = Database::getConnection();
        $this->user = \Drupal::currentUser();
    }

    /**
     * {@inheritdoc}
     */
    public function getFormId()
    {
        return 'seminar_registration';
    }

    public function buildForm(array $form, FormStateInterface $form_state)
    {
        // $form['#action'] = '/seminar-register/confirm';
        $dataSession = \Drupal::request()->getSession()->get('SEMINAR_REGISTRATION_DATA');
        $nodeId = \Drupal::request()->getSession()->get('NODE_ID');
        $form['last_name'] = array(
            '#type' => 'textfield',
            '#title' => t('Last Name'),
            '#size' => 30,
            '#default_value' => !empty($dataSession['last_name']) ? t($dataSession['last_name']) : '',
            '#required' => false,
            '#prefix'      => '<div class="form-group">',
            '#suffix'      => '</div>',
        );
        $form['first_name'] = array(
            '#type' => 'textfield',
            '#title' => t('First Name'),
            '#size' => 30,
            '#default_value' => !empty($dataSession['first_name']) ? t($dataSession['first_name']) : '',
            '#required' => false,
            '#prefix'      => '<div class="form-group">',
            '#suffix'      => '</div>',
        );
        $form['sex'] = array(
            '#type' => 'select',
            '#title' => t('Gender'),
            '#options' => array(
                '1' => t('Men'),
                '2' => t('Women'),
                '3' => t('Other'),
                    ),
            '#default_value' => !empty($dataSession['sex']) ? t($dataSession['sex']) : null,
        );
        $form['company_name'] = array(
            '#type' => 'textfield',
            '#title' => t('Company Name'),
            '#size' => 80,
            '#default_value' => !empty($dataSession['company_name']) ? t($dataSession['company_name']) : '',
            '#required' => false,
            '#prefix'      => '<div class="form-group">',
            '#suffix'      => '</div>',
        );
        $form['phone'] = array(
            '#type' => 'textfield',
            '#title' => t('Phone Number'),
            '#attributes' => array(
              'oninput' => 'this.value = this.value.replace(/[^0-9.]/g, \'\').replace(/(\..*)\./g, \'$1\');'),
            '#size' => 11,
            '#maxlength' => 11,
            '#pattern' => '[0-9]{9,11}',
            '#default_value' => !empty($dataSession['phone']) ? t($dataSession['phone']) : '',
            '#required' => false,
            '#prefix'      => '<div class="form-group">',
            '#suffix'      => '</div>',
        );
        $form['email'] = array(
            '#type' => 'email',
            '#title' => $this->t('Email Address'),
            '#default_value' => !empty($dataSession['email']) ? t($dataSession['email']) : '',
            '#required' => false,
            '#prefix'      => '<div class="form-group">',
            '#suffix'      => '</div>',
        );
        $form['node_id'] = array(
            '#type' => 'hidden',
            '#title' => t(''),
            '#default_value' => !empty($nodeId) ? $nodeId : '',
            '#required' => false,
            '#prefix'      => '<div class="form-group">',
            '#suffix'      => '</div>',
        );
        $form['submit'] = [
            '#type' => 'submit',
            '#value' => t('Save') . ' >',
            '#attributes' => [
              'data-twig-suggestion' => 'button',
            ],
          ];
        // $form['#theme'] = 'formregistration';
        return $form;
    }

    /**
    * {@inheritdoc}
    */
    public function validateForm(array &$form, FormStateInterface $form_state) {
        // Assert the firstname is valid
        if (!$form_state->getValue('first_name') || empty($form_state->getValue('first_name'))) {
            $form_state->setErrorByName('first_name', $this->t('Your first name is required.'));
        }
        // Assert the lastname is valid
        if (!$form_state->getValue('last_name') || empty($form_state->getValue('last_name'))) {
            $form_state->setErrorByName('last_name', $this->t('Your name is required.'));
        }

        // Assert the email is valid
        if (!$form_state->getValue('email') || !filter_var($form_state->getValue('email'), FILTER_VALIDATE_EMAIL)) {
            $form_state->setErrorByName('email', $this->t('Your email address appears to be invalid.'));
        }

        // Assert the subject is valid
        if (!$form_state->getValue('company_name') || empty($form_state->getValue('company_name'))) {
            $form_state->setErrorByName('company_name', $this->t('Your company name is required.'));
        }

        // Assert the message is valid
        if (!$form_state->getValue('phone') || empty($form_state->getValue('phone'))) {
            $form_state->setErrorByName('phone', $this->t('Your phone number  is required.'));
        }
        // If validation errors, add inline errors
        // if ($errors = $form_state->getErrors()) {
        // // Add error to fields using Symfony Accessor
        //     $accessor = PropertyAccess::createPropertyAccessor();
        //     foreach ($errors as $field => $error) {
        //         if ($accessor->getValue($form, $field)) {
        //             $accessor->setValue($form, $field.'[#prefix]', '<div class="form-group error">');
        //             $accessor->setValue($form, $field.'[#suffix]', '<div class="input-error-desc">' .$error. '</div></div>');
        //             }
        //         }
        // }
        return $form;
    }

    public function submitForm(array &$form, FormStateInterface $form_state)
    {
        // get uid
        // die('submit');
        $uid = \Drupal::currentUser()->id();
        $session = \Drupal::request()->getSession();
        $formData = [
            'uid' => $uid,
            'first_name' => $form_state->getValue('first_name'),
            'last_name' => $form_state->getValue('last_name'),
            'email' => $form_state->getValue('email'),
            'phone' => $form_state->getValue('phone'),
            'company_name' => $form_state->getValue('company_name'),
        ];
        $session->set('SEMINAR_REGISTRATION_DATA', $formData);
        $data = $this->request->request->all();
        $seminar = array(
            'uid' => $this->user->id(),
            'first_name' => !empty($data['first_name']) ?  $data['first_name'] : '',
            'last_name' => !empty($data['last_name']) ?  $data['last_name'] : '',
            'sex' => !empty($data['sex']) ?  $data['sex'] : '',
            'phone' => !empty($data['phone']) ?  $data['phone'] : '',
            'email' => !empty($data['email']) ?  $data['email'] : '',
            'company_name' => !empty($data['company_name']) ?  $data['company_name'] : '',
        );
        $transaction = $this->conn->startTransaction();
        try{
            $last_id = $this->seminar->saveData($seminar, 'seminar_registration');
            $seminar_detail = array(
                'srid' => $last_id,
                'nid' => $data['node_id'],
            );
            $this->seminar->saveData($seminar_detail, 'seminar_registration_details');
            if ($last_id) {
                $status = 1;
                $session->remove('SEMINAR_REGISTRATION_DATA', $formData);
                $url = Url::fromRoute('seminar.confirm');
                $form_state->setRedirectUrl($url);
            } else {
                $status = 2;
            }
            $url = Url::fromRoute('seminar.confirm', ['status' => $status]);
            $form_state->setRedirectUrl($url);
        } catch (Exception $e) {
            $transaction->rollBack();
        }
    }

}