<?php

namespace App\Http\Controllers\Frontend;

use App\Dto\CommentDto;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCommentRequest;
use App\Models\Recipe;
use App\Repositories\Interfaces\CommentRepositoryInterface;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class CommentController extends Controller
{

    public function __construct(protected readonly CommentRepositoryInterface $commentRepository) {}

    public function store(StoreCommentRequest $request, Recipe $recipe): RedirectResponse {
        try{
            $commentDto = new CommentDto($request->content, $recipe->id);

            $this->commentRepository->create([
                'content' => $commentDto->content,
                'recipe_id' => $commentDto->recipeId
            ]);

            return redirect()->back()->with('success', 'Pomyślnie dodano komentarz.');
        }catch(\Exception $e){
            Log::error("error while storing post", [
                'context' =>  $e->getMessage()
            ]);
            
            return redirect()->back()->with('error', 'Wystąpił problem podczas dodawania komentarza.');
        }
    }
}
