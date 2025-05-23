# Ticketit

A simple helpdesk tickets system for Laravel 10+ (10, 11, 12) which integrates smoothly with Laravel default users and auth system. 
It will integrate into your current Laravel project within minutes, and you can offer your customers and your team a nice and simple support ticket system. 

## Features:
1. Three main users roles users, agents, and admins
2. Users can create tickets, keep track of their tickets status, giving comments, and close their own tickets (access permissions are configurable)
3. Auto assigning agents to tickets, the system searches for agents in specific department and auto select the agent with lowest queue
4. Simple admin panel 
5. Localization (Arabic, Brazilian Portuguese, Deutsch (German), English, Farsi, French, Hungarian, Italian, Persian, Russian, and Spanish language packs are included)
6. Very simple installation and integration process
7. Admin dashboard with statistics and performance tracking graphs
8. Simple text editor for tickets descriptions and comments allows images upload


## Quick installation

This is a Laravel application pre-configured to work with Ticketit. Using the quick installer minimises the efforts and knowledge about Laravel needed to install Ticketit.

However if you'd like to include Ticketit in your existing project, skip to the [next section](#installation-manual).

## Installation (manual):

### Requirements
**First Make sure you have got this Laravel setup working:**

1. [Laravel 10+](http://laravel.com/docs#installation)
2. [Users table](http://laravel.com/docs/authentication)
3. [Laravel email configuration](http://laravel.com/docs/mail#sending-mail)
4. Bootstrap 4, or Bootstrap 5
5. Jquery

**Dependents that are getting installed and configured automatically by Ticketit (no action required from you)**

1. [Laravel HTML](https://github.com/spatie/laravel-html)
2. [Laravel Datatables](https://github.com/yajra/laravel-datatables)
3. [HTML Purifier](https://github.com/mewebstudio/Purifier)


### Installation steps (4-8 minutes)

* Register at least one user into the system and log it in.

* Go ahead to http://your-project-url/tickets-install to finalize the installation (1-2 minutes)

* Default ticketit front route: http://your-project-url/tickets

* Default ticketit admin route: http://your-project-url/tickets-admin

**Notes:**

Make sure you have created at least one status, one prority, and one category before you start creating tickets.

If you move your installation folder to another path (or server), you need to update the row with slug='routes' in table `ticketit_settings`. After that, don't forget to flush the entire cache.

