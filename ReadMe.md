Looplet is a WordPress code library that lets you create simple and reusable patterns from within a customizable loop. It uses custom fields to allow you to customize your loop and add HTML, PHP, and CSS. This loop is pulled from the custom post type “Looplet” which can be modified or added to in order to increase the pool of content you can draw from. 

Looplet is primarly an educational tool. It features prominent inline documentation to help new developers learn how to navigate the WordPress loop and for expereinced developers to catalog and organize common patterns. That might mean a simple grid of posts you’ve coded a thousand times or a list of titles organized by date. Through Looplet, you can learn what comprises a WordPress loop in isolation, without risking everything falling to pieces.

A demo can be found at [http://www.wpjay.com/looplet](http://www.wpjay.com/looplet)

###The Looplet Companion Plugin
First, it is best to install the Looplet companion plugin. To do this: 

1. Drag and drop the “looplet-plugin” folder to your plugins directory in WordPress (/wp-content/plugins).
2. In the admin menu, click on **Plugins** and activate the “Looplet Companion”

What this will do is install the custom post type “Looplet.” This is the post type that is used by the theme in order to create a customizable, secondary Loop. It will then load dummy posts into this custom post type with filler content. Each post will have a title, a featured image, some content, a category and two tags applied to it. That way, you can start using the Looplet theme right away. *The best part is, If the plugin is deactivated, all posts and images within “Looplet” will be deleted to allow for a quick restart.* 

###The Looplet Theme
The Looplet theme includes the core functionality of Looplet. Each post you create on the theme will feature a single Loop pattern, with the HTML, PHP and CSS listed out beneath it. This will allow you to easily flip from post to post, and copy and paste any code you need from each pattern. To install:

1. Drag and drop the “looplet-theme” folder to your themes directory in WordPress (/wp-content/themes).
2. In the admin menu, click on **Appearance -> Themes** and activate the Looplet Theme.

###Using Looplet
Each new post will create a new pattern on your main page. The pattern itself, HTML/CSS, PHP, Loop and Output HTML are automatically generated based on parameters that you set. When you create a new post, you will be greeted with this screen:

The main content editor is reserved for any notes you would like to add to the pattern, so let’s skip that for now. Below this you will see a metabox containing several text fields. This is what you will use to create your pattern.

####HTML/PHP Before The Loop
The first text area is for any HTML or PHP that you would like to run before the Loop actually begins. This is a good place to begin your list with a `<ul>` tag for instance. It can also be used to set-up a quick function you would like to incorporate into your pattern.

![HTML Before the loop](https://raw.github.com/JasonHoffmann/looplet/master/screenshots/HTMLbeforetheloop.png)

####Main Loop
The next grouping of fields is the parameters for your loop. This is what you will use to customize your pattern. Most of the parameters that are contained within a WP_Query are listed here. You can define which and how many posts you would like to pull in to your pattern using category, title, author and more. You can also select how many posts will be in your pattern (posts_per_page) and what order to place them in (order, orderby).

*Note: If you wish to create a pattern that is solely HTML, set posts_per_page to 1, which is it’s default value.*

![Loop Parameters](https://raw.github.com/JasonHoffmann/looplet/master/screenshots/parameters.png)

If you’d like to know how it works, it’s pretty simple. It uses a custom new WP_Query that looks like this:

    $the_loop_query = new WP_Query( $args );
     while ( $the_loop_query->have_posts() ) :
		$the_loop_query->the_post();
		
The only constant set here is setting the post-type to ‘looplet’ so that it only pulls posts from outside of the main query. Other then that, parameters can be customized, one by one, by the user and is pulled into the $args variable.

####PHP/HTML In the Loop
The next box is where your pattern yourself lives. It is here that you can use familiar  WordPress template tags, such as `the_title();` and `the_permalink` to start constructing your pattern. Mix this with some HTML to create elaborate patterns that you can use everywhere. For instance:

![HTML In the loop](https://raw.github.com/JasonHoffmann/looplet/master/screenshots/LoopHTMLPHP.png)

For some help, you may want to read up on [Template Tags](https://codex.wordpress.org/Template_Tags).

####HTML After the Loop
I added one more textarea here so that you can close up any HTML tags you may have opened in the first box, such as your unordered lists or stray `<div>` tags. 

![HTML After the loop](https://raw.github.com/JasonHoffmann/looplet/master/screenshots/HTMLaftertheloop.png)

####CSS 
Finally, you can use custom CSS to structure and style your markup and pattern. This will be useful if you are tyring to set up grids or style the posts in a paritcular way.

![CSS](https://raw.github.com/JasonHoffmann/looplet/master/screenshots/CSS.png)

Try to avoid generic class names here, so they don’t conflict with the main CSS code, but in general just being more modular about everything can go a long way. It’s definitely worth reading up on [OOCSS](http://oocss.org/) for help in this area.

###Credits
This project truly stands on the shoulders of the much-more-talented. A speical thanks to:

Dan Ciederholm - His [Pears](http://pea.rs/) theme was inspiration for this idea, as well as the foundation for a good amount of the code base.

Tom McFarlin - The [Plugin Boilerplate](https://github.com/tommcfarlin/WordPress-Plugin-Boilerplate) Tom built rocks. That is all.

[PrismJS](http://prismjs.com/) - Simple syntax highlighting.

###Areas of Improvement
I’m still working on a bunch of new features for this. Prime among them is:

1. Sanitize and Parse PHP code properly
2. Add Custom Taxonomies and custom taxonomy support to loop
3. Use a templating language

If anybody has any suggestions or would like to help, post an issue, submit a pull request or [get in touch](mailto:jhoffm34@gmail.com)

###Changelog
v.1.0

* New fields in custom post boxes.
* Full support for PHP before the loop for use with funcitons
* Tweaked design elements to make inline documentation clearer
* Updated documenation

v.0.4

* Inline documentation for creating new posts

v.0.3

* Added support for dummy post thumbnails

v.0.2

* Added more dummy content
* Cleaned up plugin code

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