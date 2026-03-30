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

final class CompanyController extends Controller
{
    public function __construct(
        private readonly CompanyRepository $companies = new CompanyRepository(),
        private readonly OfferRepository $offers = new OfferRepository(),
    ) {
    }

    public function index(Request $request): Response
    {
        $page = max(1, (int) $request->query('page', 1));
        $search = trim((string) $request->query('q', ''));
        $paginated = $this->companies->paginate($page, 6, $search);
        $facets = $this->companies->publicFacets();

        return $this->view('companies/index', [
            'companies' => $paginated['data'],
            'search' => $search,
            'total' => $paginated['total'],
            'currentPage' => $paginated['currentPage'],
            'lastPage' => $paginated['lastPage'],
            'offerCount' => $this->offers->countPublished(),
            'cityCount' => (int) ($facets['cityCount'] ?? 0),
            'industryCount' => (int) ($facets['industryCount'] ?? 0),
            'featuredCities' => array_slice((array) ($facets['cities'] ?? []), 0, 6),
            'featuredIndustries' => array_slice((array) ($facets['industries'] ?? []), 0, 6),
            'managementPath' => $this->managementBasePath(),
        ]);
    }

    public function show(Request $request): Response
    {
        $company = $this->companies->find((int) $request->route('id'));

        if (! is_array($company)) {
            $this->abort(404);
        }

        return $this->view('companies/show', [
            'company' => $company,
            'managementPath' => $this->managementBasePath(),
        ]);
    }

    public function manage(Request $request): Response
    {
        $this->abortUnlessManager();

        $page = max(1, (int) $request->query('page', 1));
        $search = trim((string) $request->query('q', ''));
        $paginated = $this->companies->paginateForManagement($page, 10, $search);

        return $this->view('companies/manage', [
            'companies' => $paginated['data'],
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

        return $this->view('companies/form', [
            'errors' => [],
            'values' => $this->defaultValues(),
            'formAction' => $this->managementBasePath() . '/create',
            'cancelPath' => $this->managementBasePath(),
            'title' => 'Creer une entreprise',
            'roleLabel' => $this->roleLabel(),
        ]);
    }

    public function store(Request $request): Response
    {
        $this->abortUnlessManager();
        [$values, $errors] = $this->validatePayload($request);

        if ($errors !== []) {
            return $this->view('companies/form', [
                'errors' => $errors,
                'values' => $values,
                'formAction' => $this->managementBasePath() . '/create',
                'cancelPath' => $this->managementBasePath(),
                'title' => 'Creer une entreprise',
                'roleLabel' => $this->roleLabel(),
            ], 422);
        }

        $this->companies->create(
            $values['name'],
            $values['industry'],
            $values['city'],
            $values['website'] === '' ? null : $values['website'],
            $values['description'],
        );
        Session::flash('success', 'L entreprise a bien ete creee.');

        return $this->redirect($this->managementBasePath());
    }

    public function edit(Request $request): Response
    {
        $this->abortUnlessManager();
        $company = $this->findCompany((int) $request->route('id'));

        return $this->view('companies/form', [
            'errors' => [],
            'values' => [
                'id' => (string) $company['id'],
                'name' => (string) $company['name'],
                'industry' => (string) $company['industry'],
                'city' => (string) $company['city'],
                'website' => (string) ($company['website'] ?? ''),
                'description' => (string) $company['description'],
            ],
            'formAction' => $this->managementBasePath() . '/' . $company['id'] . '/edit',
            'cancelPath' => $this->managementBasePath(),
            'title' => 'Modifier une entreprise',
            'roleLabel' => $this->roleLabel(),
        ]);
    }

    public function update(Request $request): Response
    {
        $this->abortUnlessManager();
        $company = $this->findCompany((int) $request->route('id'));
        [$values, $errors] = $this->validatePayload($request);
        $values['id'] = (string) $company['id'];

        if ($errors !== []) {
            return $this->view('companies/form', [
                'errors' => $errors,
                'values' => $values,
                'formAction' => $this->managementBasePath() . '/' . $company['id'] . '/edit',
                'cancelPath' => $this->managementBasePath(),
                'title' => 'Modifier une entreprise',
                'roleLabel' => $this->roleLabel(),
            ], 422);
        }

        $this->companies->update(
            (int) $company['id'],
            $values['name'],
            $values['industry'],
            $values['city'],
            $values['website'] === '' ? null : $values['website'],
            $values['description'],
        );
        Session::flash('success', 'L entreprise a bien ete mise a jour.');

        return $this->redirect($this->managementBasePath());
    }

    public function delete(Request $request): Response
    {
        $this->abortUnlessManager();
        $company = $this->findCompany((int) $request->route('id'));

        if ($this->companies->countOffers((int) $company['id']) > 0) {
            Session::flash('error', 'Cette entreprise ne peut pas etre supprimee tant que des offres y sont rattachees.');

            return $this->redirect($this->managementBasePath());
        }

        $this->companies->delete((int) $company['id']);
        Session::flash('success', 'L entreprise a bien ete supprimee.');

        return $this->redirect($this->managementBasePath());
    }

    private function validatePayload(Request $request): array
    {
        $values = [
            'name' => trim((string) $request->input('name', '')),
            'industry' => trim((string) $request->input('industry', '')),
            'city' => trim((string) $request->input('city', '')),
            'website' => trim((string) $request->input('website', '')),
            'description' => trim((string) $request->input('description', '')),
        ];
        $errors = [];

        foreach (['name' => 'Le nom est requis.', 'industry' => 'Le secteur est requis.', 'city' => 'La ville est requise.'] as $field => $message) {
            if ($values[$field] === '') {
                $errors[$field] = $message;
            }
        }

        if ($values['description'] === '') {
            $errors['description'] = 'La description est requise.';
        }

        if ($values['website'] !== '' && filter_var($values['website'], FILTER_VALIDATE_URL) === false) {
            $errors['website'] = 'Merci de saisir une URL valide.';
        }

        return [$values, $errors];
    }

    private function findCompany(int $id): array
    {
        $company = $this->companies->find($id);

        if (! is_array($company)) {
            $this->abort(404);
        }

        return $company;
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
            'administrateur' => '/admin/entreprises',
            'pilote' => '/dashboard/pilote/entreprises',
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
            'name' => '',
            'industry' => '',
            'city' => '',
            'website' => '',
            'description' => '',
        ];
    }
}
