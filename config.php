<?php

/**
 * database connection
 * @return array
 */
function getConfigData() {
    return [
        'db_host' => 'localhost',
        'db_user' => 'root',
        'db_pass' => '',
        'db_name' => 'test_database'
    ];
}

/* paths */

define('R_PATH', 'C:/OSPanel/domains/localhost/');

define('VIEWS_PATH', 'application/views/');
define('MODELS_PATH', 'application/models/');
define('CONTROLLERS_PATH', 'application/controllers/');
define('UPLOADS_PATH', 'uploads/');
