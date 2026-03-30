<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Core\Auth;
use App\Core\Controller;
use App\Core\Request;
use App\Core\Response;
use App\Core\Session;
use App\Models\OfferRepository;
use App\Models\WishlistRepository;

final class WishlistController extends Controller
{
    public function __construct(
        private readonly WishlistRepository $wishlists = new WishlistRepository(),
        private readonly OfferRepository $offers = new OfferRepository(),
    ) {
    }

    public function index(Request $request): Response
    {
        return $this->view('student/wishlist', [
            'items' => $this->wishlists->forStudent((int) Auth::id()),
        ]);
    }

    public function store(Request $request): Response
    {
        $offer = $this->offers->find((int) $request->route('id'));

        if (! is_array($offer)) {
            $this->abort(404);
        }

        $studentId = (int) Auth::id();

        if ($this->wishlists->exists($studentId, (int) $offer['id'])) {
            Session::flash('success', 'Cette offre est deja dans votre wish-list.');

            return $this->redirect('/offres/' . $offer['id']);
        }

        $this->wishlists->add($studentId, (int) $offer['id']);
        Session::flash('success', 'L offre a bien ete ajoutee a votre wish-list.');

        return $this->redirect('/offres/' . $offer['id']);
    }

    public function destroy(Request $request): Response
    {
        $offerId = (int) $request->route('offerId');
        $studentId = (int) Auth::id();

        if (! $this->wishlists->exists($studentId, $offerId)) {
            Session::flash('error', 'Cette offre n est pas presente dans votre wish-list.');

            return $this->redirect('/dashboard/etudiant/wishlist');
        }

        $this->wishlists->remove($studentId, $offerId);
        Session::flash('success', 'L offre a ete retiree de votre wish-list.');

        $redirectTo = trim((string) $request->input('redirect_to', ''));

        if ($redirectTo === '/offres/' . $offerId) {
            return $this->redirect($redirectTo);
        }

        return $this->redirect('/dashboard/etudiant/wishlist');
    }
}
