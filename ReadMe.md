Looplet is a WordPress code library that lets you create simple and reusable patterns from within a customizable loop. It uses custom fields to allow you to customize your loop and add HTML, PHP, and CSS. This loop is pulled from the custom post type “Looplet” which can be modified or added to in order to increase the pool of content you can draw from. Looplet breaks down into two parts.

A demo can be found at [http://www.wpjay.com/looplet](http://www.wpjay.com/looplet)

###The Looplet Theme
The Looplet theme includes the core functionality of Looplet, including custom meta boxes and custom fields. To install:

1. Drag and drop the “looplet-theme” folder to your themes directory in WordPress (/wp-content/themes).
2. In the admin menu, click on **Appearance -> Themes** and activate the Looplet Theme.

###The Looplet Companion Plugin
The Looplet plugin does two things. First, it installs the custom post type “Looplet.” Second, it imports 10 dummy posts into this post type so that it is ready to use. Of course, you can and should go into that post type and add all the content you like to add within this Loop, but this plugin will get you started. *If the plugin is deactivated, all posts within “Looplet” will be deleted to allow for a quick restart.* To install.

1. Drag and drop the “looplet-plugin” folder to your plugins directory in WordPress (/wp-content/plugins).
2. In the admin menu, click on **Plugins** and activate the “Looplet Companion”

###To Add Code Patterns
You can use regular old posts to create new code patterns. The HTML/PHP and CSS boxes are used for you custom code and the main content area can be used for notes.

1. Add a new post.
2. Set your Loop parameters (limited right now, working on adding others).
3. Add HTML/PHP. You can use any familiar WordPress funciton you would normally use within the Loop. Make sure to include <?php or ?> at the beginning and end.
4. Add custom CSS.

The posts will be automatically added to your navigation. In order to group different posts together in the navigation, simply create a new category and add your desired posts.

###Credits
This project truly stands on the shoulders of the much-more-talented. A speical thanks to:

Dan Ciederholm - His [Pears](http://pea.rs/) theme was inspiration for this idea, as well as the foundation for a good amount of the code base.

Tom McFarlin - The [Plugin Boilerplate](https://github.com/tommcfarlin/WordPress-Plugin-Boilerplate) Tom built rocks. That is all.

###Areas of Improvement
I’m still working on a bunch of new features for this. Prime among them is:

1. Fully customizable Loop.
2. Sanitize and Parse PHP code properly
3. Import Featured Post Images with dummy content

If anybody has any suggestions or would like to help, post an issue, submit a pull request or [get in touch](mailto:jhoffm34@gmail.com)

###License
The Looplet Theme and Plugin are liscensed under the GPL v3 or later

>This program is free software: you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation, either version 3 of the License, or
    (at your option) any later version.

>This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

>You should have received a copy of the GNU General Public License
    along with this program.  If not, see <http://www.gnu.org/licenses/>.