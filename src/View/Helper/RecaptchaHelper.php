<?php
/**
 * Recaptcha Helper
 *
 * @author   cake17
 * @license  http://www.opensource.org/licenses/mit-license.php The MIT License
 * @link     http://blog.cake-websites.com/
 */
namespace Recaptcha\View\Helper;

use Cake\Core\Configure;
use Cake\I18n\I18n;
use Cake\View\Helper;
use Cake\View\View;
use Recaptcha\Validation\RecaptchaValidator;

class RecaptchaHelper extends Helper
{
    /**
     * Infos for Widgets
     *
     * @var array
     */
    protected $widgets;

    /**
     * SecureApiUrl
     *
     * @var string
     */
    protected static $secureApiUrl = "https://www.google.com/recaptcha/api";

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
        // If no size is found anywhere
        'size' => 'normal'
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
        $this->config(Configure::read('Recaptcha'));

        $lang = $this->config('lang');
        if (empty($lang)) {
            $this->config('lang', I18n::locale());
        }
        // Validate the Configure Data
        $validator = new RecaptchaValidator();
        $errors = $validator->errors($this->config());
        if (!empty($errors)) {
            throw new \Exception(__d('recaptcha', 'One of your recaptcha config value is incorrect'));
            // throw an exception with config error that is raised
        }

        // Make sure the secret param is
        $this->config('secret', '');
    }

    /**
     * Render the recaptcha div and js script.
     *
     * @param array $options Options.
     * - sitekey
     * - lang
     * - theme
     * - type
     *
     * @return string HTML
     */
    public function display(array $options = [])
    {
        // merge options
        $options = array_merge($this->config(), $options);

        // Validate the Configure Data
        $validator = new RecaptchaValidator();
        $errors = $validator->errors($options);
        if (!empty($errors)) {
            throw new \Exception(__d('recaptcha', 'One of your recaptcha config value is incorrect'));
            // throw an exception with config error that is raised
        }

        extract($options);

        return '<div class="g-recaptcha" data-sitekey="' . $sitekey . '" data-theme="' . $theme . '" data-type="' . $type . '" data-size="' . $size . '"></div>
        <script type="text/javascript"
        src="' . self::$secureApiUrl . '.js?hl=' . $lang . '">
        </script>';
    }

    /**
     * Return html
     *
     * @return string
     */
    public function render()
    {
        return $this->html() . $this->script();
    }

    /**
     * Create a recaptcha widget (for multiple widgets)
     *
     * @param array $options Options
     * - id : Id
     * - sitekey : Site Key
     * - theme : Theme
     * - type : Type
     * - lang : Langue
     *
     * @return void
     */
    public function widget(array $options = [])
    {
        $options = array_merge($this->config(), $options);

        // Validate the Configure Data
        $validator = new RecaptchaValidator();
        $errors = $validator->errors($options);
        if (!empty($errors)) {
            throw new \Exception(__d('recaptcha', 'One of your recaptcha config value is incorrect in a widget'));
            // throw an exception with config error that is raised
        }
        // add infos in widgets for script()
        $this->widgets[] = [
            'id' => $options['id'],
            'sitekey' => $options['sitekey'],
            'theme' => $options['theme'],
            'type' => $options['type'],
            'lang' => $options['lang'],
            'size' => $options['size']
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
                $html .= '<div id="' . $widget['id'] . '"></div>';
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
        $js = "<script type=\"text/javascript\">";

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
                        'size' : '" . $widget['size'] . "'
                    });
                ";
            }
        }
        $js .= "};</script>";
        $js .= '<script src="https://www.google.com/recaptcha/api.js?onload=onloadCallback&render=explicit" async defer></script>';
        //debug($js);
        return $js;
    }
}
