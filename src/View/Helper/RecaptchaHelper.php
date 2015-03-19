<?php
/**
 * Recaptcha Helper
 *
 * @author   cake17
 * @license  http://www.opensource.org/licenses/mit-license.php The MIT License
 * @link     http://blog.cake-websites.com/
 *
 */
namespace Recaptcha\View\Helper;

use Cake\Core\Configure;
use Cake\I18n\I18n;
use Cake\View\Helper;
use Cake\View\View;

class RecaptchaHelper extends Helper
{
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
        // If no language is found anywhere
        'lang' => 'en',
        // If no theme is found anywhere
        'theme' => 'light',
        // If no type is found anywhere
        'type' => 'image',
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
     * Constructor
     *
     * @param View $view View
     * @param array $config Config
     *
     * @return void
     */
    public function __construct(View $view, $config = [])
    {
        parent::__construct($view, $config);

        // Merge Options given by user in config/recaptcha
        $configRecaptcha = Configure::read('Recaptcha');

        $this->config($configRecaptcha);
        // unset secret param
        $this->config('secret', '');
    }

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
    public function display(array $options = [])
    {
        //$this->config(array_merge($));
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
     * Return html
     *
     * @return string
     */
    public function render()
    {
        return $this->html();
    }

    /**
     * Render the recaptcha div : multiple recaptcha
     *
     * @param int $id Id
     * @param array $options Options
     * - sitekey : Site Key
     * - theme : Theme
     * - type : Type
     * - lang : Langue
     * - callback : Callback
     *
     * @return void
     */
    public function widget($id, array $options = [])
    {
        $options = array_merge($this->config(), $options);

        // add infos in widgets for script()
        $this->widgets[] = [
            'id' => $id,
            'sitekey' => $this->validate($options['sitekey'], 'sitekey'),
            'theme' => $this->validate($options['theme'], 'theme'),
            'type' => $this->validate($options['type'], 'type'),
            'lang' => $this->validate($options['lang'], 'lang'),
            'callback' => '',
            'action' => 'render',
        ];
    }

    /**
     * Define the html to render
     *
     * @return string html code
     */
    public function html()
    {
        $html = '';

        if (isset($this->widgets) && !empty($this->widgets)) {
            foreach ($this->widgets as $widget) {
                $actions = [
                    'getResponse' => "javascript:alert(grecaptcha.getResponse(id" . $widget['id'] . "));",
                    'reset' => "javascript:grecaptcha.reset(id" . $widget['id'] . ");",
                    'render' => '?'
                ];
                if (isset($actions[$widget['action']])) {
                    $html .= '<form action="' . $actions[$widget['action']] . '">';
                }
                $html .= '<div id="' . $widget['id'] . '"></div>';

                if (isset($actions[$widget['action']])) {
                    $html .= '<br>
                    <input type="submit" value="' . $widget['action'] . '">
                    </form>';
                }
            }
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

        if (isset($this->widgets) && !empty($this->widgets)) {
            foreach ($this->widgets as $widget) {
                $js .= "var id" . $widget['id'] . ";";
            }
        }

        $js .= "var onloadCallback = function() {";
        if (isset($this->widgets) && !empty($this->widgets)) {
            foreach ($this->widgets as $widget) {
                $js .= "
                    id" . $widget['id'] . " = grecaptcha.render('" . $widget['id'] . "', {
                        'sitekey' : '" . $widget['sitekey'] . "',
                        'theme' : '" . $widget['theme'] . "',
                        'lang' : '" . $widget['lang'] . "',
                        'callback' : " . $widget['callback'] . ",
                    });
                ";
            }
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
            $siteKey = $this->config('sitekey');
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

    /**
     * Validate a value given a name
     *
     * @param string $value Value to check
     * @param string $name Name of param to validate
     *
     * @return bool
     */
    protected function validate($value, $name)
    {
        switch ($name) {
            case 'lang':
                if (!in_array($value, $this->config('langAccepted'))) {
                    return false;
                }
                break;
            case 'theme':
                if (!in_array($value, $this->config('themeAccepted'))) {
                    return false;
                }
                break;
            case 'type':
                if (!in_array($value, $this->config('typeAccepted'))) {
                    return false;
                }
                break;
        }
        return true;
    }
}
