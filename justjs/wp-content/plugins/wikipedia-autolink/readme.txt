=== Wikipedia Autolink ===
Contributors: Cristiano Fino
Donate link: http://www.cristianofino.net
Tags: wikipedia, autolink, link, icon, term, description, definition
Requires at least: 2.3.0
Tested up to: 2.6.2
Stable tag: 1.1.01

Link automatically all the highlighted words with the syntax [w:{term}] on the definition from Wikipedia.

== Description ==

Link automatically all the highlighted words with the syntax [W:*{term}*] on the definition from Wikipedia.

Supposing *{term}* is the word for which we want to automatically create the link to the relative Wikipedia definition, it will be enough to use the following syntax:

**[W:*{term}*]** 

Features:

- modify the localisation code to set the Wikipedia language.
- decide if the hypertextual link will be applied to the entire word or just the **W** apex added to the end of the word.
- decide to apply the default style, or set your own CSS style.
- decide if to add or not the rel=nofollow attribute to each link generated
- supported languages of control panel: Italian, English, French (you can translate in your language using the added file *cf_wikipedia.POT*)

== Installation ==

Visit [the plugin page](http://www.cristianofino.net/post/Wikipedia-Autolink-plugin-anche-per-WordPress.aspx) for installation steps for the latest release of the plugin.

1. Download and extract plugin files to a folder locally.
2. Copy the entire folder *Wikipedia-Autolink*  to the */wp-content/plugins/* directory.
3. Enable the plugin through the *WordPress* admin interface.
4. Optionally configure the plugin from the new *Wikipedia* menu item

== Examples of Use ==

To autolink the word **Wikipedia** in your post, write **[W:Wikipedia]**

== Frequently Asked Questions ==

= How can I enable the icon link only in a single post ? =

Simply insert the keyword **[wikiicon]** anywhere in the post.

= How can I display [W:{term}] exactly in this way, without activating the link to Wikipedia ? =

Simply use this sintax: [W:{term}:0]

== Screenshots ==

None.

== Thanks to ==

[Paolo Barbarossa](http://www.paolobarbarossa.com/) for the english translation of the original italian post.

[Frederic Sune](http://www.fredericsune.com/) for the French translation
