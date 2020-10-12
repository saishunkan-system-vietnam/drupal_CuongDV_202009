<?php
/**
 * @file
 * Contains \Drupal\seminar\Form\RegisterSeminarForm.
 */
namespace Drupal\seminar\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Url;

class RegisterSeminarForm extends FormBase
{
    /**
     * {@inheritdoc}
     */
    public function getFormId()
    {
        return 'seminar_registration';
    }

    public function buildForm(array $form, FormStateInterface $form_state)
    {
        $dataSession = \Drupal::request()->getSession()->get('SEMINAR_REGISTRATION_DATA');
        if (empty($dataSession)) {
            $dataSession = \Drupal::request()->getSession()->get('USER_DATA');
        }
        $nodeId = \Drupal::request()->getSession()->get('NODE_ID');
        $form['last_name'] = array(
            '#type' => 'textfield',
            '#title' => t('Last Name'),
            '#size' => 30,
            '#default_value' => !empty($dataSession['last_name']) ? t($dataSession['last_name']) : '',
            '#required' => true,
        );
        $form['first_name'] = array(
            '#type' => 'textfield',
            '#title' => t('First Name'),
            '#size' => 30,
            '#default_value' => !empty($dataSession['first_name']) ? t($dataSession['first_name']) : '',
            '#required' => true,
        );
        // $taxonomyGender = \Drupal::entityTypeManager()->getStorage('taxonomy_term')->loadTree('t_gender');
        // $optionGender = [];
        // foreach ($taxonomyGender as $item) {
        //     $optionGender[$item->tid] = $this->t($item->name);
        // }
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
            '#required' => true,
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
            '#required' => true,
        );
        $form['email'] = array(
            '#type' => 'textfield',
            '#title' => $this->t('Email Address'),
            '#default_value' => !empty($dataSession['email']) ? t($dataSession['email']) : '',
            '#attributes' => !empty($dataSession['email']) ? array('readonly' => 'readonly') : array(),
            '#required' => true,
        );
        $form['node_id'] = array(
            '#type' => 'hidden',
            '#title' => t(''),
            '#default_value' => !empty($nodeId) ? $nodeId : '',
            '#required' => false,
        );
        // $form['submit'] = [
        //     '#type' => 'submit',
        //     '#value' => t('Submit') . ' >',
        //     '#attributes' => [
        //       'data-twig-suggestion' => 'button',
        //     ],
        //   ];
        $form['#theme'] = 'formregistration';
        return $form;
    }

    public function submitForm(array &$form, FormStateInterface $form_state)
    {
        // get uid
        $uid = \Drupal::currentUser()->id();
        $session = \Drupal::request()->getSession();
        $formData = [
            'uid' => $uid,
            'first_name' => $form_state->getValue('first_name'),
            'last_name' => $form_state->getValue('last_name'),
            'email' => $form_state->getValue('email'),
            'phone' => $form_state->getValue('phone'),
        ];
        $session->set('SEMINAR_REGISTRATION_DATA', $formData);
        $url = Url::fromRoute('seminar.confirm');
        $form_state->setRedirectUrl($url);
    }

}