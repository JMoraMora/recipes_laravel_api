<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\RecipeResource;
use App\Models\Recipe;
use Illuminate\Http\Request;

class RecipeController extends Controller
{
    public function index()
    {
        return RecipeResource::collection(Recipe::with(['category', 'tags', 'user'])->get());
    }

    public function show(Recipe $recipe)
    {
        return new RecipeResource($recipe->load(['category', 'tags', 'user']));
    }

    public function store(Request $request)
    {
        
    }

    public function update(Request $request, Recipe $recipe)
    {
        
    }

    public function destroy(Recipe $recipe)
    {
        
    }
}
