<?php

namespace Database\Factories;

use App\Models\Article;
use App\Models\User; // Import du modèle User
use Illuminate\Database\Eloquent\Factories\Factory;

class ArticleFactory extends Factory
{
    protected $model = Article::class;

    public function definition()
    {
        return [
            'titre' => $this->faker->sentence(),
            'contenu' => $this->faker->paragraph(5),
            'image' => 'images/' . $this->faker->randomElement([
                'light-bulb-984551__340.jpg',
                'energie1.jpeg',
                'images2.jpeg'
            ]),
            // Générer un user_id en utilisant un utilisateur existant ou en en créant un nouveau
            'user_id' => User::factory(), // Ceci créera automatiquement un utilisateur lié
        ];
    }
}
