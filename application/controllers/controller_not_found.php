<?php

class ControllerNotFound extends Controller
{
    function actionIndex()
    {
        $this->view->generate('not_found_view.php', 'template_view.php');
    }
}