# Presentation Plan

This plan defines how the InternHub Reveal.js presentation should be built.

## Objective

Produce a presentation that is:

- credible for a jury
- aligned with the implemented project
- visually clean and professional
- short enough to support a live demo

## Target Format

- presentation tool: `Reveal.js`
- target duration: `8` to `12` minutes
- target size: `8` to `12` slides
- tone: professional, product-focused, technically defensible

## Slide Plan

1. **Title**
Project name, team, short product statement.

2. **Problem And Context**
Why internship management needs a centralized workflow.

3. **Users And Roles**
Students, pilots, administrators, public visitors.

4. **Product Scope**
Public catalog, applications, follow-up, governance modules.

5. **Functional Highlights**
Most important flows and what the application actually supports.

6. **Technical Architecture**
Plain PHP MVC without framework, SQL database, sessions, CSRF, protected routes.

7. **UI/UX And Page Families**
Landing page, public pages, student space, pilot space, admin space, CRUD management.

8. **Security And Quality**
Permissions, validation, tests, smoke verification, error handling.

9. **Live Demo Flow**
Public navigation, student path, pilot supervision, admin governance.

10. **Conclusion**
Project value, limits, and final closing.

## Build Sequence

1. Freeze the story before polishing visuals.
2. Create the full slide outline.
3. Fill each slide with short, defensible content.
4. Add screenshots and product visuals.
5. Add speaker notes and demo transitions.
6. Rehearse timing and remove low-value content.

## Content Rules

- no slide should try to explain the whole project alone
- each slide should support one speaking moment
- every technical claim must match the real codebase
- avoid fake metrics unless clearly presented as demo values
- do not present unfinished features as delivered features

## Visual Rules

- reuse the InternHub brand colors
- stay lighter and cleaner than the application UI
- prioritize spacing and hierarchy over decoration
- keep typography large enough for projection
- avoid overloaded diagrams

## Inputs To Reuse

- execution docs
- UX documentation
- demo script
- technical argumentaire
- current implemented UI

## Final Validation Checklist

- slides open locally without broken assets
- timeline fits the oral slot
- demo handoff between slides and live app is smooth
- screenshots reflect the current product state
- no contradiction between the deck and the delivered repo
