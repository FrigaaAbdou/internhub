<?php

declare(strict_types=1);

$databasePath = __DIR__ . '/../storage/database/internhub.sqlite';
$directory = dirname($databasePath);
$storagePath = dirname(__DIR__) . '/storage';

if (! is_dir($directory)) {
    mkdir($directory, 0775, true);
}

ensureDemoAssets($storagePath);

$pdo = new PDO('sqlite:' . $databasePath);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$pdo->exec(
    'CREATE TABLE IF NOT EXISTS promotions (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        name TEXT NOT NULL
    )'
);

$pdo->exec(
    'CREATE TABLE IF NOT EXISTS users (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        first_name TEXT NOT NULL,
        last_name TEXT NOT NULL,
        email TEXT NOT NULL UNIQUE,
        password_hash TEXT NOT NULL,
        role TEXT NOT NULL,
        promotion_id INTEGER NULL,
        created_at TEXT NOT NULL
    )'
);

$pdo->exec(
    'CREATE TABLE IF NOT EXISTS companies (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        name TEXT NOT NULL,
        industry TEXT NOT NULL,
        city TEXT NOT NULL,
        website TEXT NULL,
        description TEXT NOT NULL,
        created_at TEXT NOT NULL
    )'
);

$pdo->exec(
    'CREATE TABLE IF NOT EXISTS offers (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        company_id INTEGER NOT NULL,
        title TEXT NOT NULL,
        location TEXT NOT NULL,
        contract_type TEXT NOT NULL,
        description TEXT NOT NULL,
        is_published INTEGER NOT NULL DEFAULT 1,
        created_at TEXT NOT NULL
    )'
);

$pdo->exec(
    'CREATE TABLE IF NOT EXISTS applications (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        student_id INTEGER NOT NULL,
        offer_id INTEGER NOT NULL,
        cover_letter TEXT NULL,
        cv_path TEXT NULL,
        status TEXT NOT NULL,
        created_at TEXT NOT NULL
    )'
);

$pdo->exec(
    'CREATE TABLE IF NOT EXISTS wishlists (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        student_id INTEGER NOT NULL,
        offer_id INTEGER NOT NULL,
        created_at TEXT NOT NULL
    )'
);

$pdo->exec(
    'CREATE UNIQUE INDEX IF NOT EXISTS idx_wishlists_student_offer
     ON wishlists (student_id, offer_id)'
);

$applicationColumns = $pdo->query("PRAGMA table_info(applications)")->fetchAll(PDO::FETCH_ASSOC);
$applicationColumnNames = array_column($applicationColumns, 'name');

if (! in_array('cover_letter', $applicationColumnNames, true)) {
    $pdo->exec('ALTER TABLE applications ADD COLUMN cover_letter TEXT NULL');
}

if (! in_array('cv_path', $applicationColumnNames, true)) {
    $pdo->exec('ALTER TABLE applications ADD COLUMN cv_path TEXT NULL');
}

$count = (int) $pdo->query('SELECT COUNT(*) FROM promotions')->fetchColumn();

if ($count === 0) {
    $pdo->exec("INSERT INTO promotions (name) VALUES ('Promotion 2026')");
}

$userCount = (int) $pdo->query('SELECT COUNT(*) FROM users')->fetchColumn();

if ($userCount === 0) {
    $now = date('Y-m-d H:i:s');
    $promotionId = (int) $pdo->query('SELECT id FROM promotions LIMIT 1')->fetchColumn();

    $statement = $pdo->prepare(
        'INSERT INTO users (first_name, last_name, email, password_hash, role, promotion_id, created_at)
         VALUES (:first_name, :last_name, :email, :password_hash, :role, :promotion_id, :created_at)'
    );

    foreach ([
        ['Alice', 'Admin', 'admin@internhub.test', 'Admin123!', 'administrateur', null],
        ['Paul', 'Pilot', 'pilot@internhub.test', 'Pilot123!', 'pilote', $promotionId],
        ['Emma', 'Student', 'student@internhub.test', 'Student123!', 'etudiant', $promotionId],
        ['Lina', 'Martin', 'lina@internhub.test', 'Student123!', 'etudiant', $promotionId],
    ] as [$firstName, $lastName, $email, $password, $role, $promotion]) {
        $statement->execute([
            'first_name' => $firstName,
            'last_name' => $lastName,
            'email' => $email,
            'password_hash' => password_hash($password, PASSWORD_DEFAULT),
            'role' => $role,
            'promotion_id' => $promotion,
            'created_at' => $now,
        ]);
    }
}

$companyCount = (int) $pdo->query('SELECT COUNT(*) FROM companies')->fetchColumn();

if ($companyCount === 0) {
    $now = date('Y-m-d H:i:s');
    $companies = [
        ['Aster Labs', 'Data', 'Paris', 'https://aster.example.test', 'Cabinet specialise dans les projets data et IA appliquee.'],
        ['Blue Harbor', 'Conseil', 'Lyon', 'https://blueharbor.example.test', 'Entreprise de conseil avec une forte culture produit.'],
        ['North Grid', 'Energie', 'Lille', 'https://northgrid.example.test', 'Acteur industriel avec des besoins applicatifs et data.'],
        ['Creative Forge', 'Design', 'Bordeaux', 'https://creativeforge.example.test', 'Studio produit et design numerique travaillant avec des equipes tech et marketing.'],
        ['Peak Metrics', 'Fintech', 'Nantes', 'https://peakmetrics.example.test', 'Societe analytiques et fintech avec des besoins en dashboards, data et operations.'],
        ['Nova Health', 'Sante', 'Toulouse', 'https://novahealth.example.test', 'Entreprise healthtech orientee produit, support utilisateurs et outils internes.'],
    ];

    $statement = $pdo->prepare(
        'INSERT INTO companies (name, industry, city, website, description, created_at)
         VALUES (:name, :industry, :city, :website, :description, :created_at)'
    );

    foreach ($companies as [$name, $industry, $city, $website, $description]) {
        $statement->execute([
            'name' => $name,
            'industry' => $industry,
            'city' => $city,
            'website' => $website,
            'description' => $description,
            'created_at' => $now,
        ]);
    }
}

$offerCount = (int) $pdo->query('SELECT COUNT(*) FROM offers')->fetchColumn();

if ($offerCount === 0) {
    $now = date('Y-m-d H:i:s');
    $companyIds = $pdo->query('SELECT id FROM companies ORDER BY id ASC')->fetchAll(PDO::FETCH_COLUMN);
    $offers = [
        [$companyIds[0], 'Stage Data Analyst', 'Paris', 'Stage 6 mois', 'Analyse de donnees, reporting et visualisation.', 1],
        [$companyIds[0], 'Stage Product Data', 'Paris', 'Stage 4 mois', 'Support produit et mesure de la performance.', 1],
        [$companyIds[1], 'Stage Consultant Digital', 'Lyon', 'Stage 6 mois', 'Appui au cadrage et au delivery de projets digitaux.', 1],
        [$companyIds[2], 'Stage Developpement interne', 'Lille', 'Stage 5 mois', 'Contribution a des outils internes et tableaux de bord.', 1],
        [$companyIds[3], 'Stage UX Research Assistant', 'Bordeaux', 'Stage 4 mois', 'Participation aux tests utilisateurs, syntheses de recherche et analyses parcours.', 1],
        [$companyIds[3], 'Stage Product Design Intern', 'Bordeaux', 'Stage 6 mois', 'Contribution au design system, wireframes et prototypes de produits numeriques.', 1],
        [$companyIds[4], 'Stage Business Analyst Intern', 'Nantes', 'Stage 6 mois', 'Analyse metier, documentation de flux et preparation de tableaux de bord.', 1],
        [$companyIds[4], 'Stage Operations Data Intern', 'Nantes', 'Stage 5 mois', 'Suivi de KPIs operations, automatisation de reportings et support data quotidien.', 1],
        [$companyIds[5], 'Stage Health Product Coordinator', 'Toulouse', 'Stage 6 mois', 'Coordination fonctionnelle entre produit, support et documentation interne.', 1],
        [$companyIds[5], 'Stage Support & Process Intern', 'Toulouse', 'Stage 4 mois', 'Appui aux process de support, qualite et amélioration continue.', 1],
        [$companyIds[1], 'Stage Product Operations', 'Lyon', 'Stage 5 mois', 'Support aux equipes produit, organisation des feedbacks clients et priorisation.', 1],
        [$companyIds[2], 'Stage Data Visualisation Intern', 'Lille', 'Stage 6 mois', 'Creation de dashboards, visualisation et structuration des analyses internes.', 1],
    ];

    $statement = $pdo->prepare(
        'INSERT INTO offers (company_id, title, location, contract_type, description, is_published, created_at)
         VALUES (:company_id, :title, :location, :contract_type, :description, :is_published, :created_at)'
    );

    foreach ($offers as [$companyId, $title, $location, $contractType, $description, $published]) {
        $statement->execute([
            'company_id' => $companyId,
            'title' => $title,
            'location' => $location,
            'contract_type' => $contractType,
            'description' => $description,
            'is_published' => $published,
            'created_at' => $now,
        ]);
    }
}

$applicationCount = (int) $pdo->query('SELECT COUNT(*) FROM applications')->fetchColumn();

if ($applicationCount === 0) {
    $studentId = (int) $pdo->query("SELECT id FROM users WHERE email = 'student@internhub.test' LIMIT 1")->fetchColumn();
    $offerIds = $pdo->query('SELECT id FROM offers ORDER BY id ASC LIMIT 2')->fetchAll(PDO::FETCH_COLUMN);
    $now = date('Y-m-d H:i:s');
    $statement = $pdo->prepare(
        'INSERT INTO applications (student_id, offer_id, cover_letter, cv_path, status, created_at)
         VALUES (:student_id, :offer_id, :cover_letter, :cv_path, :status, :created_at)'
    );

    foreach ($offerIds as $offerId) {
        $statement->execute([
            'student_id' => $studentId,
            'offer_id' => $offerId,
            'cover_letter' => 'Candidature de demonstration pour la soutenance.',
            'cv_path' => 'uploads/demo/demo-student-cv.pdf',
            'status' => 'envoyee',
            'created_at' => $now,
        ]);
    }
}

echo "SQLite database initialized at {$databasePath}\n";

function ensureDemoAssets(string $storagePath): void
{
    $demoDirectory = $storagePath . '/uploads/demo';

    if (! is_dir($demoDirectory)) {
        mkdir($demoDirectory, 0775, true);
    }

    $demoCvPath = $demoDirectory . '/demo-student-cv.pdf';

    if (! is_file($demoCvPath)) {
        file_put_contents($demoCvPath, minimalPdf('InternHub Demo CV'));
    }
}

function minimalPdf(string $title): string
{
    $title = preg_replace('/[^A-Za-z0-9 ]/', '', $title) ?: 'InternHub Demo CV';
    $stream = "BT\n/F1 18 Tf\n72 720 Td\n({$title}) Tj\n0 -28 Td\n/F1 12 Tf\n(Demo document generated for the InternHub soutenance.) Tj\nET";
    $length = strlen($stream);
    $objects = [
        1 => '<< /Type /Catalog /Pages 2 0 R >>',
        2 => '<< /Type /Pages /Count 1 /Kids [3 0 R] >>',
        3 => '<< /Type /Page /Parent 2 0 R /MediaBox [0 0 595 842] /Resources << /Font << /F1 4 0 R >> >> /Contents 5 0 R >>',
        4 => '<< /Type /Font /Subtype /Type1 /BaseFont /Helvetica >>',
        5 => "<< /Length {$length} >> stream\n{$stream}\nendstream",
    ];

    $pdf = "%PDF-1.4\n";
    $offsets = [0];

    foreach ($objects as $number => $body) {
        $offsets[$number] = strlen($pdf);
        $pdf .= "{$number} 0 obj\n{$body}\nendobj\n";
    }

    $xrefOffset = strlen($pdf);
    $pdf .= 'xref' . "\n";
    $pdf .= '0 ' . (count($objects) + 1) . "\n";
    $pdf .= "0000000000 65535 f \n";

    foreach (array_keys($objects) as $number) {
        $pdf .= sprintf("%010d 00000 n \n", $offsets[$number]);
    }

    $pdf .= 'trailer << /Size ' . (count($objects) + 1) . ' /Root 1 0 R >>' . "\n";
    $pdf .= 'startxref' . "\n";
    $pdf .= $xrefOffset . "\n";
    $pdf .= "%%EOF";

    return $pdf;
}
