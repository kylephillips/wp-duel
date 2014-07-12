# WP Duel


## Overview

**WP Duel** is a Wordpress plugin that pits two contenders against each other in a duel.

![Screenshot](https://raw.githubusercontent.com/kylephillips/wp-duel/master/screenshots/wpduel-duel.jpg)


#### Installation 
1. Upload the contents of /wpduel/ to the /wp-content/plugins/ directory
1. Activate WP Duel through the 'Plugins' menu in WordPress
1. Adjust settings as needed (see list below for a description of plugin settings)




#### Settings

* Settings are located under Settings > WP Duel.

| Option       | Description   
| ------------- |:-------------:
| Contender Post Type      | By default, a new post type of "contenders" is added. If you'd like to use another active post type, select it here. **IMPORTANT:** This setting should not be changed once duels are created. If so, new duels need to be created. 
| Output CSS      | If you'd like to apply custom styling, select No. SCSS files are provided for plugin styles under wpduel/assets/scss
| Output JS | Select "No" to disable plugin scripts. If "No" is selected, the form switch is replaced with standard radio inputs
| Highlight Color  |  Optional color customization.
| Limit Votes Using  |  Select how to limit user votes. This prevents users from voting for the same duel more than once
| Show Thumbnail  |  Show or hide the contender's post thumbnail
| Image Size | Choose either an existing image size, or set a custom image size. If thumbnail size is changed after adding contenders, post thumbnails will need to be regenerated.

![Screenshot](https://raw.githubusercontent.com/kylephillips/wp-duel/master/screenshots/wpduel-settings.jpg)

#### Usage
To display the duel form, include the shortcode ```[wp_duel_form]```. The form is automatically added to singular duel views.
