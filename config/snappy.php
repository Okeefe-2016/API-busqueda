<?php

return array(


    'pdf' => array(
        'enabled' => true,
        'binary' => base_path('vendor/h4cc/wkhtmltopdf/bin/wkhtmltopdf.exe'),
        'timeout' => false,
        'options' => array(),
    ),
    'image' => array(
        'enabled' => true,
        'binary' => base_path('vendor/h4cc/wkhtmltopdf/bin/wkhtmltoimage.exe'),
        'timeout' => false,
        'options' => array(),
    ),


);
