redo database with filling content
	php artisan migrate:refresh --seed

Cache Problems solving:
	php artisan config:cache
	php artisan cache:clear
	php artisan route:list
	php artisan dump-autoload


composer global require "laravel/installer"
composer create-project --prefer-dist laravel/laravel blog
composer require laracasts/generators --dev
composer update

php artisan key:generate

laravel -v4 -> php artisan generate:migration create_users_table
laravel -v5 -> 
php artisan make:migration create_users_table
php artisan make:migration create_posts_table
php artisan make:migration create_categories_table
php artisan make:migration create_comments_table
php artisan migrate:fresh
::User déjà créé par défaut
php artisan make:model User
php artisan make:model Post
php artisan make:model Comment
php artisan make:model Category
::ajouter la structure des tables, boucle de remplissage...

ajouter les infos de table:
	use Illuminate\Support\Facades\Schema;
	use Illuminate\Database\Schema\Blueprint;
	use Illuminate\Database\Migrations\Migration;
	//-> AppServiceProvider.php
	
ajouter les infos de table:
		(app\database\migrations\{Create[Type]Table}.php)
	use Illuminate\Database\Schema\Blueprint;
	use Illuminate\Database\Migrations\Migration;
	class CreatePostsTable extends Migration{
		public function up(){
			Shema::create('posts', function Blueprint $table){
				$table->increments('id');
				$table->string('name');
				$table->string('slug');
				$table->text('content');
				$table->timestamp();
				
			}
		}
		public function down(){
			Schema::drop('posts');
		}
	}
php artisan migrate(
	php artisan migrate:rollback ::pour annuler
	php artisan migrate:fresh ::laravel 5.5+
	php artisan migrate:fresh --database
	composer dump-autoload ??
)


problème La clé est trop longue. Longueur maximale: 1000")
config/database.php
	'engine' => 'InnoDB ROW_FORMAT=DYNAMIC',
	
php artisan route:list
php artisan db:seed

Failed opening required bootstrap/../vendor/autoload.php{composer update --no-scripts}