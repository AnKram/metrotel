<?php
class View
{
    //public $template_view; // todo: default view?

    function generate($content_view, $template_view, $data = null)
    {
        if(is_array($data)) {
            extract($data);
        }

        include VIEWS_PATH . $template_view;
    }
}