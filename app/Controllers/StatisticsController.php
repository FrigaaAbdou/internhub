<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Core\Controller;
use App\Core\Request;
use App\Core\Response;
use App\Models\StatisticsRepository;

final class StatisticsController extends Controller
{
    public function __construct(
        private readonly StatisticsRepository $statistics = new StatisticsRepository(),
    ) {
    }

    public function index(Request $request): Response
    {
        $overview = $this->statistics->overview();

        return $this->view('statistics/index', [
            'publishedOfferCount' => $overview['publishedOfferCount'],
            'companyCount' => $overview['companyCount'],
            'applicationCount' => $overview['applicationCount'],
            'averageApplicationsPerOffer' => $overview['averageApplicationsPerOffer'],
            'topLocations' => $overview['topLocations'],
            'topContractTypes' => $overview['topContractTypes'],
            'applicationStatuses' => $overview['applicationStatuses'],
        ]);
    }
}
