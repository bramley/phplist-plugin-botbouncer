# Botbouncer Plugin #

## Description ##

The plugin checks subscription emails and IP addresses for spam using the Botbouncer class <https://github.com/michield/botbouncer>.

It currently supports any combination of the following services:
* [Stop Forum Spam](https://www.stopforumspam.com/) (no registration required, enabled by default)
* [Akismet](https://akismet.com/) (free for personal use, commercial use paid)
* [Project Honeypot](https://www.projecthoneypot.org/) (free registration required)
* ~[Mollom](http://www.mollom.com/)~ (service ended)
* [IP Intel](https://getipintel.net/) (no registration required, limit 500 IPs/day)

If you have already installed the CAPTCHA plugin then you do not need this plugin because that plugin already includes
(most of) this functionality.

## Installation ##

### Install through phplist ###

The recommended way to install is through the Plugins page (menu Config > Manage plugins) using the package URL `https://github.com/bramley/phplist-plugin-botbouncer/archive/master.zip`.

Then enable the plugin.

### Install manually ###

If the automatic installation does not work then you can install manually. Download the plugin zip file from <https://github.com/bramley/phplist-plugin-botbouncer/archive/master.zip>

Expand the zip file, then copy the contents of the plugins directory to your phplist plugins directory.
This should contain

* the file BotBouncerPlugin.php
* the directory BotBouncerPlugin

Then enable the plugin.

## Usage ##

For guidance on configuring and using the plugin see the plugin's page within the phplist documentation site https://resources.phplist.com/plugin/botbouncer

## Test that it works ##

Go to <a href="https://www.stopforumspam.com/stats#datatable" target="_blank">Stop Forum Spam</a> and select an email
address from the Last 500 entries. Then try to subscribe to your lists using that email address.

## Support ##

Please raise any questions or problems in the user forum https://discuss.phplist.org/.


## Version history ##

    version        Description
    2.1.0+20220623 Update the botbouncer class. Now supports the IP Itel service.
    2.0.6+20220310 Restore the unix query parameter to the stopforumspam URL
    2.0.5+20220310 Ensure that the response from stopforumspam is serialised as expected. Closes #1
    2.0.4+20200512 Update link to Stop Forum Spam
    2.0.3+20200512 Belatedly update the botbouncer class
    2.0.2+20200512 Allow plugin to be enabled only when captcha plugin is not enabled
    2.0.1+20161014 Added dependencies
    2013-11-03     Initial version for phplist 3
