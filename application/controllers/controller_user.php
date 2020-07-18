<?php

class ControllerUser extends Controller
{
    public $model_user;

    private $email_pattern = '%^([A-Za-z0-9_\.-]+)@([A-Za-z0-9_\.-]+)\.([A-Za-z\.]{2,6})$%';
    private $login_pattern = '/^[A-Za-z0-9]+$/';
    private $pass_pattern = '/^S*(?=\S*[a-z])(?=\S*[\d])\S*$/';

    public function __construct()
    {
        $this->model_user = new ModelUser();
        parent::__construct();
    }

    public function actionLogin()
    {
        $this->view->generate('login_view.php', 'template_view.php');
    }

    public function actionRegistration()
    {
        //$data = $this->model->get_data();
        $this->view->generate('registration_view.php', 'template_view.php');
    }

    public function actionFormEndPoint(): void
    {
        if (!empty($_POST['data'])) {
            $data = json_decode($_POST['data'], true);
            if (!empty($data['form'])) {
                switch ($data['form']) {
                    case 'create':
                        // create user
                        $user_data = [];
                        $errors = [];

                        // check captcha
                        $captcha = Captcha::captchaRequest($data['captcha']);
                        if (!$captcha['success']) {
                            $errors['captcha'] = $captcha['error-codes'] ?? 'error';
                        }

                        if (!empty($data['user_pass']) && preg_match($this->pass_pattern, $data['user_pass'])) {
                            $user_data['pass'] = md5($data['user_pass']);
                        } else {
                            $errors['pass'] = 'incorrect';
                        }

                        if (!empty($data['user_login']) && preg_match($this->login_pattern, $data['user_login'])) {
                            $unique = $this->model_user->checkUniq($data['user_login'], 'login');
                            if ($unique) {
                                $user_data['login'] = $data['user_login'];
                            } else {
                                $errors['login'] = 'not uniq';
                            }
                        } else {
                            $errors['login'] = 'incorrect';
                        }

                        if (!empty($data['user_email']) && preg_match($this->email_pattern ,$data['user_email'])) {
                            $unique = $this->model_user->checkUniq($data['user_email'], 'email');
                            if ($unique) {
                                $user_data['email'] = $data['user_email'];
                            } else {
                                $errors['email'] = 'not uniq';
                            }
                        } else {
                            $errors['email'] = 'incorrect';
                        }

                        if (empty($errors)) {
                            $res = $this->model_user->setUser($user_data);

                            $_SESSION['user_id'] = $res;
                            $_SESSION['user_login'] = $user_data['login'];
                            $_SESSION['user_email'] = $user_data['email'];

                            echo json_encode(array('result' => 'ok', 'url' => '/contacts'));
                        } else {
                            echo json_encode(array('result' => 'error', 'errors' => $errors));
                        }

                        break;
                    case 'in':
                        // trying to get the user by the received data
                        $res = $this->getUser($data);

                        // check captcha
                        $captcha = Captcha::captchaRequest($data['captcha']);
                        if (!$captcha['success']) {
                            echo json_encode(array('result' => 'error', 'errors' => ['captcha' => $captcha['error-codes'] ?? 'error']));
                            break;
                        }

                        if (!empty($res['id'])) {
                            $_SESSION['user_id'] = $res['id'];
                            $_SESSION['user_login'] = $res['login'];
                            $_SESSION['user_email'] = $res['email'];
                            echo json_encode(array('result' => 'ok', 'url' => '/contacts'));
                        } else {
                            echo json_encode(array('result' => 'error', 'errors' => ['in' => 'error']));
                        }

                        break;
                    case 'exit':
                        unset($_SESSION['user_id']);
                        unset($_SESSION['user_login']);
                        unset($_SESSION['user_email']);
                        echo json_encode(array('result' => 'ok', 'url' => '/user/login'));
                        break;
                }
            }
        }
    }

    /**
     * @param array $data
     * @return array|null
     */
    public function getUser(array $data): ?array
    {
        $user_data['pass'] = md5($data['user_pass']);

        if (!empty($data['user_email']) && preg_match($this->email_pattern , $data['user_email'])) {
            $user_data['identify'] = 'email';
            $user_data['identify_val'] = $data['user_email'];
        } elseif (!empty($data['user_login']) && preg_match($this->login_pattern , $data['user_login'])) {
            $user_data['identify'] = 'login';
            $user_data['identify_val'] = $data['user_login'];
        } else {
            return null;
        }

        return $this->model_user->getUser($user_data);
    }
}