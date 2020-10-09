<?php

namespace Drupal\seminar\Controller;

use Drupal\Core\Controller\ControllerBase;
use Symfony\Component\HttpFoundation\JsonResponse;
use Drupal\Core\Database\Database;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Connection\Database\Connection;

/**
 * Provides route responses for the Example module.
 */
class SeminarController extends ControllerBase
{
    protected $request;
    protected $formBuilder;
    protected $session;
    protected $user;
    protected $conn;

    public function __construct()
    {
        $this->request = \Drupal::request();
        $this->formBuilder = \Drupal::formBuilder();
        $this->session = \Drupal::request()->getSession();
        $this->user = \Drupal::currentUser();
        $this->conn = Database::getConnection();
    }

    public function getForm()
    {
        $registrationForm = $this->formBuilder->getForm('Drupal\seminar\Form\RegisterSeminarForm');
        return [
            '#theme' => 'formregistration',
            '#form' => $registrationForm,
        ];
    }

    public function confirm()
    {
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
        $last_id = $this->saveData($seminar, 'seminar_registration');
        if ($last_id) {
            $message = t('Confirm Succerss');
        } else {
            $message = t('Confirm fail');
        }
        return [
            '#type' => 'markup',
            '#markup' => $message,
        ];
    }

    public function test()
    {
        $taxonomyGender = \Drupal::entityTypeManager()->getStorage('taxonomy_term')->loadTree('t_gender');
        print_r($taxonomyGender);
        return [
            '#type' => 'markup',
            '#markup' => t('This aaa'),
        ];
    }

    protected function saveData(array $args, $table)
    {
        $id = $this->conn->insert($table)->fields($args)->execute();
        return $id;
    }

    public function listRegister($node) {
        return [  
            '#type' => 'markup',
            '#markup' => t('This aaa'),
        ];
    }
}
