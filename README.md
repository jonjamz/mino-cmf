It's Mino
=========

_Mino is magic. Write PHP models and methods on the server, HTML5 on the client, and use HTML5 data attributes to connect it all without any boilerplate JavaScript._

__What's up with that?__
- Mino is dead simple, and there is an example project already in here, so it should be easy to get going with it despite the lack of real docs
- I didn't fully understand programming design patterns when I made this a few years ago, so don't expect super nice-looking code (I did my best though back then, and I'm a perfectionist, so it's not that bad)

__The hype__
- Everyone says PHP is "just supposed to be a templating language" so Mino uses PHP to serve up server-compiled templates direct from models
- Mino is a based on the cool-as-hell idea that you can specify what models and methods to get from the server (and even pass URL variables to them) all from within HTML5 data attributes 
- Mino is built with simplicity and security in mind
- It even has a "power save" mode where it slows down AJAX polling if you haven't had any recent screen activity, eventually halting it altogether and throwing up an overlay with notice (you can very simply turn this off)

__The facts__
- It's a project I created a few years ago, so it's got some older versions of front-end libs, but it's still cool!
- It's a modular PHP/MySQL framework that bridges the gap between client and server while still offering some pretty locked down security features (just look at the PHP routers!)
- It was vaguely influenced by Express on Node.js, but with a kickass HTML5 templating model and routing
- It's pretty decent for rapid prototyping of startup ideas (although I'd recommend Meteor over this nowadays)
- It almost had its own DSL, in an abandoned private repo
- It was mostly a learning project...I was still kind of a rogue programmer when I wrote it!

__The dumb__
- Back when I wrote this, unit tests seemed like the most boring thing in the world, so I just didn't write them (I was careful step-by-step to make sure I didn't break anything though)
- Having all your templates specified on the server side with PHP means you can't easily duplicate and extend them like you can with, say, Handlebars.js

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
Specify your routes in /routes/[route type].router.php, just look at the comments and the existing example code, you'll figure it out.

API
---
There is supposed to be a public API option in this framework, but the first implementation is in a project I have to find somewhere...

Known Issues
------------
I created [Relayer.co](http://relayer.co) around the same time as this, which is currently unstable. I don't really know what the problem is, I haven't touched it in years, and I don’t have time to start right now.

Just remove the Relayer file from /client/lib.
