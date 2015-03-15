Angular Symfony rest edition
=============

Angular Symfony rest edition is a jump start at building restfull web applications.

###Requirements

	Server     : nodejs server + http server + php application server (Apache Server or Nginx with php fpm)
	Middleware : PHP > 5.4
	Database   : mysql / postgres.
	Git        : http://git-scm.com/.
	Composer   : http://getcomposer.org/download/.
	Grunt      : http://gruntjs.com/

#Installation guide
	
##Step 1 : Clone Repository

	git clone https://github.com/BenoitDdlp/angular-symfony-rest-edition.git asre
	cd asre

##Step 2 : Configuration => template files to copy & adapt

#### Symfony

    cp parameters.yml.TEMPLATE backend/app/config/parameters.yml
    nano backend/app/config/parameters.yml

#### Grunt

     cp local-config.json.TEMPLATE local-config.json
     nano local-config.json

##Step 3 : Download vendors

### Node and grunt
create directory "node_modules" and :

    npm install
    npm install -g grunt-cli

#### Composer
create directory "backend/vendor" and :

    cd backend
	composer update
	cd ..

#### Bower
create directory "frontend/bower" and :

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
