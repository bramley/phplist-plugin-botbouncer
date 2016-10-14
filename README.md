# Botbouncer Plugin #

## Description ##

The plugin checks subscription emails for spam using the Botbouncer class <https://github.com/michield/botbouncer>.
It currently uses only the Stop Forum Spam service to check email addresses, as that can be used without registering.
The other services supported by Botbouncer (Akismet, Project Honeypot, and Mollom) could be added if Stop Forum Spam 
proves not to be sufficient.


## Installation ##

### Dependencies ###

Requires php version 5.2 or later.

### Set the plugin directory ###
You can use a directory outside of the web root by changing the definition of `PLUGIN_ROOTDIR` in config.php.
The benefit of this is that plugins will not be affected when you upgrade phplist.

### Install through phplist ###
Install on the Plugins page (menu Config > Plugins) using the package URL `https://github.com/bramley/phplist-plugin-botbouncer/archive/master.zip`.

In phplist releases 3.0.5 and earlier there is a bug that can cause a plugin to be incompletely installed on some configurations (<https://mantis.phplist.com/view.php?id=16865>). 
Check that these files are in the plugin directory. If not then you will need to install manually. The bug has been fixed in release 3.0.6.

* the file BotBouncerPlugin.php
* the directory BotBouncerPlugin

### Install manually ###
Download the plugin zip file from <https://github.com/bramley/phplist-plugin-botbouncer/archive/master.zip>

Expand the zip file, then copy the contents of the plugins directory to your phplist plugins directory.
This should contain

* the file BotBouncerPlugin.php
* the directory BotBouncerPlugin

###Settings###

On the Settings page you can specify:

* The message to be displayed to the subscriber when the subscription attempt is rejected
* Whether to write a record to the event log for each failed subscription attempt
* Whether to send an email to the admin for each failed subscription attempt

###Test that it works###

Go to <a href="http://www.stopforumspam.com/" target="_blank">Stop Forum Spam</a> and select an email address from the Hot Spam list.
Then try to subscribe to your lists using that email address. 

## Version history ##

    version        Description
    2.0.1+20161014 Added dependencies
    2013-11-03     Initial version for phplist 3
