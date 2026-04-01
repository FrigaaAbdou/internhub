# 5-Minute Soutenance Presentation Plan

This document defines a short, defensible version of the `InternHub` presentation for a soutenance of about `5 minutes`, followed by a live technical demo.

It is grounded in:

- the project brief,
- the functional specifications `SFx`,
- the technical specifications `STx`,
- the scoping documentation,
- the product backlog,
- the execution plan,
- the `PERT` and `Gantt` planning documents,
- and the application that was actually built.

The goal is not to explain everything.
The goal is to show:

1. that the team understood the client need,
2. that the project was managed seriously as a group,
3. that the specifications were translated into a real product,
4. and that the demo which follows is logical and controlled.

---

## 1. Narrative Direction

The presentation should follow a simple logic:

1. need
2. framing and methodology
3. specifications
4. implementation
5. verification
6. transition to the demo

The live demo then becomes the concrete proof.

---

## 2. Recommended Format

- target duration: `5 minutes`
- recommended slide count: `6`
- tone: professional, clear, concrete
- promise: do not sell a "perfect" project, but a project that was understood, structured, implemented, and verified

Recommended timing:

| Slide | Topic | Target duration |
| --- | --- | --- |
| 1 | Context and objective | 35 s |
| 2 | Need analysis and specifications | 50 s |
| 3 | Team organization and project management | 55 s |
| 4 | Design and architecture | 55 s |
| 5 | Delivered product | 60 s |
| 6 | Verification and transition to demo | 45 s |

Total:
`5 minutes`

---

## 3. Slide-By-Slide Plan

## Slide 1 - Context And Objective

### Goal

Open the presentation cleanly and restate the client need.

### Core Message

`InternHub` is a web platform for internship management that centralizes offers, companies, and applications in order to simplify both internship search and follow-up.

### Show On Screen

- project name: `InternHub`
- short subtitle:
  `Internship management web platform`
- one context sentence:
  `The project answers the need to centralize internship offers, company data, and application follow-up in one platform.`
- logo and visual identity

### Say Out Loud

- the client expected a website to make internship search easier,
- the goal was not only to display offers,
- the platform also had to structure companies, applications, and role-based access.

### Recommended Visual

- clean cover slide
- logo
- one product preview or screenshot
- very little text

### Transition

`Before developing the platform, we first analyzed the project brief and turned the expectations into usable specifications.`

---

## Slide 2 - Need Analysis And Specifications

### Goal

Show that the project comes directly from the brief, not from an improvised interpretation.

### Core Message

The project was built from both functional and technical specifications, with explicit decisions on the unclear parts of the brief.

### Show On Screen

Two main blocks:

#### Block A - Functional Specifications

- `SFx1` authentication and access management
- `SFx2 to SFx10` companies and offers
- `SFx16 to SFx25` students, applications, and wish-list
- `SFx11` statistics

#### Block B - Technical Specifications

- mandatory `MVC` architecture
- `PHP`, `HTML/CSS/JS`, `SQL DBMS`
- front-end and back-end validation
- responsive design
- security: `CSRF`, SQL injection prevention, `XSS`
- unit tests

### Say Out Loud

- the brief left some room for interpretation,
- we therefore produced an operational functional reference,
- and we translated the technical constraints into concrete development decisions.

### Documents To Reference

- [03-referentiel-fonctionnel.md](/Users/abdoufrigaa/Projects/internhub/docs/01-cadrage/03-referentiel-fonctionnel.md)
- [04-roles-et-permissions.md](/Users/abdoufrigaa/Projects/internhub/docs/01-cadrage/04-roles-et-permissions.md)
- [13-validation-mvp.md](/Users/abdoufrigaa/Projects/internhub/docs/03-execution/13-validation-mvp.md)

### Recommended Visual

- two-column slide
- left column: functional
- right column: technical
- a few `SFx` and `STx` chips or labels

### Transition

`Because the project was developed as a team, we also had to organize the work in a clear and defensible way.`

---

## Slide 3 - Team Organization And Project Management

### Goal

Show that the project was managed like a real team project.

### Core Message

We worked as a group by structuring the project with a backlog, phased execution, and dependency planning.

### Show On Screen

Three sub-parts:

#### 1. Work Organization

- group of `4`
- `Scrum` logic
- backlog
- sprints
- progressive delivery

#### 2. Management Tools

- product backlog
- phase plan
- shared documentation

#### 3. Planning

- `PERT` for dependencies
- `Gantt` for planning and sequencing

### Say Out Loud

- we did not start by coding immediately,
- we first split the project into phases and epics,
- the backlog was used to prioritize work,
- the `PERT` diagram helped us identify the critical path,
- the `Gantt` diagram helped us visualize parallel work,
- and the shared documentation allowed everyone to understand what the others were doing.

### Documents To Reference

- [10-backlog-produit.md](/Users/abdoufrigaa/Projects/internhub/docs/03-execution/10-backlog-produit.md)
- [09-plan-phases-execution.md](/Users/abdoufrigaa/Projects/internhub/docs/03-execution/09-plan-phases-execution.md)
- [07-diagrammes-pert-gantt.md](/Users/abdoufrigaa/Projects/internhub/docs/02-architecture/07-diagrammes-pert-gantt.md)

### Important Point To Say Clearly

Do not only say `we used Scrum`.
Say instead:

`We used a Scrum-oriented workflow with backlog and sprints, but we also formalized technical dependencies with PERT and team planning with Gantt so that the whole group could keep a shared view of the project.`

### Recommended Visual

- a simple group / backlog / PERT / Gantt schema
- or a short timeline with 4 blocks:
  `scoping`, `UX`, `development`, `stabilization`

### Transition

`Once the organization was in place, we could design the product and define how to build it cleanly.`

---

## Slide 4 - Design And Architecture

### Goal

Show the maturity of the design work before the code.

### Core Message

The project was first designed in terms of roles, user flows, pages, data, and architecture.

### Show On Screen

Two axes:

#### UX / Functional Axis

- wireframes
- view inventory
- public, student, pilot, and admin flows
- mobile-first logic

#### Technical Axis

- `MVC` architecture
- router
- controllers
- server-rendered views
- `PDO` repositories
- SQL database

### Say Out Loud

- we documented the pages before styling them,
- we separated the application into page families:
  public, student, pilot, admin, CRUD, system,
- this helped us move forward without UX inconsistency,
- on the technical side, we chose a plain `MVC` architecture without framework, in line with the brief.

### Documents To Reference

- [06-architecture-mvc.md](/Users/abdoufrigaa/Projects/internhub/docs/02-architecture/06-architecture-mvc.md)
- [15-inventaire-vues.md](/Users/abdoufrigaa/Projects/internhub/docs/04-ux/15-inventaire-vues.md)
- [18-wireframes-structurels-mvp.md](/Users/abdoufrigaa/Projects/internhub/docs/04-ux/18-wireframes-structurels-mvp.md)

### Recommended Visual

- a simple left/right diagram:
  `Flows and pages` / `MVC architecture`
- or a layered architecture diagram

### Transition

`That design phase then led to a complete and demonstrable application.`

---

## Slide 5 - Delivered Product

### Goal

Quickly show what was actually implemented.

### Core Message

The project covers the core workflows from the brief and delivers a real product that can be demonstrated end to end.

### Show On Screen

Blocks or screenshots around:

- public consultation of offers and companies
- student area:
  dashboard, applications, wish-list, profile
- pilot area:
  roster, student follow-up, student account creation
- admin area:
  accounts, companies, offers
- statistics and support pages

### Say Out Loud

- the site is not limited to a basic CRUD,
- it covers the expected user profiles,
- permissions are enforced server-side,
- and the pages were redesigned in coherent families.

### Documents / Proof To Reference

- [25-spec-pages-publiques-listing-detail.md](/Users/abdoufrigaa/Projects/internhub/docs/04-ux/25-spec-pages-publiques-listing-detail.md)
- [26-spec-pages-etudiant.md](/Users/abdoufrigaa/Projects/internhub/docs/04-ux/26-spec-pages-etudiant.md)
- [27-spec-pages-pilote.md](/Users/abdoufrigaa/Projects/internhub/docs/04-ux/27-spec-pages-pilote.md)
- [28-spec-pages-admin.md](/Users/abdoufrigaa/Projects/internhub/docs/04-ux/28-spec-pages-admin.md)
- [29-spec-pages-management-crud.md](/Users/abdoufrigaa/Projects/internhub/docs/04-ux/29-spec-pages-management-crud.md)

### Recommended Visual

- a collage of up to 4 screenshots:
  public, student, pilot, admin
- keep it very readable

### Transition

`Finally, we also worked on reliability and presentation readiness, not only on features.`

---

## Slide 6 - Verification And Transition To Demo

### Goal

Show that the project is stabilized and launch the demo.

### Core Message

The project is testable, repeatable, and ready for a live technical demo.

### Show On Screen

- unit tests
- smoke tests
- security:
  sessions, CSRF, permissions
- demo dataset
- demo script / rehearsal logic

### Say Out Loud

- we added unit tests with `PHPUnit`,
- we completed them with HTTP smoke tests,
- we prepared a resettable demo dataset,
- and we also prepared the soutenance with a demo script and a controlled demo flow.

### Documents To Reference

- [tests/README.md](/Users/abdoufrigaa/Projects/internhub/tests/README.md)
- [22-verification-phase-p8.md](/Users/abdoufrigaa/Projects/internhub/docs/03-execution/22-verification-phase-p8.md)
- [24-script-demo-p9.md](/Users/abdoufrigaa/Projects/internhub/docs/03-execution/24-script-demo-p9.md)
- [25-jeu-donnees-comptes-demo-p9.md](/Users/abdoufrigaa/Projects/internhub/docs/03-execution/25-jeu-donnees-comptes-demo-p9.md)

### Recommended Closing Line

`We will now move to the live technical demo to show these workflows directly in the application.`

### Recommended Visual

- 4 proof cards:
  `Tests`, `Security`, `Demo data`, `Ready for demo`

---

## 4. What Must Be Said Explicitly During The Presentation

The following points must be said out loud, otherwise they may disappear behind the demo:

### 1. We started from the project brief

The jury must hear that the project is a direct translation of the client need.

### 2. We formalized the specifications

Say clearly that we clarified:

- roles,
- permissions,
- the MVP scope,
- the ambiguous parts of the brief.

### 3. We worked as a team with real organization

Say explicitly:

- backlog,
- sprints,
- Scrum logic,
- shared documentation,
- `PERT` for dependencies,
- `Gantt` for planning.

### 4. We documented the project so everyone could follow it

The documentation was not decorative.
It was used to:

- share decisions,
- split work clearly,
- maintain a common vision,
- prepare development and the soutenance.

### 5. The demo will confirm what was just presented

The presentation should create expectation for the concrete proof, not repeat the entire demo in advance.

---

## 5. What To Avoid

- do not read the project brief aloud
- do not go through every `SFx` one by one
- do not overwhelm the jury with file names
- do not explain the full project history
- do not show a purely technical slide disconnected from the client need
- do not spend too much time on architecture
- do not duplicate the demo

---

## 6. Final Recommendation

For a `5-minute` soutenance, the best strategy is:

- `2 slides` to show that the team understood and managed the project,
- `2 slides` to show that the work was designed seriously,
- `1 slide` to show the delivered product,
- `1 slide` to show that it was verified,
- then move to the live demo.

In one sentence:

`The thread of the presentation should be: understood need, organized work, structured project, delivered product, controlled demo.`
