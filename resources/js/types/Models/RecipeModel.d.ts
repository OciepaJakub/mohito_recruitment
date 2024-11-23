import { CommentModel } from "./CommentModel";
import { RecipeAreaModel } from "./RecipeAreaModel";
import { RecipeCategoryModel } from "./RecipeCategoryModel";

export type RecipeModel = {
    id: string;
    api_id: string;
    name: string;
    slug: string;
    recipe_category_id: string;
    category: RecipeCategoryModel;
    recipe_area_id: string;
    area: RecipeAreaModel;
    instructions: string;
    thumb: string;
    video_url?: string | null;
    ingredients: {
        measure: string;
        ingredient: string;
    }[];
    source?: string | null;
    tags?: TagModel[];
    comments?: CommentModel[];
    created_at: string;
    updated_at: string;
}