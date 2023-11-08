<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreRecipeRequest;
use App\Http\Requests\UpdateRecipeRequest;
use App\Http\Resources\RecipeResource;
use App\Models\Recipe;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

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

    public function store(StoreRecipeRequest $request)
    {
        $recipe = $request->user()->recipes()->create($request->all());
        $tags = json_decode($request->tags);
        $recipe->tags()->attach($tags);

        return response()->json(
            new RecipeResource($recipe),
            Response::HTTP_CREATED
        );
    }

    public function update(UpdateRecipeRequest $request, Recipe $recipe)
    {
        $this->authorize('update', $recipe);
        $recipe->update($request->all());

        if($tags = json_decode($request->tags) ) {
            $recipe->tags()->sync($tags);
        }

        return response()->json(
            new RecipeResource($recipe),
            Response::HTTP_OK
        );
    }

    public function destroy(Recipe $recipe)
    {
        $this->authorize('delete', $recipe);
        $recipe->delete();
        return response()->json( NULL, Response::HTTP_NO_CONTENT );
    }
}
