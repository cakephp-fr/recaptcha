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
    protected $defaultLang = 'en';

    /**
     * Default theme
     * If no theme is found anywhere
     *
     * @var string
     */
    protected $defaultTheme = 'light';

    /**
     * Default type
     * If no type is found anywhere
     *
     * @var string
     */
    protected $defaultType = 'image';

    /**
     * Infos for Widgets
     *
     * @var array
     */
    protected $widgets;

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
     * Render the recaptcha div and js script.
     *
     * @param string $siteKey Key.
     * @param string $lang Lang.
     * @param string $theme Theme.
     * @param string $type Type.
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
     * Render the recaptcha div : multiple recaptcha
     *
     * @param int $id : Id
     * @param string $sitekey : Key
     * @param array $options
     * - theme : Theme
     * - type : Type
     * - lang : Langue
     * - callback : Callback
     *
     * @return string HTML
     */
    public function widget($id, $siteKey, array $options = [])
    {
        $defaultOptions = [
            'theme' => '',
            'type' => '',
            'lang' => '',
            'callback' => '',
            'action' => ''
        ];
        $options = array_merge($defaultOptions, $options);

        // add infos in widgets for script()
        $this->widgets[] = [
            'id' => $id,
            'siteKey' => $this->_siteKey($siteKey),
            'theme' => $this->_theme($options['theme']),
            'type' => $this->_type($options['type']),
            'lang' => $this->_language($options['lang']),
            'callback' => $options['callback'],
            'action' => $options['action'],
        ];

        $actions = [
            'getResponse' => "javascript:alert(grecaptcha.getResponse(widgetId" . $id . "));",
            'reset' => "javascript:grecaptcha.reset(widgetId" . $id . ");",
        ];

        $html = '';
        if (isset($actions[$options['action']])) {
            $html .= '<form action="' . $actions[$options['action']] . '">';
        }
        $html .= '<div id="example' . $id . '"></div>';
        if (isset($actions[$options['action']])) {
            $html .= '<br>
            <input type="submit" value="' . $options['action'] . '">
            </form>';
        }
        return $html;
    }

    /**
     * Define the script to render
     *
     * @return string js script
     */
    public function script()
    {
        $js = "<script type=\"text/javascript\">
        var verifyCallback = function(response) {
            alert(response);
        };";

        foreach ($this->widgets as $widget) {
            $js .= "var widgetId" . $widget['id'] . ";";
        }

        $js .= "var onloadCallback = function() {";
        foreach ($this->widgets as $widget) {
            $js .= "
                widgetId" . $widget['id'] . " = grecaptcha.render('example" . $widget['id'] . "', {
                    'sitekey' : '" . $widget['siteKey'] . "',
                    'theme' : '" . $widget['theme'] . "',
                    'lang' : '" . $widget['lang'] . "',
                    'callback' : " . $widget['callback'] . ",
                });
            ";
        }
        $js .= "};</script>";
        $js .= '<script src="https://www.google.com/recaptcha/api.js?onload=onloadCallback&render=explicit" async defer></script>';
        //debug($js);
        return $js;
    }

    /**
     * Define the language.
     * - First the one given in the display() method
     * - If empty : use default one from config file
     * - If empty : use I18n locale
     * - If not correct : use defaultLang var
     *
     * @param string $lang Lang.
     *
     * @return string Language in code 2 (fr, en, ...)
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
            $lang = $this->defaultLang;
        }
        return $lang;
    }

    /**
     * Define the siteKey
     * - First the one given in the display() method
     * - If empty : the default one from config file
     *
     * @param string $siteKey Key.
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
     * @param string $theme Theme.
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
            $theme = $this->defaultTheme;
        }
        return $theme;
    }

    /**
     * Define the type : either image or audio
     * - First the one given in the display() method
     * - If empty : the default one from config file
     * - If not correct : use defaultType var
     *
     * @param string $type Type.
     *
     * @return string type
     */
    protected function _type($type)
    {
        if (empty($type)) {
            $type = $this->config('type');
        }
        // in case the type is not in accepted types, the default type is chosen
        if (!in_array($type, $this->config('typeAccepted'))) {
            $type = $this->defaultType;
        }
        return $type;
    }
}
