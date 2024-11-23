import useFavorites from "@/Hooks/useFavorites";
import FrontendLayout from "@/Layouts/FrontendLayout";
import { Link } from "@inertiajs/react";
import { ReactNode } from "react";

const RecipeFavorites = () => {
    const { favorites, addFavorite, removeFavorite, isFavorite, handleFavoriteToggle } = useFavorites();

    return (
        <>
            <section>
                <div className="flex items-center justify-between mb-8">
                    <h1 className="text-primary-dark text-3xl font-medium tracking-wide">Polubione przepisy</h1>
                </div>
                {favorites.length === 0 &&
                    <p>Brak polubionych przepisów.</p>
                }
                <div className="flex flex-wrap">
                    {favorites.map((recipe, i) => (
                        <div className="flex gap-x-12 mb-12 w-full sm:w-[calc(50%_-_48px)]" key={i}>
                            <div className="max-w-[25%] w-full">
                                <img src={recipe.img} className="object-cover aspect-square" />
                            </div>
                            <article className="max-w-[65%] w-full flex flex-col">
                                <h2 className="text-2xl font-medium tracking-wide mb-3">{recipe.name}</h2>

                                <Link href={route('recipe.single', { recipe: recipe.slug })} className="px-6 py-4 bg-accent rounded-md text-base font-medium tracking-wide block mt-auto max-w-fit">
                                    Zobacz cały przepis
                                </Link>
                            </article>
                        </div>
                    ))}
                </div>
            </section>
        </>
    )
}

RecipeFavorites.layout = (page: ReactNode) => (
    <FrontendLayout>
        {page}
    </FrontendLayout>
)

export default RecipeFavorites;