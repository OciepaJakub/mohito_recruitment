import { RecipeModel } from "@/types/Models/RecipeModel";
import { useEffect, useState } from "react";

export interface FavoriteRecipe {
  id: string;
  name: string;
  img: string;
  slug: string;
}

const useFavorites = () => {
  const [favorites, setFavorites] = useState<FavoriteRecipe[]>([]);

  useEffect(() => {
    const storedFavorites = localStorage.getItem('favorites');

    if (storedFavorites) {
      setFavorites(JSON.parse(storedFavorites));
    }
  }, []);

  const addFavorite = (recipe: FavoriteRecipe) => {
    const updatedFavorites = [...favorites, recipe];
    setFavorites(updatedFavorites);
    localStorage.setItem('favorites', JSON.stringify(updatedFavorites));
  };

  const removeFavorite = (id: string) => {
    const updatedFavorites = favorites.filter((favorite) => favorite.id !== id);
    setFavorites(updatedFavorites);
    localStorage.setItem('favorites', JSON.stringify(updatedFavorites));
  };

  const isFavorite = (id: string): boolean => {
    return favorites.some((favorite) => favorite.id === id);
  };

  const handleFavoriteToggle = (recipe: RecipeModel) => {
    if (isFavorite(recipe.id)) {
      removeFavorite(recipe.id);
    } else {
      addFavorite({
        id: recipe.id,
        img: recipe.thumb,
        name: recipe.name,
        slug: recipe.slug
      });
    }
  };

  return { favorites, addFavorite, removeFavorite, isFavorite, handleFavoriteToggle };
};

export default useFavorites;