import PaginationBlock from "@/Components/Pagination";
import useFavorites from "@/Hooks/useFavorites";
import FrontendLayout from "@/Layouts/FrontendLayout";
import { RecipeModel } from "@/types/Models/RecipeModel";
import { PaginatedResponse } from "@/types/PaginatedResponse";
import { Icon } from "@iconify/react/dist/iconify.js";
import { Link, useForm, usePage } from "@inertiajs/react";
import { FormEventHandler, ReactNode } from "react";

const Index = ({ recipes }: { recipes: PaginatedResponse<RecipeModel> }) => {
    const { favorites, addFavorite, removeFavorite, isFavorite, handleFavoriteToggle } = useFavorites();

    let queryString = usePage().props.ziggy.query;

    const { data, setData, get } = useForm({
        title: queryString.title
    })

    const handleSearch: FormEventHandler = (e) => {
        e.preventDefault();

        get(route('home'), {
            preserveState: true,
            replace: true,
        });
    };

    return (
        <>
            <section>
                <div className="flex items-center justify-between mb-8">
                    <h1 className="text-primary-dark text-3xl font-medium tracking-wide">Lista przepisów</h1>
                    <form onSubmit={handleSearch} className="flex items-center">
                        <input
                            type="text"
                            name="title"
                            value={data.title}
                            onChange={(e) => setData('title', e.target.value)}
                            className="py-2 px-6 rounded-md border-primary-dark text-primary border"
                            placeholder="Szukaj przepisów..."
                        />
                        <button
                            type="submit"
                            className="ml-4 py-2 px-4 bg-primary-dark text-white rounded-md"
                        >
                            Szukaj
                        </button>
                    </form>
                </div>

                <div className="gap-y-12 flex flex-wrap gap-x-12">
                    {recipes.data.map((recipe, i) => (
                        <div className="flex gap-x-12 mb-12 w-full sm:w-[calc(50%_-_48px)]" key={i}>
                            <div className="max-w-[25%] w-full">
                                <img src={recipe.thumb} className="object-cover aspect-square" />
                            </div>
                            <article className="max-w-[65%] w-full flex flex-col">
                                <h2 className="text-2xl font-medium tracking-wide mb-3">{recipe.name}</h2>
                                <div className="flex flex-wrap gap-x-4 items-center mb-4">
                                    <p className="mb-1 w-full">Kategoria:</p>
                                    <div className="rounded-full max-w-fit w-full py-1 px-3 border-accent border">
                                        <span>{recipe.category.name}</span>
                                    </div>
                                </div>
                                <div className="flex flex-wrap gap-x-4 items-center mb-10">
                                    <p className="mb-1 w-full">Kuchnia:</p>
                                    <div className="rounded-full max-w-fit w-full py-1 px-3 border-primary-dark border">
                                        <span>{recipe.area.name}</span>
                                    </div>
                                </div>
                                <Link href={route('recipe.single', recipe)} className="px-6 py-4 bg-accent rounded-md text-base font-medium tracking-wide block mt-auto max-w-fit">
                                    Zobacz cały przepis
                                </Link>
                                {(recipe.tags && recipe.tags.length > 0) &&
                                    <div className="flex flex-wrap gap-x-4 items-center mt-10">
                                        <p className="mb-1 w-full">Tagi:</p>
                                        {recipe.tags.map((tag, i) => (
                                            <div key={i} className="rounded-full max-w-fit w-full py-1 px-3 bg-primary-dark text-white">
                                                <span>{tag.name}</span>
                                            </div>
                                        ))}
                                    </div>
                                }
                            </article>
                            <div className="max-w-[10%] w-full">
                                <button className="block ml-auto" onClick={() => handleFavoriteToggle(recipe)}>
                                    {isFavorite(recipe.id) ?
                                        <Icon icon="material-symbols:favorite" width="48" className="text-primary transition-opacity duration-300 ease-in-out hover:opacity-50" />
                                        :
                                        <Icon icon="material-symbols:favorite-outline" width="48" className="text-primary transition-opacity duration-300 ease-in-out hover:opacity-50"/>
                                    }
                                </button>
                            </div>
                        </div>
                    ))}
                </div>
                <PaginationBlock links={recipes.links} />
            </section>
        </>
    )
}

Index.layout = (page: ReactNode) => (
    <FrontendLayout>
        {page}
    </FrontendLayout>
)

export default Index;