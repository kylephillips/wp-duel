# WP Duel


## Overview

**WP Duel** is a Wordpress plugin that pits two contenders against each other in a duel. Shortcodes are available for adding a randomized duel ```[wp_duel_form]```, or specific duels ```[wp_duel_form duel="1"]```. **WP Duel requires PHP v5.4 or higher**. Tested and compatible with Wordpress v3.9 or higher.

![Screenshot](https://raw.githubusercontent.com/kylephillips/wp-duel/master/screenshots/wpduel-duel.jpg)


### Installation 
1. Upload the contents of /wpduel/ to the /wp-content/plugins/ directory
1. Activate WP Duel through the 'Plugins' menu in WordPress
1. Adjust settings as needed (see list below for a description of plugin settings)




### Settings

* Settings are located under Settings > WP Duel. 

| Option       | Description   
| ------------- |:-------------:
| Contender Post Type      | By default, a new post type of "contenders" is added. If you'd like to use another active post type, select it here. **IMPORTANT:** This setting should not be changed once duels are created. If so, new duels need to be created. 
| Output CSS      | If you'd like to apply custom styling, select No. SCSS files are provided for plugin styles under wpduel/assets/scss
| Output JS | Select "No" to disable plugin scripts. If "No" is selected, the form switch is replaced with standard radio inputs
| Highlight Color  |  Optional color customization.
| Limit Votes Using  |  Select how to limit user votes. This prevents users from voting for the same duel more than once
| Display form on Post Type Singular View | Whether or not to display the form on the singular view for the post type selected for contenders. The shortcode can still be used.
| Show Thumbnail  |  Show or hide the contender's post thumbnail
| Image Size | Choose either an existing image size, or set a custom image size. If thumbnail size is changed after adding contenders, post thumbnails will need to be regenerated.

![Screenshot](https://raw.githubusercontent.com/kylephillips/wp-duel/master/screenshots/wpduel-settings.jpg)


## Creating Duels
To create a duel, first you must add at least 2 contenders. By default, contenders are available via the new post type created by the plugin ```Contenders```. If you have selected your own post type as the contender under the plugin settings, add them there.

Once the contenders have been created, a duel can be created by selecting **Duels > Add New Duel**. Select the contenders from the dropdown menus (they will be displayed in the order you select, so "Contender One" will be displayed first).

Contenders can be used across any number of duels. 

## Win Ratios
* **Form Results Display:** Win ratios on the form results represent the contenders' win ration for that specific duels. 
* **Records Display:** Ratios displayed in the records shortcode reflect the total win ratios across all duels.

## Shortcodes

####The Form####
To display the duel form, include the shortcode ```[wp_duel_form]```. The form result will display a "next duel" button, which will reload the page and load a new random duel that the user has not yet completed. If all duels have been completed by the user, an "All Completed" message is displayed.

An optional duel id may be passed to the shortcode to display the form for only that duel. 
```[wp_duel_form duel="1"]```

####Records####
To display a records listing, use the shortcode ```[wp_duel_records]```. A "per_page" parameter may by passed that limits the records to the provided number and adds pagination ```[wp_duel_records per_page="10"]```. All records are shown by default.

## Singular Duel Views
The form is automatically added to singular duel views. To prevent this, change the "Display form on singular posts" setting to "no" under Settings > WP Duel.

