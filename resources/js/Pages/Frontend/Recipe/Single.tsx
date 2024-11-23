import useFavorites from "@/Hooks/useFavorites";
import FrontendLayout from "@/Layouts/FrontendLayout";
import { RecipeModel } from "@/types/Models/RecipeModel";
import { Icon } from "@iconify/react/dist/iconify.js";
import { useForm } from "@inertiajs/react";
import { ChangeEvent, FormEventHandler, ReactNode } from "react";

const RecipeSingle = ({ recipe }: { recipe: RecipeModel }) => {
    const { favorites, addFavorite, removeFavorite, isFavorite, handleFavoriteToggle } = useFavorites();

    const { setData, post, processing, errors } = useForm({
        content: '',
    })

    const sendComment: FormEventHandler = (e) => {
        e.preventDefault()

        post(route('recipe.comment.store', recipe), {
            preserveScroll: true,
        })
    }

    return (
        <>
            <section>
                <div className="flex items-center justify-between mb-8">
                    <h1 className="text-primary-dark text-3xl font-medium tracking-wide">Szczegóły przepisu {recipe.name}</h1>
                </div>

                <div className="gap-y-12 flex flex-wrap gap-x-12">
                    <div className="max-w-[calc(25%_-_48px)] w-full relative">
                        <img src={recipe.thumb} className="object-cover aspect-square" />
                        <button type="button" className="absolute right-4 top-4 text-primary" onClick={() => handleFavoriteToggle(recipe)}>
                            {isFavorite(recipe.id) ?
                                <Icon icon="material-symbols:favorite" width="48" />
                                :
                                <Icon icon="material-symbols:favorite-outline" width="48" />
                            }
                        </button>
                    </div>
                    <div className="max-w-[calc(25%_-_48px)] w-full">
                        <article className="w-full flex flex-col">
                            <h2 className="text-2xl font-medium tracking-wide mb-3">{recipe.name}</h2>
                            <div className="flex flex-wrap gap-x-4 items-center mb-4">
                                <p className="mb-1 w-full">Kategoria:</p>
                                <div className="rounded-full max-w-fit w-full py-1 px-3 border-accent border">
                                    <span>{recipe.category.name}</span>
                                </div>
                            </div>
                            <div className="flex flex-wrap gap-x-4 items-center mb-4">
                                <p className="mb-1 w-full">Kuchnia:</p>
                                <div className="rounded-full max-w-fit w-full py-1 px-3 border-primary-dark border">
                                    <span>{recipe.area.name}</span>
                                </div>
                            </div>
                            <div className="mb-8">
                                {recipe.instructions.split('\n').map((p, i) => (
                                    <p className="mb-4 last-of-type:mb-0" key={i}>{p}</p>
                                ))}
                            </div>
                            {(recipe.tags && recipe.tags.length > 0) &&
                                <div className="flex flex-wrap gap-x-4 items-center mt-6">
                                    <p className="mb-1 w-full">Tagi:</p>
                                    {recipe.tags.map((tag, i) => (
                                        <div key={i} className="rounded-full max-w-fit w-full py-1 px-3 bg-primary-dark text-white">
                                            <span>{tag.name}</span>
                                        </div>
                                    ))}
                                </div>
                            }
                        </article>
                    </div>
                    <div className="max-w-[calc(25%_-_48px)] w-full">
                        <h3 className="text-2xl font-medium tracking-wide mb-3">Składniki</h3>

                        <ul className="list-disc pl-4">
                            {recipe.ingredients && recipe.ingredients.map((item, i) => (
                                <li key={i}>{item.ingredient} {item.measure}</li>
                            ))}
                        </ul>

                        <h3 className="text-2xl font-medium tracking-wide mb-3 mt-10">Ostatnie komentarze</h3>
                        {recipe.comments && recipe.comments.map((comment, i) => (
                            <p key={i} className="mb-2 last-of-type:mb-0">{comment.content} - {comment.created_at}</p>
                        ))}
                    </div>
                    <div className="max-w-[calc(25%_-_48px)] w-full">
                        <h3 className="text-2xl font-medium tracking-wide mb-3">Wideo oraz źródło</h3>

                        {recipe.video_url &&
                            <a target="_blank" className="px-6 py-2 text-white bg-primary block rounded-md text-center font-medium tracking-wide" href={recipe.video_url}>Otwórz video</a>
                        }
                        {recipe.source &&
                            <small className="mt-6 block">Źródło: <a href={recipe.source}>{recipe.source}</a></small>
                        }

                        <h4 className="text-2xl font-medium tracking-wide mb-3 mt-10">Zostaw swój komentarz</h4>

                        <form onSubmit={sendComment}>
                            <textarea onChange={(e: ChangeEvent<HTMLTextAreaElement>) => setData('content', e.target.value)} name="content" id="content" className="py-2 px-6 rounded-md border-primary-dark text-primary border w-full" rows={8} />
                            {errors.content &&
                                <p className="text-error my-2 font-bold">{errors.content}</p>
                            }
                            <button disabled={processing} type="submit" className="bg-neutral-dark text-white font-medium px-6 py-2 rounded-md mt-4 ml-auto block disabled:opacity-50">Wyślij</button>
                        </form>
                    </div>
                </div>
            </section>
        </>
    )
}

RecipeSingle.layout = (page: ReactNode) => (
    <FrontendLayout>
        {page}
    </FrontendLayout>
)

export default RecipeSingle;