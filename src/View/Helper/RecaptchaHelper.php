<?php
/**
 * Recaptcha Helper
 *
 * @author   cake17
 * @license  http://www.opensource.org/licenses/mit-license.php The MIT License
 * @link     http://cake17.github.io/
 *
 */
namespace Recaptcha\View\Helper;

use Cake\I18n\I18n;
use Cake\View\Helper;
use Cake\View\View;

class RecaptchaHelper extends Helper
{
    /**
     * Default language
     * If no language is found anywhere
     *
     * @var string
     */
    protected $_defaultLang = 'en';

    /**
     * Default theme
     * If no theme is found anywhere
     *
     * @var string
     */
    protected $_defaultTheme = 'light';

    /**
     * Default type
     * If no type is found anywhere
     *
     * @var string
     */
    protected $_defaultType = 'image';

    /**
     * Default configuration.
     *
     * @var array
     */
    protected $_defaultConfig = [
        'secureApiUrl' => 'https://www.google.com/recaptcha/api',
        // reCAPTCHA supported 40+ languages listed here: https://developers.google.com/recaptcha/docs/language
        'langAccepted' => [
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
        'themeAccepted' => [
            'dark',
            'light'
        ],
        'typeAccepted' => [
            'audio',
            'image'
        ]
    ];

    /**
     * Render the recaptcha div and js script
     *
     * @return string HTML
     */
    public function display($siteKey = null, $lang = null, $theme = null, $type = null)
    {
        $lang = $this->_language($lang);
        $siteKey = $this->_siteKey($siteKey);
        $theme = $this->_theme($theme);
        $type = $this->_type($type);

        return '<div class="g-recaptcha" data-sitekey="' . $siteKey . '" data-theme="' . $theme . '" data-type="' . $type . '"></div>
        <script type="text/javascript"
        src="' . $this->config('secureApiUrl') . '.js?hl=' . $lang . '">
        </script>';
    }

    /**
     * Define the language
     * - First the one given in the display() method
     * - If empty : use default one from config file
     * - If empty : use I18n locale
     * - If not correct : use defaultLang var
     *
     * @return string language in code 2 (fr, en, ...)
     */
    protected function _language($lang)
    {
        if (empty($lang)) {
            $lang = $this->config('lang');
        }
        if (empty($lang)) {
            $lang = I18n::locale();
        }

        // in case the language is not in accepted languages, 'en' language is chosen
        if (!in_array($lang, $this->config('langAccepted'))) {
            $lang = $this->_defaultLang;
        }
        return $lang;
    }

    /**
     * Define the siteKey
     * - First the one given in the display() method
     * - If empty : the default one from config file
     *
     * @return string siteKey
     */
    protected function _siteKey($siteKey)
    {
        if (empty($siteKey)) {
            $siteKey = $this->config('siteKey');
        }
        return $siteKey;
    }

    /**
     * Define the theme : either dark or light
     * - First the one given in the display() method
     * - If empty : the default one from config file
     * - If not correct : use defaultTheme var
     *
     * @return string theme
     */
    protected function _theme($theme)
    {
        if (empty($theme)) {
            $theme = $this->config('theme');
        }
        // in case the theme is not in accepted themes, the default theme is chosen
        if (!in_array($theme, $this->config('themeAccepted'))) {
            $theme = $this->_defaultTheme;
        }
        return $theme;
    }

    /**
     * Define the type : either image or audio
     * - First the one given in the display() method
     * - If empty : the default one from config file
     * - If not correct : use defaultType var
     *
     * @return string type
     */
    protected function _type($type)
    {
        if (empty($type)) {
            $type = $this->config('type');
        }
        // in case the theme is not in accepted themes, the default theme is chosen
        if (!in_array($type, $this->config('typeAccepted'))) {
            $type = $this->_defaultType;
        }
        return $type;
    }
}
