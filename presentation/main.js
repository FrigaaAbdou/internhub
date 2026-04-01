import "./styles/tailwind.css";
import "reveal.js/reset.css";
import "reveal.js/reveal.css";
import "reveal.js/theme/white.css";

import {
    Activity,
    BadgeCheck,
    Blocks,
    Briefcase,
    CheckCheck,
    Compass,
    Database,
    Eye,
    FileSearch,
    Files,
    Globe,
    Key,
    LayoutGrid,
    Lock,
    LogIn,
    Monitor,
    Palette,
    Play,
    RefreshCw,
    RotateCcw,
    Route,
    Search,
    Send,
    Settings,
    Shield,
    ShieldCheck,
    Sparkles,
    TriangleAlert,
    User,
    Users,
    Workflow
} from "lucide";
import createElement from "lucide/dist/esm/createElement.js";
import Reveal from "reveal.js";
import Notes from "reveal.js/plugin/notes";

const deck = new Reveal({
    hash: true,
    slideNumber: true,
    transition: "slide",
    controls: true,
    progress: true,
    center: false,
    width: 1440,
    height: 900,
    margin: 0.04,
    minScale: 0.2,
    maxScale: 1.25
});

const deckIcons = {
    Activity,
    BadgeCheck,
    Blocks,
    Briefcase,
    CheckCheck,
    Compass,
    Database,
    Eye,
    FileSearch,
    Files,
    Globe,
    Key,
    LayoutGrid,
    Lock,
    LogIn,
    Monitor,
    Palette,
    Play,
    RefreshCw,
    RotateCcw,
    Route,
    Search,
    Send,
    Settings,
    Shield,
    ShieldCheck,
    Sparkles,
    TriangleAlert,
    User,
    Users,
    Workflow
};

function toPascalCase(value) {
    return value
        .split("-")
        .map((part) => part.charAt(0).toUpperCase() + part.slice(1))
        .join("");
}

function renderDeckIcons() {
    document.querySelectorAll("[data-lucide]").forEach((placeholder) => {
        const iconName = placeholder.getAttribute("data-lucide");

        if (!iconName) {
            return;
        }

        const iconNode = deckIcons[toPascalCase(iconName)];

        if (!iconNode) {
            console.warn(`Missing deck icon: ${iconName}`);
            return;
        }

        const svg = createElement(iconNode, {
            class: "deck-lucide",
            "stroke-width": 2.1,
            "aria-hidden": "true",
            "data-lucide": iconName
        });

        placeholder.replaceWith(svg);
    });
}

deck.initialize({
    plugins: [Notes]
}).then(() => {
    renderDeckIcons();
});
