It's Mino
=========

__Fair warning: I didn't fully understand programming design patterns when I made this__

It's...
- a project I created a few years ago, so it's got some older versions of things, but it's still cool!
- a modular PHP/MySQL framework that bridges the gap between client and server while still offering some pretty locked down security features (just look at the PHP router!), influenced by early Node.js frameworks, but with a kickass HTML5 templating model and routing
- pretty decent for rapid prototyping of startup ideas (although I'd recommend Meteor over this nowadays)
- almost got its own DSL, in an abandoned private repo
- mostly a learning project...I was still kind of a rogue programmer when I wrote it!

__The good news is that despite not having any tests, it works?__

Server Config
-------------
It's got config files for Apache and Nginx. Use either one!

Abridged Docs
-------------
1. Clone this project into your local install of the LAMP or LNMP stack.
2. Read the setup instructions HTML file.
3. Run the setup.
4. Write your templates in PHP on the server, inside your models.
5. In your HTML5 file where you want to load the template for that model, specify data-model="modelName"
6. Look through the client side JS to see what other cool data-attribute options are available. I believe there's a data-poll option which will automatically poll your model for changes based on the milliseconds you specify.

__Real docs coming as soon as I get some more time...not like anyone is even using this...__

ORM
---
Oh yeah, it has an ORM that lets you write shorthand MySQL queries. So that's pretty cool.

Routes
------
Specify your routes in /routes/views.router.php

API
---
There is supposed to be a public API option in this framework, but the first implementation is in a project I have to find somewhere...

Known Issues
------------
I created [Relayer.co](http://relayer.co) around the same time as this, which is currently unstable. I don't really know what the problem is, I haven't touched it in years, and I don’t have time to start right now.

Just remove the Relayer file from /client/lib.
