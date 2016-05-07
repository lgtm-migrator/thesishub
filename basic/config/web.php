<?php

$params = require(__DIR__ . '/params.php');

$config = [
    'id' => 'basic',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'components' => [
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => 'UhavzgH7dauiewg0vFYXlX74f-agEyr0',
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'user' => [
            'identityClass' => 'app\models\User',
            // 'identityClass' => 'mdm\admin\models\User',
            'loginUrl' => ['/auth/login'],
            'enableAutoLogin' => true,
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            // send all mails to a file by default. You have to set
            // 'useFileTransport' to false and configure a transport
            // for the mailer to send real emails.
            'useFileTransport' => true,
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'db' => require(__DIR__ . '/db.php'),
        
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
            ],
        ],
        'authManager' => [
            'class' => 'yii\rbac\PhpManager', // or use 'yii\rbac\DbManager'
        ],
        'settings' => [
            'class' => 'pheme\settings\components\Settings'
        ],
    ],

    'as access' => [
        'class' => 'mdm\admin\components\AccessControl',
        'allowActions' => [
            '*',
            'site/*',
            'system_role/*',
            'admin/*',
            // 'some-controller/some-action',
            // The actions listed here will be allowed to everyone including guests.
            // So, 'admin/*' should not appear here in the production, of course.
            // But in the earlier stages of your development, you may probably want to
            // add a lot of actions here until you finally completed setting up rbac,
            // otherwise you may not even take a first step.
        ]
    ],

    'layout' => 'one-column',
    'defaultRoute' => 'home/index',

    'params' => $params,
    'modules' => [
        'admin' => [
            'class' => 'app\modules\admin\Module',
        ],
        'system_role' => [
            'class' => 'mdm\admin\Module',
            'layout' => 'left-menu',
            'mainLayout' => '@app/views/layouts/main.php',
            'controllerMap' => [
                'assignment' => [
                    'class' => 'mdm\admin\controllers\AssignmentController',
                    'userClassName' => 'app\models\User',
                    'idField' => 'user_id',
                    'usernameField' => 'username',
                    'fullnameField' => 'name',
                    'extraColumns' => [
                        [
                            'attribute' => 'subject',
                            'label' => 'Subject',
                            'value' => function($model, $key, $index, $column) {
                                return $model->subject;
                            },
                        ],[
                            'attribute' => 'is_lecture',
                            'label' => 'Is Lecture',
                            'value' => function($model, $key, $index, $column) {
                                return $model->is_lecture ? 'True' : 'False';
                            },
                        ],
                    ],
                    'searchClass' => 'app\models\UserSearch'
                ],
                
            ],
            'menus' => [
                'assignment' => [
                    'label' => 'Grand Access' // change label
                ],

            ]
        ],
        'settings' => [
            'class' => 'pheme\settings\Module',
            'sourceLanguage' => 'en'
        ],
    ],

];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    // $config['bootstrap'][] = 'debug';
   
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
    ];
}

return $config;
