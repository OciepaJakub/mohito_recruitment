import { Link, router } from "@inertiajs/react";
import { Icon } from '@iconify/react';

const Header = () => {
    return(
        <header className="py-4 px-10 sticky top-0 bg-white border-neutral border-b">
            <div className="flex justify-between">
                <button onClick={() => router.replace('/')}>
                    <p className="font-black text-3xl">mohi.to</p>
                    <p className="text-xs -mt-3 ml-3">rekrutacja</p>
                </button>
                <div>
                    <nav>
                        <ul>
                            <li>
                                <Link title="Ulubione" href={route('recipe.favorites')} className="text-accent">
                                    <Icon icon="material-symbols:favorite-outline" width="32" />
                                </Link>
                            </li>
                        </ul>
                    </nav>
                </div>
            </div>
        </header>
    )
}

export default Header;