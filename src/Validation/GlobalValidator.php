<?php
/**
 * GlobalValidator
 *
 * @author   cake17
 * @license  http://www.opensource.org/licenses/mit-license.php The MIT License
 * @link     http://blog.cake-websites.com/
 */
namespace Recaptcha\Validation;

use Cake\Validation\Validator;

/**
 * Class used to validate global config data
 */
class GlobalValidator extends Validator
{
    /**
     * List of accepted Values
     *
     * @var array
     */
    protected $validList = [
        'lang' => [
            'ar',
            'af',
            'am',
            'hy',
            'az',
            'eu',
            'bn',
            'bg',
            'ca',
            'zh-HK',
            'zh-CN',
            'zh-TW',
            'hr',
            'cs',
            'da',
            'nl',
            'en-GB',
            'en',
            'et',
            'fil',
            'fi',
            'fr',
            'fr-CA',
            'gl',
            'ka',
            'de',
            'de-AT',
            'de-CH',
            'el',
            'gu',
            'iw',
            'hi',
            'hu',
            'is',
            'id',
            'it',
            'ja',
            'kn',
            'ko',
            'lo',
            'lv',
            'lt',
            'ms',
            'ml',
            'mr',
            'mn',
            'no',
            'fa',
            'pl',
            'pt',
            'pt-BR',
            'pt-PT',
            'ro',
            'ru',
            'sr',
            'si',
            'sk',
            'sl',
            'es',
            'es-419',
            'sw',
            'sv',
            'ta',
            'te',
            'th',
            'tr',
            'uk',
            'ur',
            'vi',
            'zu'
        ],
        'theme' => [
            'light',
            'dark'
        ],
        'type' => [
            'audio',
            'image'
        ],
        'size' => [
            'normal',
            'compact'
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
            ->add('lang', [
                'inLangList' => [
                    'rule' => ['inList', $this->validList['lang']],
                    'message' => __d('recaptcha', 'The lang should be in the following authorized lang ' . implode(',', $this->validList['lang'])),
                ]
            ])
            ->add('theme', [
                'inThemeList' => [
                    'rule' => ['inList', $this->validList['theme']],
                    'message' => __d('recaptcha', 'The theme should be in the following authorized theme ' . implode(',', $this->validList['theme'])),
                ]
            ])
            ->add('type', [
                'inTypeList' => [
                    'rule' => ['inList', $this->validList['type']],
                    'message' => __d('recaptcha', 'The type should be in the following authorized type ' . implode(',', $this->validList['type'])),
                ]
            ])
            ->add('size', [
                'inSizeList' => [
                    'rule' => ['inList', $this->validList['size']],
                    'message' => __d('recaptcha', 'The size should be in the following authorized type ' . implode(',', $this->validList['size'])),
                ]
            ]);
    }
}
