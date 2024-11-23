import Footer from "@/Partials/Footer";
import Header from "@/Partials/Header";
import { PropsWithChildren } from "react";

const FrontendLayout = ({ children }: PropsWithChildren) => {
    return(
        <>
            <Header/>
            <main className="min-h-[calc(100vh_-_142px)] py-8 px-10">
                {children}
            </main>
            <Footer/>
        </>
    )
}

export default FrontendLayout;