<?php

class ControllerContacts extends Controller
{
    private $model_contacts;

    private $email_pattern = '%^([A-Za-z0-9_\.-]+)@([A-Za-z0-9_\.-]+)\.([A-Za-z\.]{2,6})$%';

    private $sort_values = array(
        'name' => 'По имени',
        'surname' => 'По фамилии',
        'date_added' => 'По дате добавления'
    );

    private $sequence_values = array(
        'ASC' => 'По возрастанию',
        'DESC' => 'По убыванию'
    );

    private const MAX_FILE_SIZE = 2097152;
    private const FILE_TYPES = array(
        'image/jpeg' => 'jpg',
        'image/png' => 'png'
    );

    private $file_errors = array(
        'size' => 'Сликом большой размер файла',
        'type' => 'Неверный тип файла. Только jpeg или png',
        'load' => 'На сервере возникла ошибка с загрузкой картинки'
    );

    public function __construct()
    {
        $this->model_contacts = new ModelContacts();
        parent::__construct();
    }

    public function actionIndex(): void
    {
        if (!empty($_SESSION['user_id'])) {
            $data = [];
            /* this code for sorting with GET params

            $data['sort_selected'] = !empty($_GET['sort']) && in_array($_GET['sort'], array_keys($this->sort_values)) ? $_GET['sort'] : 'name';
            $data['sequence_selected'] = !empty($_GET['sequence']) && in_array($_GET['sequence'], array_keys($this->sequence_values)) ? $_GET['sequence'] : 'ASC';

            $data = [];
            $data['list'] = $this->model_contacts->getContactListByUserId($_SESSION['user_id'], $sort, $sequence);

            $data['sort'] = $this->sort_values;
            $data['sort_selected'] = $sort;
            $data['sequence'] = $this->sequence_values;
            $data['sequence_selected'] = $sequence;

            */

            $data['sort_selected'] = 'name';
            $data['sequence_selected'] = 'ASC';

            $data['list'] = $this->model_contacts->getContactListByUserId($_SESSION['user_id'], $data['sort_selected'], $data['sequence_selected']);

            $data['sort'] = $this->sort_values;
            $data['sequence'] = $this->sequence_values;

            $this->view->generate('list_view.php', 'template_view.php', $data);
        } else {
            header($this->getLocation('user', 'login'));
        }
    }

    public function actionAjaxSort(): void
    {
        if (!empty($_POST)) {
            $data = [];

            $data['sort_selected'] = !empty($_POST['sort']) && in_array(
                $_POST['sort'],
                array_keys($this->sort_values)
            ) ? $_POST['sort'] : 'name';
            $data['sequence_selected'] = !empty($_POST['sequence']) && in_array(
                $_POST['sequence'],
                array_keys($this->sequence_values)
            ) ? $_POST['sequence'] : 'ASC';

            $data['list'] = $this->model_contacts->getContactListByUserId($_SESSION['user_id'], $data['sort_selected'], $data['sequence_selected']);

            $data['sort'] = $this->sort_values;
            $data['sequence'] = $this->sequence_values;

            $data['upload_path'] = UPLOADS_PATH;

            echo(json_encode(array('result' => true, 'data' => $data)));
        }
    }

    /**
     * @param int $id
     */
    public function actionItem(int $id): void
    {
        if (!empty($_SESSION['user_id'])) {
            $data = $this->model_contacts->getContactById($_SESSION['user_id'], $id);

            if (is_null($data) || empty($data)) {
                Route::ErrorPage404();
            }

            if (!empty($data['first_number'])) {
                $data['num1_str'] = strlen((string)$data['first_number']) < 12 ? $this->numberToString($data['first_number']) : 'Слишком длинный номер';
            }

            if (!empty($data['second_number'])) {
                $data['num2_str'] = strlen((string)$data['second_number']) < 12 ? $this->numberToString($data['second_number']) : 'Слишком длинный номер';
            }

            $this->view->generate('contact_view.php', 'template_view.php', $data);
        } else {
            header($this->getLocation('user', 'login'));
        }
    }

    public function actionNew(): void
    {
        if (!empty($_SESSION['user_id'])) {
            $data['title'] = 'Новый контакт';
            $data['action'] = 'create';
            $this->view->generate('contact_form_view.php', 'template_view.php', $data);
        } else {
            header($this->getLocation('user', 'login'));
        }
    }

    public function actionUpdate(int $id): void
    {
        if (!empty($_SESSION['user_id'])) {
            $data = $this->model_contacts->getContactById($_SESSION['user_id'], $id);
            if (is_null($data) || empty($data)) {
                Route::ErrorPage404();
            }
            $data['title'] = 'Изменение контакта';
            $data['action'] = 'update';
            $this->view->generate('contact_form_view.php', 'template_view.php', $data);
        } else {
            header($this->getLocation('user', 'login'));
        }
    }


    public function actionContactEndPoint(): void
    {
        if (!empty($_POST)) {
            $data = $_POST;

            if (!empty($data['action'])) {
                switch ($data['action']) {
                    case 'create':
                        // create contact
                        $errors = [];

                        $image = $this->checkImage();
                        if ($image['result']) {
                            $data['image'] = $image['file'];
                        } elseif ($image['error']) {
                            $errors['file'] = $image['error'];
                        }

                        // validate name
                        if (!$this->validate($data['name'])) {
                            $errors['name'] = 'incorrect';
                        }
                        // validate email
                        // if the email is empty - the contact will be created,
                        // but if the email is not empty and invalid, it will cause an error
                        if (!empty($data['email']) && !$this->validate($data['email'], 'email')) {
                            $errors['email'] = 'incorrect';
                        }

                        $data['user_id'] = $_SESSION['user_id'];

                        if (!empty($errors)) {
                            echo json_encode(array('result' => 'error', 'errors' => $errors));
                        } elseif ($this->model_contacts->createContact($data)) {
                            echo json_encode(array('result' => 'ok', 'url' => '/contacts'));
                        } else {
                            echo json_encode(array('result' => 'error', 'comment' => 'createContact method returned false'));
                        }

                        break;
                    case 'update':
                        // upload contact
                        $errors = [];

                        $image = $this->checkImage();
                        if ($image['result']) {
                            $data['image'] = $image['file'];
                        } elseif ($image['error']) {
                            $errors['file'] = $image['error'];
                        }

                        if (!$this->validate($data['name'])) {
                            $errors['name'] = 'incorrect';
                        }

                        if (!empty($data['email']) && !$this->validate($data['email'], 'email')) {
                            $errors['email'] = 'incorrect';
                        }
                        if (!empty($errors)) {
                            echo json_encode(array('result' => 'error', 'errors' => $errors));
                        } elseif ($this->model_contacts->updateContact($data)) {
                            echo json_encode(array('result' => 'ok', 'url' => '/contacts'));
                        } else {
                            echo json_encode(array('result' => 'error'));
                        }

                        break;
                    case 'delete':
                        // delete contact
                        $res = $this->model_contacts->delContact($data['id']);
                        if ($res) {
                            echo json_encode(array('result' => 'ok', 'url' => '/contacts'));
                        } else {
                            echo json_encode(array('result' => 'error'));
                        }
                        break;
                }
            }
        }
    }

    /**
     * @return array|null
     */
    private function checkImage(): array
    {
        if (empty($_FILES)) {
            return array('result' => false, 'error' => '');
        }

        $new_file_name = md5($_FILES['file']['tmp_name'] . time()) . '.' . self::FILE_TYPES[$_FILES['file']['type']];

        if ($_FILES['file']['size'] > self::MAX_FILE_SIZE) {
            return array('result' => false, 'error' => $this->file_errors['size']);
        } elseif (!in_array($_FILES['file']['type'], array_keys(self::FILE_TYPES))) {
            return array('result' => false, 'error' => $this->file_errors['type']);
        } elseif (move_uploaded_file($_FILES['file']['tmp_name'], R_PATH . UPLOADS_PATH . $new_file_name)) {
            $data['image'] = $new_file_name;
            return array('result' => true, 'file' => $new_file_name);
        }
        return array('result' => false, 'error' => $this->file_errors['load']);
    }

    /**
     * @param string $string
     * @param string $type
     * @return bool
     */
    private function validate(string $string, string $type = 'name'): bool
    {
        if (empty($string)) {
            return false;
        }

        if ($type === 'email') {
            return preg_match($this->email_pattern, $string);
        }

        return true;
    }

    /**
     * @param $num
     * @return string
     */
    private function numberToString(int $num): string
    {
        static $dic = array(
            array(
                -2 => 'две',
                -1 => 'одна',
                1 => 'один',
                2 => 'два',
                3 => 'три',
                4 => 'четыре',
                5 => 'пять',
                6 => 'шесть',
                7 => 'семь',
                8 => 'восемь',
                9 => 'девять',
                10 => 'десять',
                11 => 'одиннадцать',
                12 => 'двенадцать',
                13 => 'тринадцать',
                14 => 'четырнадцать',
                15 => 'пятнадцать',
                16 => 'шестнадцать',
                17 => 'семнадцать',
                18 => 'восемнадцать',
                19 => 'девятнадцать',
                20 => 'двадцать',
                30 => 'тридцать',
                40 => 'сорок',
                50 => 'пятьдесят',
                60 => 'шестьдесят',
                70 => 'семьдесят',
                80 => 'восемьдесят',
                90 => 'девяносто',
                100 => 'сто',
                200 => 'двести',
                300 => 'триста',
                400 => 'четыреста',
                500 => 'пятьсот',
                600 => 'шестьсот',
                700 => 'семьсот',
                800 => 'восемьсот',
                900 => 'девятьсот'
            ),
            array(
                array(''),
                array('тысяча', 'тысячи', 'тысяч'),
                array('миллион', 'миллиона', 'миллионов'),
                array('миллиард', 'миллиарда', 'миллиардов'),
            ),
            // pluralization map
            array(2, 0, 1, 1)
        );

        $result = array();

        // 1 => 001
        $num = str_pad($num, ceil(strlen($num) / 3) * 3, 0, STR_PAD_LEFT);

        $parts = array_reverse(str_split($num, 3));

        foreach ($parts as $i => $part) {
            if ($part > 0) {
                $digits = array();

                if ($part > 99) {
                    $digits[] = floor($part / 100) * 100;
                }

                if ($mod1 = $part % 100) {
                    $mod2 = $part % 10;
                    $flag = $i == 1 && $mod1 != 11 && $mod1 != 12 && $mod2 < 3 ? -1 : 1;
                    if ($mod1 < 20 || !$mod2) {
                        $digits[] = $flag * $mod1;
                    } else {
                        $digits[] = floor($mod1 / 10) * 10;
                        $digits[] = $flag * $mod2;
                    }
                }

                $last = abs(end($digits));

                foreach ($digits as $j => $digit) {
                    $digits[$j] = $dic[0][$digit];
                }

                $digits[] = $dic[1][$i][(($last %= 100) > 4 && $last < 20) ? 2 : $dic[2][min($last % 10, 5)]];

                array_unshift($result, join(' ', $digits));
            }
        }

        return join(' ', $result);
    }
}