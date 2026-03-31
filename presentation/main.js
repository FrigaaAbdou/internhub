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
    Workflow,
    createIcons
} from "lucide";
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

deck.initialize({
    plugins: [Notes]
});

createIcons({
    icons: {
        activity: Activity,
        "badge-check": BadgeCheck,
        blocks: Blocks,
        briefcase: Briefcase,
        "check-check": CheckCheck,
        compass: Compass,
        database: Database,
        eye: Eye,
        "file-search": FileSearch,
        files: Files,
        globe: Globe,
        key: Key,
        "layout-grid": LayoutGrid,
        lock: Lock,
        "log-in": LogIn,
        monitor: Monitor,
        palette: Palette,
        play: Play,
        "refresh-cw": RefreshCw,
        route: Route,
        search: Search,
        send: Send,
        settings: Settings,
        shield: Shield,
        "shield-check": ShieldCheck,
        sparkles: Sparkles,
        "triangle-alert": TriangleAlert,
        user: User,
        users: Users,
        workflow: Workflow
    },
    attrs: {
        class: "deck-lucide"
    }
});
