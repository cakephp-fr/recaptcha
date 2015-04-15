<?php
/**
 * ConfigValidator
 *
 * @author   cake17
 * @license  http://www.opensource.org/licenses/mit-license.php The MIT License
 * @link     http://blog.cake-websites.com/
 */
namespace Recaptcha\Validation;

use Cake\Validation\Validator;

/**
 * Class used to validate config data
 */
class ConfigValidator extends Validator
{
    /**
     * List of accepted Values
     *
     * @var array
     */
    protected $validList = [
        'lang' => [
            'ar',
            'bg',
            'ca',
            'zh-CN',
            'zh-TW',
            'hr',
            'cs',
            'da',
            'nl',
            'en-GB',
            'en',
            'fil',
            'fi',
            'fr',
            'fr-CA',
            'de',
            'de-AT',
            'de-CH',
            'el',
            'iw',
            'hi',
            'hu',
            'id',
            'it',
            'ja',
            'ko',
            'lv',
            'lt',
            'no',
            'fa',
            'pl',
            'pt',
            'pt-BR',
            'pt-PT',
            'ro',
            'ru',
            'sr',
            'sk',
            'sl',
            'es',
            'es-419',
            'sv',
            'th',
            'tr',
            'uk',
            'vi'
        ],
        'type' => [
            'audio',
            'image'
        ],
        'theme' => [
            'light',
            'dark'
        ]
    ];

    /**
     * Constructor
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        $this
            // ->requirePresence('secret')
            //->notEmpty('secret', __d('recaptcha', 'A secret should not be blank.'))
            ->add('lang', [
                'inList' => [
                    'rule' => ['inList', $this->validList['lang']],
                    'message' => __d('recaptcha', 'The lang should be in the following authorized lang ' . implode(',', $this->validList['lang'])),
                ]
            ])
            ->add('theme', [
                'inList' => [
                    'rule' => ['inList', $this->validList['theme']],
                    'message' => __d('recaptcha', 'The theme should be in the following authorized theme ' . implode(',', $this->validList['theme'])),
                ]
            ])
            ->add('type', [
                'inList' => [
                    'rule' => ['inList', $this->validList['type']],
                    'message' => __d('recaptcha', 'The type should be in the following authorized type ' . implode(',', $this->validList['type'])),
                ]
            ]);
    }
}
