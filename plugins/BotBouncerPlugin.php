<?php
/**
 * BotBouncerPlugin for phplist.
 *
 * This file is a part of BotBouncerPlugin.
 *
 * @category  phplist
 *
 * @author    Duncan Cameron
 * @copyright 2011-2020 Duncan Cameron
 * @license   http://www.gnu.org/licenses/gpl.html GNU General Public License, Version 3
 */
/**
 * This class registers the plugin with phplist.
 */
class BotBouncerPlugin extends phplistPlugin
{
    const VERSION_FILE = 'version.txt';

    /*
     *  Inherited variables
     */
    public $name = 'Bot Bouncer Plugin';
    public $enabled = true;
    public $description = 'Check subscriber email addresses for spam using the Botbouncer class';
    public $authors = 'Duncan Cameron';
    public $settings = array(
        'botbouncer_message' => array(
            'value' => 'You cannot subscribe with this email address',
            'description' => 'Message to be displayed when subscription is rejected',
            'type' => 'text',
            'allowempty' => 0,
            'category' => 'Bot Bouncer',
        ),
        'botbouncer_eventlog' => array(
            'description' => 'Whether to log event for each rejected subscription',
            'type' => 'boolean',
            'value' => '1',
            'allowempty' => true,
            'category' => 'Bot Bouncer',
        ),
        'botbouncer_copyadmin' => array(
            'description' => 'Whether to send an email to the admin for each rejected subscription',
            'type' => 'boolean',
            'value' => '0',
            'allowempty' => true,
            'category' => 'Bot Bouncer',
        ),
        'botbouncer_validate_subscribe_page' => array(
            'description' => 'Whether to validate email address submitted on the subscribe page',
            'type' => 'boolean',
            'value' => '1',
            'allowempty' => true,
            'category' => 'Bot Bouncer',
        ),
        'botbouncer_validate_asubscribe_page' => array(
            'description' => 'Whether to validate email address submitted on the asubscribe (AJAX) page',
            'type' => 'boolean',
            'value' => '1',
            'allowempty' => true,
            'category' => 'Bot Bouncer',
        ),
    );

    private function sendAdminEmail($text)
    {
        $body = <<<END
A subscription attempt has been rejected by the BotBouncer plugin.

$text
END;
        sendAdminCopy(s('subscription rejected by BotBouncer'), $body);
    }

    public function __construct()
    {
        $this->coderoot = dirname(__FILE__) . '/' . __CLASS__ . '/';
        $this->version = (is_file($f = $this->coderoot . self::VERSION_FILE))
            ? file_get_contents($f)
            : '';
        parent::__construct();
    }

    /**
     * Provide the dependencies for enabling this plugin.
     *
     * @return array
     */
    public function dependencyCheck()
    {
        return array(
            'curl extension installed' => extension_loaded('curl'),
            'CAPTCHA Plugin must not also be installed' => !phpListPlugin::isEnabled('CaptchaPlugin'),
        );
    }

    public function validateSubscriptionPage($pageData)
    {
        global $tmpdir;

        require_once $this->coderoot . 'botbouncer.php';

        if (!isset($_POST['email'])) {
            return '';
        }

        // Disable validation if configured as such
        if ($_REQUEST['p'] == 'asubscribe' && !getConfig('botbouncer_validate_asubscribe_page')) {
            return '';
        }

        if ($_REQUEST['p'] == 'subscribe' && !getConfig('botbouncer_validate_subscribe_page')) {
            return '';
        }

        $bb = new Botbouncer();
        $bb->setLogRoot($tmpdir);
        $params = array(
            'email' => $_POST['email'],
        );

        if (isset($_SERVER['REMOTE_ADDR'])) {
            $params['ips'] = array($_SERVER['REMOTE_ADDR']);
        }
        $isSpam = $bb->isSpam($params);

        if ($isSpam) {
            $text = "spam subscription: {$_POST['email']}  $bb->matchedOn $bb->matchedBy";

            if (getConfig('botbouncer_eventlog')) {
                logEvent($text);
            }

            if (getConfig('botbouncer_copyadmin')) {
                $this->sendAdminEmail($text);
            }

            return getConfig('botbouncer_message');
        }

        return '';
    }
}
