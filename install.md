Angular Symfony rest edition
=============

Angular Symfony rest edition is a jump start at building restfull web applications.

Sympozer - the best event experience, before, during and after
=============

Sympozer is an Angularjs/Symfony web application allowing event organizers and attendees to finally reach their perfect event experience.
Through its rich and powerful interface, Sympozer provides a wide set of facilitating and networking tools for attendees to keep tracking the schedule, receive notifications, and of course, meet new contacts.
The organization is now easier than ever with our specialized tools following at every step of your work.

###Requirements

	Server     : nodejs server + http server + php application server (Apache Server or Nginx with php fpm)
	Middleware : PHP > 5.4
	Database   : mysql / postgres.
	Git        : http://git-scm.com/.
	Composer   : http://getcomposer.org/download/.
	Grunt      : http://gruntjs.com/

#Installation guide
	
##Step 1 : Clone Repository

	git clone https://github.com/BenoitDdlp/angular-symfony-rest-edition.git angular-symfony-rest-edition
	cd angular-symfony-rest-edition/backend

##Step 2 : Configuration => template files to copy & adapt

#### Symfony

    cp parameters.yml.TEMPLATE backend/app/config/parameters.yml
    nano backend/app/config/parameters.yml

#### Grunt

     cp local-config.json.TEMPLATE local-config.json
     nano local-config.json

##Step 3 : Download vendors

### Node and grunt

    npm install
    npm install -g grunt-cli

#### Composer
    cd backend
	composer update
	cd ..

#### Bower

     grunt update_dependencies

##Step 4 : Reset/Create the database & Generate links to the api according to the local config

Reset/Create the database

    grunt reset_db

Generate links to the api according to the local config

    grunt sf2-console:copy_ws_config


##Uselful cmd :

Run the backend symfony server in background

    php backend/app/console server:run -v &

Start developpment

    grunt dev

Check prod environnement

    grunt build

Launch unit test

    grunt test:unit

Launch e2e tests

    grunt test:e2e
