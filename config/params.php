<?php
return [
    'adminEmail' => 'app@changmeng.com',
    'page_size' => 20,  // 分页每页显示记录数
    'activeFormTpl' => [
        'form'  => ['options' => ['class' => 'form-horizontal'],
            'fieldConfig' => [
                'labelOptions' => ['class' => 'col-sm-2 control-label text-right'],
                'template' => "{label}<div class=\"col-sm-6\">{input}</div><div class=\"col-sm-4\">{hint}{error}</div>",
            ]],
        'radio' => ['template' => '{label}<div class="col-sm-6"><label class="radio">{input} </label></div><div class="col-sm-4">{hint}{error}</div>'],
        'select' => ['template' => '{label}<div class="col-sm-6"><label class="select">{input} </label></div><div class="col-sm-4">{hint}{error}</div>'],
        'checkbox' => ['template' => '{label}<div class="col-sm-6"><label class="checkbox">{input} </label></div><div class="col-sm-4">{hint}{error}</div>'],
    ],
    'table_desc' => [],
    //极验参数
    'geetest' => [
        'CAPTCHA_ID' => '4c2105da71d6b85e4f75a71ad9e36a11',
        'PRIVATE_KEY' => 'a8fcb8b743dcdb36d14c86dacec5aa5c',
    ],
    'domain' => [
        'first_domain' => '',
    ]
];