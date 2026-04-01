# Presentation Workspace

This directory contains the dedicated Reveal.js workspace for the InternHub presentation.

It is intentionally separated from the PHP application so the deck can evolve without mixing presentation files into the app runtime.

## Stack

- `Reveal.js`
- `Tailwind CSS`
- `HTML`
- `CSS`
- local `npm` dependency management
- local preview with `Vite`

## Structure

- [package.json](/Users/abdoufrigaa/Projects/internhub/presentation/package.json)
- [vite.config.js](/Users/abdoufrigaa/Projects/internhub/presentation/vite.config.js)
- [index.html](/Users/abdoufrigaa/Projects/internhub/presentation/index.html)
- [styles/tailwind.css](/Users/abdoufrigaa/Projects/internhub/presentation/styles/tailwind.css)
- [styles/custom.css](/Users/abdoufrigaa/Projects/internhub/presentation/styles/custom.css)
- [PLAN.md](/Users/abdoufrigaa/Projects/internhub/presentation/PLAN.md)
- [SLIDE-PLAN.md](/Users/abdoufrigaa/Projects/internhub/presentation/SLIDE-PLAN.md)
- [SOUTENANCE-5MIN-PLAN.md](/Users/abdoufrigaa/Projects/internhub/presentation/SOUTENANCE-5MIN-PLAN.md)

## Setup

From the repo root:

```bash
cd /Users/abdoufrigaa/Projects/internhub/presentation
npm install
npm run dev
```

Then open:

- [http://127.0.0.1:8030](http://127.0.0.1:8030)

## How To Use It

1. Replace the placeholder slides in [index.html](/Users/abdoufrigaa/Projects/internhub/presentation/index.html).
2. Keep the narrative aligned with the project docs in:
   [docs/03-execution](/Users/abdoufrigaa/Projects/internhub/docs/03-execution/README.md)
   and
   [docs/04-ux](/Users/abdoufrigaa/Projects/internhub/docs/04-ux/README.md)
3. Use [SOUTENANCE-5MIN-PLAN.md](/Users/abdoufrigaa/Projects/internhub/presentation/SOUTENANCE-5MIN-PLAN.md) as the English short-format presenter plan for the 5-minute soutenance.
4. Use [styles/custom.css](/Users/abdoufrigaa/Projects/internhub/presentation/styles/custom.css) for slide-level branding and layout adjustments.
5. Use [styles/tailwind.css](/Users/abdoufrigaa/Projects/internhub/presentation/styles/tailwind.css) as the Tailwind entry file for the deck.
6. Add screenshots or product visuals inside `presentation/assets/` if needed.

## Recommended Deck Rules

- keep the deck short enough for a real soutenance
- one clear message per slide
- avoid text-heavy slides
- prefer product screenshots, UI fragments, and architecture diagrams over paragraphs
- keep the technical claims strictly aligned with the implemented project

## Source Material To Reuse

- [docs/03-execution/24-script-demo-p9.md](/Users/abdoufrigaa/Projects/internhub/docs/03-execution/24-script-demo-p9.md)
- [docs/03-execution/27-argumentaire-technique-fonctionnel-p9.md](/Users/abdoufrigaa/Projects/internhub/docs/03-execution/27-argumentaire-technique-fonctionnel-p9.md)
- [docs/03-execution/28-repartition-soutenance-p9.md](/Users/abdoufrigaa/Projects/internhub/docs/03-execution/28-repartition-soutenance-p9.md)
- [docs/03-execution/29-repetition-complete-p9.md](/Users/abdoufrigaa/Projects/internhub/docs/03-execution/29-repetition-complete-p9.md)
