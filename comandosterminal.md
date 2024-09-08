## INSTALAR FILAMENT

composer require filament/filament:"^3.2" -W

## INSTALAR PANELES

php artisan filament:install --panels

## EJECUTAR MIGRACIONES

php artisan serve

## CREAR MODELOS Y MIGRACIONES

php artisan make:model Alimento -m

## CREAR LA INTEFAZ

php artisan make:filament-resource Alimento

## CREAR LAS RELACIONES ENTRE TABLAS

$table->foreignId('user_id')->constraints()->cascadeOnDelete();

## RELACIONAR TABLAS

public function post()
{
return $this->belongsTo(Post::class);
}

public function comentarios()
{
return $this->hasMany(Comentario::class);
}
