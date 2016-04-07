# PatternableValidator plugin for CakePHP 3

## Installation

You can install this plugin into your CakePHP application using [composer](http://getcomposer.org).

The recommended way to install composer packages is:

```
composer require k1low/patternable-validator
```

## Usage

### Before

```php
<?php
namespace App\Model\Table;

class UsersTable extends AppTable
{
    public function validationDefault(Validator $validator)
    {
        $validator
            ->integer('id')
            ->allowEmpty('id', 'create');
            
        $validator
            ->allowEmpty('username')
            ->add('username', 'minLength4', [
                'rule' => ['minLength', 4],
                'message' => __('Validation Error: minLength4'),
            ])
            ->add('username', 'maxLength10', [
                'rule' => ['maxLength', 10],
                'message' => __('Validation Error: maxLength10'),
            ]);

        $validator
            ->allowEmpty('password');
    }
}
```

### After

```php
<?php
namespace App\Model\Table;

class UsersTable extends AppTable
{
    public function validationDefault(Validator $validator)
    {
        $validator
            ->addPattern('id', ['integer', 'allowEmptyWhenCreate']);

        $validator
            ->addPattern('username', ['allowEmpty', 'username_length']);
        
        $validator
            ->appPattern('password', ['allowEmpty']);
    }
}
```

AppTable settings:

```php
<?php
namespace App\Model\Table;

class AppTable extends Table
{
    public function initialize(array $config)
    {
        parent::initialize($config);
        $this->_validatorClass = '\PatternedValidator\Validation\Validator';
        \PatternedValidator\Validation\Validator::$validationPatterns = [
            'username_length' => [
                'minLength4' => [
                    'rule' => ['minLength', 4],
                    'message' => __('Validation Error: minLength4'),
                ],
                'maxLength10' => [
                    'rule' => ['maxLength', 10],
                    'message' => __('Validation Error: maxLength10'),
                ]
            ],
        ];
    }
}
```

## for CakePHP 2

see [cakeplus/ValidationPatternsBehavior.php](https://github.com/ichikaway/cakeplus/blob/2.0/Model/Behavior/ValidationPatternsBehavior.php)
