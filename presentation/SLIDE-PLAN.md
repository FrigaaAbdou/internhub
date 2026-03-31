# Slide-By-Slide Presentation Plan

This document defines the full presentation structure for the InternHub soutenance.

It is intentionally a planning artifact, not the final slide execution.
Each slide is specified so the Reveal.js deck can be built consistently, without improvising the story, the content order, or the visual intent.

## Presentation Target

- target duration: `10` minutes
- acceptable duration window: `8` to `12` minutes
- target slide count: `11` slides
- tone: professional, concrete, defensible
- narrative direction: from problem to product, from product to architecture, from architecture to proof

## Global Rules

- one core message per slide
- no slide should try to explain the whole project
- every claim must be supported by the implemented repository
- product slides should use screenshots or UI fragments later
- technical slides should stay understandable to a non-developer jury
- the live demo must feel like the continuation of the deck, not a separate performance

## Reveal.js Behavior Rules

- horizontal progression for the main story
- no nested vertical stacks unless strictly needed later
- use simple slide transitions only
- use fragments sparingly:
  - acceptable for role reveal,
  - acceptable for architecture layering,
  - avoid fragmenting every bullet
- no autoplay
- no heavy motion
- speaker notes should be added later, not mixed into slide copy

## Slide 01. Title / Opening

### Goal

Open the soutenance cleanly, establish the project identity, and frame InternHub in one sentence.

### Audience Takeaway

`InternHub` is a real internship management platform with clear scope and a coherent final delivery.

### On-Screen Structure

- project name
- short subtitle
- team / school / year placeholders
- one short positioning sentence

### Recommended Copy Direction

- title: `InternHub`
- subtitle: `Internship management platform`
- one supporting line explaining that the application centralizes offers, companies, applications, and role-based follow-up

### Visual Direction

- clean cover slide
- brand mark visible
- large title
- minimal metadata chips

### Speaker Goal

Set the context and announce that the project will be presented through:
- need,
- users,
- product,
- architecture,
- verification,
- demo.

### Duration

- `30` to `40` seconds

### Transition

Move from project identity to the concrete problem being solved.

## Slide 02. Problem And Context

### Goal

Explain why the project exists and why internship management deserves a dedicated platform.

### Audience Takeaway

The project is not a generic CRUD app; it answers a real coordination problem.

### On-Screen Structure

- short problem statement
- 3 pain points max
- one synthesis sentence

### Recommended Content Blocks

- information scattered across multiple tools
- weak follow-up between students and coordinators
- difficulty keeping offers, companies, and applications consistent

### Visual Direction

- 3-column problem cards or one left text block plus 3 supporting cards

### Speaker Goal

Show that the platform solves operational friction, not just a technical exercise.

### Duration

- `45` seconds

### Transition

Move from the problem to the people and roles involved.

## Slide 03. Users And Roles

### Goal

Present the functional structure of the product through its four roles.

### Audience Takeaway

Role separation is central to the product, not a secondary technical detail.

### On-Screen Structure

- 4 role blocks:
  - anonymous visitor
  - student
  - pilot
  - administrator

### Recommended Content

For each role:
- what they can access
- what they are here for

### Visual Direction

- four cards in grid
- or a horizontal role progression
- distinct but not overdesigned role chips

### Speaker Goal

Anchor the rest of the presentation in permissions and workflows.

### Duration

- `50` seconds

### Transition

Move from the actors to the product scope they activate.

## Slide 04. Product Scope

### Goal

Show the main application modules and the overall platform perimeter.

### Audience Takeaway

The app is complete enough to support a real end-to-end internship workflow.

### On-Screen Structure

- public consultation
- student workflow
- pilot supervision
- admin governance

### Recommended Content

- public pages: offers, companies, statistics
- student pages: apply, track, wishlist, profile
- pilot pages: roster, follow-up, student supervision
- admin pages: accounts and core management

### Visual Direction

- 4 module cards
- or one workflow band with 4 blocks

### Speaker Goal

Provide a product map before showing deeper functional proof.

### Duration

- `45` seconds

### Transition

Move from scope to the most demonstrable functional paths.

## Slide 05. Functional Highlights

### Goal

Summarize the strongest end-to-end product paths before the live demo.

### Audience Takeaway

The product supports concrete workflows, not just isolated screens.

### On-Screen Structure

- 3 highlighted flows:
  - explore and consult
  - apply and track
  - supervise and manage

### Recommended Content

- public user browses offers and companies
- student submits and follows applications
- pilot/admin manage the ecosystem with separated permissions

### Visual Direction

- numbered process blocks
- or a left-to-right workflow lane

### Speaker Goal

Prepare the jury for the later demo by making the logic legible now.

### Duration

- `45` seconds

### Transition

Move from the functional product to the technical structure that supports it.

## Slide 06. Technical Architecture

### Goal

Explain the architecture in a way that is clear, short, and defensible.

### Audience Takeaway

The project uses plain PHP MVC without framework, with a simple but solid structure.

### On-Screen Structure

- one architecture diagram or layered blocks:
  - front controller / router
  - controllers
  - views
  - repositories / PDO
  - SQL database

### Recommended Content

- server-rendered application
- route dispatch
- controller orchestration
- repository-based data access
- `PDO`

### Visual Direction

- one clean system diagram
- avoid huge UML complexity

### Speaker Goal

Show that the codebase is understandable, not accidental.

### Duration

- `1` minute

### Transition

Move from architecture to the rules that secure and constrain usage.

## Slide 07. Security And Permissions

### Goal

Show how role separation is enforced and why the system is safe enough for a soutenance-level delivery.

### Audience Takeaway

Permissions are enforced server-side and backed by explicit controls.

### On-Screen Structure

- 3 pillars:
  - role guards
  - session and CSRF
  - protected file/data access

### Recommended Content

- matrix-driven permissions
- middleware-based route protection
- `CSRF` on sensitive forms
- session handling
- CV download restricted to the right scope

### Visual Direction

- 3 security cards
- optional small shield/check iconography

### Speaker Goal

Make it clear that hiding buttons is not the security model; server-side control is.

### Duration

- `1` minute

### Transition

Move from security to the visible result: the interface and page-family redesign.

## Slide 08. UI/UX And Page Families

### Goal

Show that the UI work was structured and deliberate across the whole app.

### Audience Takeaway

The interface is not one-off styling; it was redesigned consistently by page family.

### On-Screen Structure

- public pages
- student pages
- pilot pages
- admin pages
- CRUD management pages
- support/system pages

### Recommended Content

- mention responsive, mobile-first, and page-family consistency
- mention that every major family now has its own coherent visual layer

### Visual Direction

- matrix of page families
- or 6 compact cards with one screenshot each later

### Speaker Goal

Demonstrate that UX work was methodical, not cosmetic.

### Duration

- `50` seconds

### Transition

Move from what was built to how it was verified.

## Slide 09. Verification And Stability

### Goal

Prove that the project was tested and stabilized, not only implemented.

### Audience Takeaway

The delivery includes verification, reproducibility, and technical discipline.

### On-Screen Structure

- unit tests
- smoke tests
- demo reset
- error handling

### Recommended Content

- `PHPUnit`
- `P6`, `P7`, `P8` smoke scripts
- reset demo state
- `403`, `404`, `500`

### Visual Direction

- verification checklist
- or a 4-card proof layout

### Speaker Goal

Make the jury trust the project’s stability before the demo starts.

### Duration

- `50` seconds

### Transition

Move into the live demonstration sequence.

## Slide 10. Demo Flow

### Goal

Prepare the audience for the live walkthrough and make the sequence understandable before clicking through the app.

### Audience Takeaway

The demo is intentional and follows the product logic from public consultation to governance.

### On-Screen Structure

- public sequence
- student sequence
- pilot sequence
- admin sequence

### Recommended Content

- public: home, offers, companies, statistics
- student: login, dashboard, applications, profile
- pilot: dashboard, students, follow-up
- admin: dashboard, accounts, management

### Visual Direction

- timeline or 4-step route map

### Speaker Goal

Set expectations and reduce the risk of a confusing live demo.

### Duration

- `40` seconds

### Transition

Move from the demo plan to the final project conclusion.

## Slide 11. Conclusion

### Goal

Close the presentation cleanly with the value of the project and a realistic statement of maturity.

### Audience Takeaway

InternHub is a coherent, defendable, working delivery with clear role separation, complete user journeys, and verified behavior.

### On-Screen Structure

- short closing statement
- 3 takeaway points
- optional final Q&A prompt

### Recommended Content

- end-to-end internship workflow
- clear role separation
- verified and demo-ready delivery

### Visual Direction

- calm closing slide
- minimal content
- strong final sentence

### Speaker Goal

End with confidence and without overselling.

### Duration

- `30` seconds

### Final Transition

Open Q&A or move directly into the live demo, depending on the oral format.

## Recommended Slide Ownership

If the speaking split from [28-repartition-soutenance-p9.md](/Users/abdoufrigaa/Projects/internhub/docs/03-execution/28-repartition-soutenance-p9.md#L1) is kept:

- `Intervenant 1`:
  - Slide 01
  - Slide 02
  - Slide 03
- `Intervenant 2`:
  - Slide 04
  - Slide 05
  - Slide 06
  - Slide 07
- `Intervenant 3`:
  - Slide 08
  - Slide 09
  - Slide 10
- `Intervenant 4`:
  - Slide 11
  - Q&A bridge

## Implementation Notes For Next Step

When moving from plan to execution:

- keep the deck to `11` slides unless there is a strong reason to expand
- prefer screenshots of the actual application over abstract mockups
- keep slide text shorter than the material in this planning doc
- add speaker notes separately
- validate the deck against the real app before calling it final
