<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Core\Auth;
use App\Core\Controller;
use App\Core\Request;
use App\Core\Response;
use App\Core\Session;
use App\Models\CompanyRepository;
use App\Models\OfferRepository;
use App\Models\WishlistRepository;

final class OfferController extends Controller
{
    public function __construct(
        private readonly OfferRepository $offers = new OfferRepository(),
        private readonly CompanyRepository $companies = new CompanyRepository(),
        private readonly WishlistRepository $wishlists = new WishlistRepository(),
    ) {
    }

    public function index(Request $request): Response
    {
        $page = max(1, (int) $request->query('page', 1));
        $filters = [
            'q' => trim((string) $request->query('q', '')),
            'location' => trim((string) $request->query('location', '')),
            'contract_type' => trim((string) $request->query('contract_type', '')),
        ];
        $paginated = $this->offers->paginate($page, 9, $filters);
        $filterOptions = $this->offers->filterOptions();

        return $this->view('offers/index', [
            'offers' => $paginated['data'],
            'filters' => $filters,
            'currentPage' => $paginated['currentPage'],
            'lastPage' => $paginated['lastPage'],
            'total' => $paginated['total'],
            'perPage' => $paginated['perPage'],
            'companyCount' => $this->companies->countAll(),
            'filterOptions' => $filterOptions,
            'featuredCompanies' => array_slice($this->companies->all(), 0, 6),
            'managementPath' => $this->managementBasePath(),
            'isStudent' => Auth::hasRole('etudiant'),
            'isGuest' => ! Auth::check(),
        ]);
    }

    public function show(Request $request): Response
    {
        $offer = $this->offers->find((int) $request->route('id'));

        if (! is_array($offer)) {
            $this->abort(404);
        }

        return $this->view('offers/show', [
            'offer' => $offer,
            'relatedOffers' => $this->offers->findRelated((int) $offer['company_id'], (int) $offer['id']),
            'managementPath' => $this->managementBasePath(),
            'isStudent' => Auth::hasRole('etudiant'),
            'isGuest' => ! Auth::check(),
            'isWishlisted' => Auth::hasRole('etudiant') && $this->wishlists->exists((int) Auth::id(), (int) $offer['id']),
        ]);
    }

    public function manage(Request $request): Response
    {
        $this->abortUnlessManager();

        $page = max(1, (int) $request->query('page', 1));
        $search = trim((string) $request->query('q', ''));
        $paginated = $this->offers->paginateForManagement($page, 10, $search);

        return $this->view('offers/manage', [
            'offers' => $paginated['data'],
            'search' => $search,
            'total' => $paginated['total'],
            'currentPage' => $paginated['currentPage'],
            'lastPage' => $paginated['lastPage'],
            'managementPath' => $this->managementBasePath(),
            'roleLabel' => $this->roleLabel(),
        ]);
    }

    public function create(Request $request): Response
    {
        $this->abortUnlessManager();

        return $this->view('offers/form', [
            'errors' => [],
            'values' => $this->defaultValues(),
            'companies' => $this->companies->all(),
            'formAction' => $this->managementBasePath() . '/create',
            'cancelPath' => $this->managementBasePath(),
            'title' => 'Creer une offre',
            'roleLabel' => $this->roleLabel(),
        ]);
    }

    public function store(Request $request): Response
    {
        $this->abortUnlessManager();
        [$values, $errors] = $this->validatePayload($request);

        if ($errors !== []) {
            return $this->view('offers/form', [
                'errors' => $errors,
                'values' => $values,
                'companies' => $this->companies->all(),
                'formAction' => $this->managementBasePath() . '/create',
                'cancelPath' => $this->managementBasePath(),
                'title' => 'Creer une offre',
                'roleLabel' => $this->roleLabel(),
            ], 422);
        }

        $this->offers->create(
            (int) $values['company_id'],
            $values['title'],
            $values['location'],
            $values['contract_type'],
            $values['description'],
            $values['is_published'] === '1',
        );
        Session::flash('success', 'L offre a bien ete creee.');

        return $this->redirect($this->managementBasePath());
    }

    public function edit(Request $request): Response
    {
        $this->abortUnlessManager();
        $offer = $this->findOffer((int) $request->route('id'));

        return $this->view('offers/form', [
            'errors' => [],
            'values' => [
                'id' => (string) $offer['id'],
                'company_id' => (string) $offer['company_id'],
                'title' => (string) $offer['title'],
                'location' => (string) $offer['location'],
                'contract_type' => (string) $offer['contract_type'],
                'description' => (string) $offer['description'],
                'is_published' => (string) ((int) ($offer['is_published'] ?? 0)),
            ],
            'companies' => $this->companies->all(),
            'formAction' => $this->managementBasePath() . '/' . $offer['id'] . '/edit',
            'cancelPath' => $this->managementBasePath(),
            'title' => 'Modifier une offre',
            'roleLabel' => $this->roleLabel(),
        ]);
    }

    public function update(Request $request): Response
    {
        $this->abortUnlessManager();
        $offer = $this->findOffer((int) $request->route('id'));
        [$values, $errors] = $this->validatePayload($request);
        $values['id'] = (string) $offer['id'];

        if ($errors !== []) {
            return $this->view('offers/form', [
                'errors' => $errors,
                'values' => $values,
                'companies' => $this->companies->all(),
                'formAction' => $this->managementBasePath() . '/' . $offer['id'] . '/edit',
                'cancelPath' => $this->managementBasePath(),
                'title' => 'Modifier une offre',
                'roleLabel' => $this->roleLabel(),
            ], 422);
        }

        $this->offers->update(
            (int) $offer['id'],
            (int) $values['company_id'],
            $values['title'],
            $values['location'],
            $values['contract_type'],
            $values['description'],
            $values['is_published'] === '1',
        );
        Session::flash('success', 'L offre a bien ete mise a jour.');

        return $this->redirect($this->managementBasePath());
    }

    public function delete(Request $request): Response
    {
        $this->abortUnlessManager();
        $offer = $this->findOffer((int) $request->route('id'));

        if ($this->offers->countApplications((int) $offer['id']) > 0) {
            Session::flash('error', 'Cette offre ne peut pas etre supprimee tant que des candidatures y sont rattachees.');

            return $this->redirect($this->managementBasePath());
        }

        $this->offers->delete((int) $offer['id']);
        Session::flash('success', 'L offre a bien ete supprimee.');

        return $this->redirect($this->managementBasePath());
    }

    private function validatePayload(Request $request): array
    {
        $values = [
            'company_id' => trim((string) $request->input('company_id', '')),
            'title' => trim((string) $request->input('title', '')),
            'location' => trim((string) $request->input('location', '')),
            'contract_type' => trim((string) $request->input('contract_type', '')),
            'description' => trim((string) $request->input('description', '')),
            'is_published' => $request->input('is_published') === '1' ? '1' : '0',
        ];
        $errors = [];

        if ($values['company_id'] === '' || ! ctype_digit($values['company_id'])) {
            $errors['company_id'] = 'Une entreprise valide est requise.';
        }

        foreach ([
            'title' => 'Le titre est requis.',
            'location' => 'La localisation est requise.',
            'contract_type' => 'Le type de contrat est requis.',
        ] as $field => $message) {
            if ($values[$field] === '') {
                $errors[$field] = $message;
            }
        }

        if ($values['description'] === '') {
            $errors['description'] = 'La description est requise.';
        }

        return [$values, $errors];
    }

    private function findOffer(int $id): array
    {
        $offer = $this->offers->findForManagement($id);

        if (! is_array($offer)) {
            $this->abort(404);
        }

        return $offer;
    }

    private function abortUnlessManager(): void
    {
        if (! Auth::hasRole('administrateur', 'pilote')) {
            $this->abort(403);
        }
    }

    private function managementBasePath(): ?string
    {
        return match (Auth::role()) {
            'administrateur' => '/admin/offres',
            'pilote' => '/dashboard/pilote/offres',
            default => null,
        };
    }

    private function roleLabel(): string
    {
        return match (Auth::role()) {
            'administrateur' => 'Administrateur',
            'pilote' => 'Pilote',
            default => 'Gestion',
        };
    }

    private function defaultValues(): array
    {
        return [
            'company_id' => '',
            'title' => '',
            'location' => '',
            'contract_type' => '',
            'description' => '',
            'is_published' => '1',
        ];
    }
}
