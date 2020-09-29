<?php
/**
 * @file
 * Contains \Drupal\seminar\Form\SeminarDetailForm.
 */
namespace Drupal\seminar\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Url;

class SeminarDetailForm extends FormBase {

    /**
     * {@inheritdoc}
     */
    public function getFormId() {
        return 'seminar_detail';
    }

    public function buildForm(array $form, FormStateInterface $form_state)
    {
        $node = \Drupal::routeMatch()->getParameter('node');
        $nid = $node->nid->value;
        $form['seminar_name'] = [
            '#title' => t('Seminar name'),
            '#type' => 'textfield',
            '#size' => 10,
            '#placeholder' => t('Seminar\'s name'),
            '#required' => TRUE,
        ];
        $form['seminar_description'] = [
            '#title' => t('Seminar\'s description'),
            '#type' => 'textarea',
            '#placeholder' => t('Seminar Description'),
            '#required' => TRUE,
        ];
        $form['speaker_name'][] = [
            '#title' => t('Speaker name'),
            '#type' => 'textfield',
            '#placeholder' => t('Speaker\'s name'),
            '#required' => TRUE,
        ];
        $form['img'][] = [
            '#title' => t('Speaker\'s Image'),
            '#type' => 'file',
            '#placeholder' => t('Speaker\'s Image'),
            '#required' => TRUE,
        ];
        $form['title'][] = [
            '#title' => t('Speaker\'s content title'),
            '#type' => 'textarea',
            '#placeholder' => t('Speaker\'s content title'),
            '#required' => TRUE,
        ];
        $form['content'][] = [
            '#title' => t('Speaker\'s Content'),
            '#type' => 'textarea',
            '#placeholder' => t('Speaker\'s Content'),
            '#required' => TRUE,
        ];
        $form['place_date'] = [
            '#title' => t('Place Date Seminar'),
            '#type' => 'date',
            '#required' => TRUE,
        ];
        $form['regis_start_date'] = [
            '#title' => t('Date start register to join Seminar'),
            '#type' => 'date',
            '#required' => TRUE,
        ];
        $form['regis_end_date'] = [
            '#title' => t('Date end register to join Seminar'),
            '#type' => 'date',
            '#required' => TRUE,
        ];
        $form['submit'] = [
            '#type' => "submit",
            '#value' => t("Apply"),
        ];
        $form['nid'] = [
            '#type' => "hidden",
            '#value' => $nid,
        ];
        $form['#theme'] = 'seminar_registration_form';
        return $form;
    }

    public function submitForm(array &$form, FormStateInterface $form_state)
    {
        $uid = \Drupal::currentUser()->id();
        $session = \Drupal::request()->getSession();
        $formData = [
            'uid' => $uid,
            'seminar_name' => $form_state->getValue('seminar_name'),
            'seminar_content' => $form_state->getValue('seminar_content'),
            'img' => $form_state->getValue('img'),
            'place_date' => $form_state->getValue('place_date'),
            'regis_start_date' => $form_state->getValue('regis_start_date'),
            'regis_end_date' => $form_state->getValue('regis_end_date'),
            'nid' => $form_state->getValue('nid')
        ];
        $session->set('SEMINAR_REGISTRATION_DATA', $formData);
        $url = Url::fromRoute('seminar.confirm');
        $form_state->setRedirectUrl($url);
    }

    public function validateForm(array &$form, FormStateInterface $form_state)
    {
        $email = $form_state->getValue('email');
        if ($email == !\Drupal::service('email.validator')->isValid($email)) {
            $form_state->setErrorByName('email', t("The email address %mail is not valid,", array('%mail' => $email)));
            return;
        }
    }
}