cd backend
php app/console doctrine:database:drop --force
php app/console doctrine:database:create
php app/console doctrine:schema:update --force
php app/console asre:admin:create admin admin@admin.fr admin
php app/console asre:admin:create admin2 admin2@admin.fr admin2
php app/console asre:admin:create admin3 admin3@admin.fr admin3
php app/console asre:database:init