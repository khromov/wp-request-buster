# wp-request-buster

Find themes and plugins that are (ab)using wp_remote functions to slow down your site (WordPress plugin)

### Screenshots

![Request Buster screenshot](https://dl.dropboxusercontent.com/u/2758854/request-buster.png)


### Preface

WordPress has functions for getting remote resources (internally using cURL or file_get_contents())
Whenever these functions (such as wp_remote_get()) run during a page load request, they will slow down your site, because WordPress has to wait for the external request before returning the page. This is bad practice, yet so many plugins and themes use it. Debugging is notoriously hard because requests appear only occasionally (they are often cached via the Transients API).

Request Buster is a plugin that shows you in the top admin bar if any remote requests were triggered by the current page load. Keeping it open as you develop and use your site will let you find plugins that make remote requests.

The correct way to handle loading of remote resources are:
* Serving the page and grabbing the remote resource via AJAX **OR**
* Schedule the remote request to go through WP CRON.

### Instructions

* Place request-buster.php in /wp-content/mu-plugins/ (Create the folder if it does not exist)
* Check the top admin bar to find pages that trigger remote requests
* Remove the naughty plugins, or even better - submit a support thread with the author so it can be fixed.
