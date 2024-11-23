import { PaginationProps } from "@/types/Components/Pagination";
import { Icon } from "@iconify/react/dist/iconify.js";
import { Link, usePage } from "@inertiajs/react";

const PaginationBlock = ({ links, className = '', preserveScroll = false }: PaginationProps) => {
    let queryString = usePage().props.ziggy.query;
    
    delete queryString.page;

    const resolveActiveClass = (active: boolean): string => {
        if (active) {
            return "block [&>span]:text-heading text-small font-bold border-accent border-2 bg-accent size-10 rounded-full flex items-center justify-center";
        } else {
            return "block [&>span]:text-paragraphs text-small font-bold border-blue border-2 size-10 rounded-full flex items-center justify-center";
        }
    };

    if (links.length > 3) {
        return (
            <div className={`flex flex-wrap justify-start gap-x-4 items-center ${className}`}>
                {links.map((link, id) => {
                    if (link.label === "...") {
                        return (
                            <div key={id} className="w-3 h-1"></div>
                        );
                    }
                    if (link.url !== null) {
                        if (link.label === "Next &raquo;") {
                            return (
                                <Link data={{...queryString}} preserveScroll={preserveScroll} preserveState key="next-btn" href={link.url} title="Dalej">
                                    <Icon
                                        width={24}
                                        rotate={2}
                                        className="text-headings"
                                        icon="material-symbols:arrow-back-ios-new-rounded"
                                    />
                                </Link>
                            );
                        }

                        if (link.label === "&laquo; Previous") {
                            return (
                                <Link data={{...queryString}} preserveScroll={preserveScroll} preserveState key="prev-btn" href={link.url} title="Dalej">
                                    <Icon
                                        width={24}
                                        className="text-headings"
                                        icon="material-symbols:arrow-back-ios-new-rounded"
                                    />
                                </Link>
                            );
                        }

                        return (
                            <Link data={{...queryString}} preserveScroll={preserveScroll} preserveState
                                key={id}
                                href={link.url}
                                title={`Strona - ${link.label}`}
                                className={resolveActiveClass(link.active)}
                            >
                                <span className="">
                                    {link.label}
                                </span>
                            </Link>
                        );
                    }
                    return null;
                })}
            </div>
        );
    }
    
    return <></>;
};

export default PaginationBlock;