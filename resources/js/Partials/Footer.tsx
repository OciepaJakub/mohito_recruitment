import { Link, router } from "@inertiajs/react";
import { Icon } from '@iconify/react';

const Footer = () => {
    return(
        <footer className="py-4 px-10 bg-neutral-light border-border border-t">
            <div className="flex justify-between">
                <div className="uppercase">
                    <p>Created by Ociepa Jakub</p>
                    <small className="-mt-2 block ml-2">Full Stack Developer</small>
                </div>
                <div>
                    <a href="https://www.linkedin.com/in/jakub-ociepa-3a7473267/" target="_blank" className="text-blue-700">
                        <Icon icon="mdi:linkedin" width="32"/>
                    </a>
                </div>
            </div>
        </footer>
    )
}

export default Footer;