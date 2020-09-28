<?php 

namespace Drupal\seminar\Controller;

use Drupal\Core\Controller\ControllerBase;

class SeminarController extends ControllerBase {

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
    /**
     * Get details Seminar
     */
    public function getDetail(){
        return [
            '#theme' => 'my_template',
            '#test_var' => $this->t('Test Value'),
          ];
    }
    public function getFormDetail(){

        $form = $this->formBuilder('\Drupal\seminar\Form\SeminarDetailForm');
        return [
            '#form' => $form,
          ];
    }
}