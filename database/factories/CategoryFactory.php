<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Storage;

class CategoryFactory extends Factory
{
    protected $model = Category::class;

    public function definition(): array
    {
        // Crear el directorio temporal si no existe
        $tmpDir = storage_path('app/public/tmp');
        if (!is_dir($tmpDir)) {
            mkdir($tmpDir, 0755, true);
        }

        // Generar un nombre de archivo de imagen único
        $timestamp = Carbon::now()->timestamp;
        $filename = "foto_" . $this->faker->word . "_$timestamp.jpg";

        // Crear una imagen de prueba y almacenarla en el disco 'imgCategory'
        $imageContent = $this->faker->image($tmpDir, 640, 480, 'vegetables', false);
        Storage::disk('imgCategory')->put($filename, file_get_contents($tmpDir . '/' . $imageContent));

        // Eliminar la imagen temporal
        unlink($tmpDir . '/' . $imageContent);

        return [
            'picture' => $filename,
            'name' => $this->faker->word,
            'description' => $this->faker->paragraph,
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
