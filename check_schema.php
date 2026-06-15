<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\File;

$models = File::files(app_path('Models'));
$issues = [];

foreach($models as $file) {
    $className = 'App\\Models\\' . $file->getFilenameWithoutExtension();
    if(!class_exists($className)) continue;
    
    $reflection = new ReflectionClass($className);
    if($reflection->isAbstract()) continue;
    
    $model = new $className;
    $table = $model->getTable();
    
    if(!Schema::hasTable($table)) {
        echo "MISSING TABLE: $table ($className)\n";
        continue;
    }
    
    $dbColumns = Schema::getColumnListing($table);
    $fillables = $model->getFillable();
    
    $missing = array_diff($fillables, $dbColumns);
    if(!empty($missing)) {
        echo "MISSING COLUMNS in $table ($className): " . implode(', ', $missing) . "\n";
    }
}
echo "Check complete.\n";
