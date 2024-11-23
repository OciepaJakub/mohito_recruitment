export interface PaginationLink {
    url: string | null;
    label: string;
    active: boolean;
}

export type PaginationProps = {
    links: PaginationLink[];
    className?: string;
    preserveScroll?: boolean;
}