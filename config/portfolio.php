<?php

/*
|--------------------------------------------------------------------------
| Portfolio content
|--------------------------------------------------------------------------
|
| Content lives here so the views stay presentational while the Filament
| resources are being built. Every key maps one-to-one onto a column, so
| swapping a section over to Eloquent later is a controller change, not a
| view change — see README-FRONTEND.md.
|
*/

return [

    'identity' => [
        'name'      => 'Mustafa Abou El-Hajj',
        'short'     => 'Abou El-Hajj',
        'role'      => 'Full-Stack Systems & Web Engineer',
        'location'  => 'Zahlé, Lebanon',
        'email'     => 'maboualhajj@gmail.com',
        'phone'     => '+961 70 535 819',
        'phone_tel' => '+96170535819',
        'github'    => 'https://github.com/Mustafa3654',
        'linkedin'  => 'https://www.linkedin.com/in/mustafa-abou-alhajj-a55848279',
        'cv'        => '/documents/mustafa-abou-el-hajj-cv.pdf',
        'employer'  => 'Computronics SARL',
        'available' => true,
        'about'     => 'I started on the support desk and ended up writing the software. That order "
                     . "matters: most of what I build replaces something I first had to keep alive by "
                     . "hand — a POS that lost data, a deployment that took an hour of remote support, "
                     . "an order book living in a WhatsApp thread. I work across the whole stack, from "
                     . "Ubuntu servers and legacy FoxPro databases up to Laravel and Filament, and I "
                     . "assemble the hardware too — including the machine this was built on.',
    ],

    /*
    | Root domain that project subdomains hang off. Change once, updates
    | everywhere.
    |
    | Each project below picks its own address: give it a 'host' to sit on a
    | subdomain of this root (host 'wassili' -> wassili.mustafa.dev), or a
    | 'domain' to use a domain it owns outright ('wassili.com'). A project with
    | neither is treated as not deployed and shows no live button. This is also
    | switchable per project from the Filament admin panel.
    */
    'domain' => 'mustafa.dev',

    'hero' => [
        'headline'    => ['I build the systems', 'businesses actually', 'run on.'],
        'accent_line' => 2, // zero-indexed line rendered in brass
        'bio'         => 'Full-stack systems & web engineer. I ship multi-vendor delivery dispatch, '
                       . 'bilingual storefronts, QR menus, and the admin panels that keep all of it '
                       . 'honest — for the Lebanese market, where dual currency, Arabic RTL and a '
                       . 'WhatsApp-first customer are requirements, not edge cases.',
        'stats'       => [
            ['label' => 'Shipped',    'value' => '28 projects'],
            ['label' => 'Core stack', 'value' => 'Laravel'],
            ['label' => 'Languages',  'value' => 'EN / AR'],
        ],
    ],

    /*
    | The deployment board — the hero's signature element. Each row is a real
    | subdomain, so `host` is the identifier rather than an invented number.
    */
    'board' => [
        ['host' => 'wassili',  'summary' => 'Multi-vendor delivery & dispatch',   'status' => 'live'],
        ['host' => 'sortifya', 'summary' => 'Crowdsourced micro-task platform',   'status' => 'live'],
        ['host' => 'amanelle', 'summary' => 'Bilingual cosmetics storefront',     'status' => 'live'],
        ['host' => 'menu',     'summary' => 'QR menus for restaurants',           'status' => 'live'],
        ['host' => 'nabil',    'summary' => 'Restaurant ordering + Telegram admin', 'status' => 'live'],
        ['host' => 'recipes',  'summary' => 'Lebanese home-cooking archive',      'status' => 'beta'],
    ],

    /*
    | Spotlight case studies. Problem/solution is the structure because these
    | two products were both built to replace a specific manual workaround.
    */
    'spotlight' => [
        [
            'name'     => 'Wassili',
            'host'     => 'wassili',
            'tagline'  => 'Multi-vendor delivery & marketplace platform',
            'repo'     => null, // repository is private
            'problem'  => 'Local shops took orders in WhatsApp threads and dispatched drivers by voice '
                        . 'note. Nothing was recorded, prices drifted between USD and LBP, and nobody '
                        . 'could say where an order was without calling three people. Off-the-shelf '
                        . 'delivery apps assumed a single vendor, one currency, and a customer willing '
                        . 'to install something.',
            'solution' => 'A cart that splits one basket across several merchants, then hands each '
                        . 'merchant its own slice as a formatted WhatsApp message they can accept '
                        . 'without leaving the app they already live in. Every order gets a record, a '
                        . 'dual-currency total pinned to the day\'s rate, and a tracking state that '
                        . 'customers and drivers read from the same source.',
            'points'   => [
                'One cart splits into per-merchant orders',
                'WhatsApp dispatch, no merchant app required',
                'USD + LBP pricing on a managed rate',
                'Driver assignment and live order state',
            ],
            'stack'    => ['Laravel', 'Blade', 'Filament', 'MySQL', 'WhatsApp API', 'Tailwind'],
            'flow'     => [
                'title'     => 'Order path',
                'note'      => 'The merchant never installs anything. The ticket arrives where they already are.',
                'steps'     => [
                    ['label' => 'Customer basket'],
                    ['label' => 'Split by merchant', 'accent' => true],
                    ['label' => ['Merchant A', 'Merchant B'], 'split' => true],
                    ['label' => 'WhatsApp ticket'],
                    ['label' => 'Driver & tracking'],
                ],
            ],
        ],
        [
            'name'      => 'Sortifya',
            'host'      => 'sortifya',
            'tagline'   => 'Crowdsourced micro-task data platform',
            'repo'      => 'https://github.com/Mustafa3654/sortifya',
            'media_first' => true, // alternates the rhythm against Wassili
            'problem'   => 'Businesses sit on archives of scanned paper that OCR mangles — handwriting, '
                         . 'stamps, Arabic and English on the same page. Digitising it means paying '
                         . 'people, and paying people means tracking who did which page, whether it was '
                         . 'right, and what they are owed. That bookkeeping is what usually kills the '
                         . 'project.',
            'solution'  => 'A queue where workers claim a single PDF, transcribe it into a structured '
                         . 'sheet, and submit for review. Approvals credit a per-worker balance; '
                         . 'withdrawal requests push a notification straight into the admin panel with '
                         . 'the payout amount and the work it covers. The ledger is the product — the '
                         . 'transcription is just the input.',
            'points'    => [
                'PDF extraction into structured Excel',
                'Task claiming with per-worker locks',
                'Review queue before anything is paid',
                'Withdrawal alerts in the admin panel',
            ],
            'stack'     => ['Laravel', 'Filament', 'MySQL', 'PhpSpreadsheet', 'Queues', 'EN / AR RTL'],
            'flow'      => [
                'title' => 'Task lifecycle',
                'note'  => 'A claimed task locks to one worker, so two people can never bill for the same page.',
                'steps' => [
                    ['label' => 'Scanned PDF batch'],
                    ['label' => 'Worker claims task'],
                    ['label' => 'Transcribe → Excel', 'accent' => true],
                    ['label' => 'Admin review'],
                    ['label' => 'Withdrawal + notify'],
                ],
            ],
        ],
    ],

    'categories' => [
        'all'      => 'All',
        'apps'     => 'Web apps',
        'commerce' => 'Commerce & menus',
        'tools'    => 'Tools & scripts',
        'games'    => 'Games & mobile',
    ],

    /*
    | Every project. `host` puts it on a subdomain of the root domain, `domain`
    | gives it its own, neither means it isn't publicly deployed.
    |
    | Repo links are deliberately null where the GitHub repository is private or
    | has been deleted — a "Code" button that 404s is worse than no button.
    */
    'projects' => [

        // -- Web apps ------------------------------------------------------
        [
            'category' => 'apps',
            'kind'     => 'Web app',
            'name'     => 'Wassili',
            'summary'  => 'On-demand delivery marketplace connecting customers, local stores and '
                        . 'independent drivers - WhatsApp dispatch, real-time tracking, USD + LBP pricing.',
            'stack'    => 'Laravel · Blade · MySQL',
            'status'   => 'live',
            'host'     => 'wassili',
            'repo'     => null, // repository is private
        ],
        [
            'category' => 'apps',
            'kind'     => 'Web app',
            'name'     => 'Sortifya',
            'summary'  => 'Micro-task data entry: claim a scanned PDF, transcribe it to Excel, get '
                        . 'paid in USD. Review queue and withdrawal ledger built in.',
            'stack'    => 'Laravel · Filament · EN/AR RTL',
            'status'   => 'live',
            'host'     => 'sortifya',
            'repo'     => 'https://github.com/Mustafa3654/sortifya',
        ],
        [
            'category' => 'apps',
            'kind'     => 'API',
            'name'     => 'MedVault API',
            'summary'  => 'ASP.NET Core API sitting between a hospital mobile app and a legacy FoxPro '
                        . '+ SQL Server HIS. Reproduces the existing contract exactly so the app works '
                        . 'unchanged, and adds radiology and authenticated file download.',
            'stack'    => 'ASP.NET Core · C# · SQL Server · FoxPro',
            'status'   => 'wip',
            'host'     => null,
            'repo'     => null,
        ],
        [
            'category' => 'apps',
            'kind'     => 'Web app',
            'name'     => 'AI agentic job board',
            'summary'  => 'A job board turned into a two-sided AI-human marketplace, with an agentic '
                        . 'API that lets software act on a listing the way a person would.',
            'stack'    => 'Laravel 12 · MySQL',
            'status'   => 'wip',
            'host'     => null,
            'repo'     => null,
        ],
        [
            'category' => 'apps',
            'kind'     => 'Web app',
            'name'     => 'Pharmacy management system',
            'summary'  => 'AI-assisted pharmacy management - stock, dispensing and reporting for a '
                        . 'counter that cannot stop while the software thinks.',
            'stack'    => 'Laravel · MySQL',
            'status'   => 'wip',
            'host'     => null,
            'repo'     => null,
        ],
        [
            'category' => 'apps',
            'kind'     => 'Web app',
            'name'     => 'Local job assistant',
            'summary'  => 'A browser tool that reads local job listings and drafts tailored '
                        . 'applications, so a search stops being copy-paste work.',
            'stack'    => 'JavaScript · HTML · CSS',
            'status'   => 'complete',
            'host'     => null,
            'repo'     => 'https://github.com/Mustafa3654/mustafa-local-job-assistant',
        ],
        [
            'category' => 'apps',
            'kind'     => 'Web app',
            'name'     => 'Recipes',
            'summary'  => 'An archive of Lebanese home cooking - searchable by ingredient, scalable '
                        . 'by serving count, written in Arabic and English.',
            'stack'    => 'PHP · MySQL',
            'status'   => 'beta',
            'host'     => 'recipes',
            'repo'     => null,
        ],
        [
            'category' => 'apps',
            'kind'     => 'Web app',
            'name'     => 'Dietitian practice platform',
            'summary'  => 'Full-stack practice website for a dietitian - performance-focused, '
                        . 'responsive, with content management the practitioner runs themselves.',
            'stack'    => 'Laravel · MySQL · Blade',
            'status'   => 'live',
            'host'     => null,
            'repo'     => null,
        ],

        [
            'category' => 'apps',
            'kind'     => 'Web app',
            'name'     => 'This portfolio',
            'summary'  => 'The site you are reading. Laravel 13 and Filament v5, with every section - '
                        . 'projects, experience, CV, even the hero copy - editable from the admin panel '
                        . 'rather than hardcoded.',
            'stack'    => 'Laravel 13 · Filament 5 · Tailwind 4',
            'status'   => 'live',
            'host'     => null,
            'repo'     => 'https://github.com/Mustafa3654/my-portfolio',
        ],

        // -- Commerce & menus ----------------------------------------------
        [
            'category' => 'commerce',
            'kind'     => 'E-commerce',
            'name'     => 'Amanelle Beauty',
            'summary'  => 'Bilingual (ar/en) cosmetics storefront with full RTL and a Filament back '
                        . 'office for stock, pricing and orders.',
            'stack'    => 'Laravel 13 · Filament 5 · Livewire 4',
            'status'   => 'live',
            'host'     => 'amanelle',
            'repo'     => null, // repository is private
        ],
        [
            'category' => 'commerce',
            'kind'     => 'Digital menu',
            'name'     => 'AlphaMenu',
            'summary'  => 'Responsive QR menu with an admin dashboard for dishes, categories, '
                        . 'branding, pricing and bulk imports. No developer needed to change a price.',
            'stack'    => 'PHP · MySQL · QR',
            'status'   => 'live',
            'host'     => 'menu',
            'repo'     => null, // repository no longer on GitHub
        ],
        [
            'category' => 'commerce',
            'kind'     => 'Storefront',
            'name'     => 'Nabil Mediterranean Food',
            'summary'  => 'Official site and menu management system with online ordering, plus an AI '
                        . 'Telegram assistant so the owner can run it from their phone.',
            'stack'    => 'PHP · MySQL · Telegram Bot',
            'status'   => 'live',
            'host'     => 'nabil',
            'repo'     => 'https://github.com/Mustafa3654/nabil-mediterranean-food',
        ],
        [
            'category' => 'commerce',
            'kind'     => 'Mobile POS',
            'name'     => 'Tableside ordering system',
            'summary'  => 'Tablet-optimised ordering for waitstaff, with direct IP printing that routes '
                        . 'each ticket straight to the right kitchen station - no manual relay step.',
            'stack'    => 'PHP · MySQL · IP printing',
            'status'   => 'in-use',
            'host'     => null,
            'repo'     => null, // repository no longer on GitHub
        ],
        [
            'category' => 'commerce',
            'kind'     => 'Storefront',
            'name'     => 'Fashion store',
            'summary'  => 'Early e-commerce build - catalogue browsing, cart and checkout, written '
                        . 'before the framework habits set in.',
            'stack'    => 'PHP · JavaScript · MySQL',
            'status'   => 'complete',
            'host'     => null,
            'repo'     => null,
        ],

        // -- Tools & scripts -----------------------------------------------
        [
            'category' => 'tools',
            'kind'     => 'Modernisation',
            'name'     => 'Legacy ERP dependency migration',
            'summary'  => 'Moved a C# WinForms ERP onto .NET Framework 4.8.1, working through breaking '
                        . 'changes across deprecated and renamed packages - and found a spoofed NuGet '
                        . 'package in the tree, removing a supply-chain compromise before it shipped.',
            'stack'    => 'C# · .NET Framework 4.8.1 · NuGet',
            'status'   => 'private',
            'host'     => null,
            'repo'     => null,
        ],
        [
            'category' => 'tools',
            'kind'     => 'Integration',
            'name'     => 'FoxPro to WhatsApp bridge',
            'summary'  => 'A data bridge joining a hospital\'s FoxPro system to SQL Server to drive '
                        . 'automated WhatsApp patient messages - real-time outreach on infrastructure '
                        . 'that predates modern APIs by decades.',
            'stack'    => 'FoxPro · SQL Server · WhatsApp Business API',
            'status'   => 'in-use',
            'host'     => null,
            'repo'     => null,
        ],
        [
            'category' => 'tools',
            'kind'     => 'Integration',
            'name'     => 'AlphaSoft POS integrations',
            'summary'  => 'Direct API connections for JHScale (TM-xA) digital scales and secondary '
                        . 'customer-facing display modules, deployed across 100+ active terminals.',
            'stack'    => 'C# · PowerShell · Hardware API',
            'status'   => 'in-use',
            'host'     => null,
            'repo'     => null,
        ],
        [
            'category' => 'tools',
            'kind'     => 'Internal tool',
            'name'     => 'POS automation scripts',
            'summary'  => 'One-click update and backup protocols embedded directly into the AlphaSoft '
                        . 'POS, cutting manual maintenance time by 70% and ending recurring data-loss '
                        . 'incidents.',
            'stack'    => 'PowerShell · Bash · AlphaSoft',
            'status'   => 'in-use',
            'host'     => null,
            'repo'     => null,
        ],
        [
            'category' => 'tools',
            'kind'     => 'Installer',
            'name'     => 'Automated deployment installer',
            'summary'  => 'A PowerShell deployment process rebuilt as a standalone installer covering '
                        . 'SQL Server connectivity, license provisioning and client configuration - '
                        . 'about half the remote support time it replaced.',
            'stack'    => 'PowerShell · SQL Server',
            'status'   => 'in-use',
            'host'     => null,
            'repo'     => null,
        ],
        [
            'category' => 'tools',
            'kind'     => 'Internal tool',
            'name'     => 'Support ticketing system',
            'summary'  => 'A dedicated ticketing workflow that took average response time from 3-4 '
                        . 'hours down to half an hour, handling around 40 tickets a month.',
            'stack'    => 'PHP · MySQL',
            'status'   => 'in-use',
            'host'     => null,
            'repo'     => null,
        ],
        [
            'category' => 'tools',
            'kind'     => 'Infrastructure',
            'name'     => 'Ubuntu server infrastructure',
            'summary'  => 'Company-wide Linux server estate - SSH access, firewalls and hardening for '
                        . 'staff and client accounts, held at 24/7 uptime.',
            'stack'    => 'Ubuntu Server · SSH · UFW',
            'status'   => 'private',
            'host'     => null,
            'repo'     => null,
        ],
        [
            'category' => 'tools',
            'kind'     => 'Internal tool',
            'name'     => 'Telegram admin assistant',
            'summary'  => 'A bot that answers owner questions about orders and stock in plain '
                        . 'language, so opening the admin panel is optional rather than mandatory.',
            'stack'    => 'PHP · Telegram API · LLM',
            'status'   => 'in-use',
            'host'     => null,
            'repo'     => 'https://github.com/Mustafa3654/nabil-mediterranean-food',
        ],
        [
            'category' => 'tools',
            'kind'     => 'Internal tool',
            'name'     => 'Feedback collector',
            'summary'  => 'A drop-in form and dashboard for gathering customer responses across '
                        . 'client sites, with CSV export for whoever asks.',
            'stack'    => 'PHP · MySQL · JavaScript',
            'status'   => 'in-use',
            'host'     => null,
            'repo'     => 'https://github.com/Mustafa3654/feedback',
        ],
        [
            'category' => 'tools',
            'kind'     => 'Hardware',
            'name'     => 'PC building & hardware assembly',
            'summary'  => 'Specifying and assembling desktop machines from bare components, including '
                        . 'my own workstation - plus the POS terminal, scale and display hardware '
                        . 'diagnostics that come with supporting 100+ client tills.',
            'stack'    => 'Assembly · Diagnostics · POS hardware',
            'status'   => 'in-use',
            'host'     => null,
            'repo'     => null,
        ],

        // -- Games & mobile -------------------------------------------------
        [
            'category' => 'games',
            'kind'     => 'Game',
            'name'     => "The Summer of '94",
            'summary'  => 'A Unity game in active development - the current after-hours project, and '
                        . 'the one that keeps the C# sharp outside of business software.',
            'stack'    => 'Unity · C#',
            'status'   => 'wip',
            'host'     => null,
            'repo'     => 'https://github.com/Mustafa3654/The-Summer-of-94',
        ],
        [
            'category' => 'games',
            'kind'     => 'Game',
            'name'     => 'CyberpunkExpress',
            'summary'  => 'A fast-paced 3D arcade delivery game built with Unity 6 and the Universal '
                        . 'Render Pipeline. Same domain as the day job, played for speed.',
            'stack'    => 'Unity 6 · URP · C#',
            'status'   => 'complete',
            'host'     => null,
            'repo'     => 'https://github.com/Mustafa3654/CyberpunkExpress',
        ],
        [
            'category' => 'games',
            'kind'     => 'Mobile app',
            'name'     => 'Kalemni',
            'summary'  => 'Cross-platform messaging app with OTP phone authentication, dynamic '
                        . 'profiles and real-time text across five screens on a Firestore backend.',
            'stack'    => 'Flutter · Firebase · Firestore',
            'status'   => 'complete',
            'host'     => null,
            'repo'     => null,
        ],
        [
            'category' => 'games',
            'kind'     => 'Game',
            'name'     => 'Snake',
            'summary'  => 'The classic, rebuilt in the browser with a test suite - a small exercise in '
                        . 'getting game loop timing right without a engine underneath.',
            'stack'    => 'JavaScript · HTML Canvas',
            'status'   => 'complete',
            'host'     => null,
            'repo'     => null,
        ],
    ],


    /*
    | Replaces the usual skill-percentage bars. These are constraints, not
    | proficiency claims — each one is something a client can actually check.
    */
    'practice' => [
        [
            'label' => 'Dual currency',
            'title' => 'Prices that hold when the rate moves',
            'body'  => 'Totals stored in USD, shown in LBP at a rate the owner controls, and frozen onto '
                     . 'the order at checkout so a receipt never disagrees with itself later.',
        ],
        [
            'label' => 'WhatsApp-first',
            'title' => 'Meeting people where they already are',
            'body'  => 'Structured orders delivered as readable messages. No merchant downloads an app, '
                     . 'and the system still keeps a clean record of what was agreed.',
        ],
        [
            'label' => 'Arabic & RTL',
            'title' => 'Bilingual as a layout problem',
            'body'  => 'Right-to-left support with mirrored components, correct numeral handling and '
                     . 'translated admin panels — built in from the schema up, not bolted on.',
        ],
        [
            'label' => 'Admin panels',
            'title' => 'Software the owner can run alone',
            'body'  => 'Filament back offices with the resources, filters and bulk actions a '
                     . 'non-technical owner needs. If they have to call me to change a price, I built it wrong.',
        ],
        [
            'label' => 'Hosting',
            'title' => 'Deployment is part of the job',
            'body'  => 'Ubuntu Server infrastructure with SSH access and firewalls held at 24/7 '
                     . 'uptime, plus subdomain routing, TLS, cron and restores. Running this at '
                     . 'Computronics SARL means shipping doesn\'t stop at the merge.',
        ],
        [
            'label' => 'Hardware',
            'title' => 'Comfortable below the software line',
            'body'  => 'I specify and assemble machines from bare components - including my own '
                     . 'workstation - and diagnose the POS terminals, scales and displays the '
                     . 'software talks to. Knowing the hardware makes the integration bugs shorter.',
        ],
        [
            'label' => 'Thin connections',
            'title' => 'Fast on the network people have',
            'body'  => 'Server-rendered pages, small payloads and cached queries — because the customer '
                     . 'is on mobile data during a power cut, not on fibre.',
        ],
    ],

    /*
    | Experience, education and credentials. Time genuinely is a sequence here,
    | so unlike the project grid these carry dates as the structural device.
    */
    'credentials' => [
        'experience' => [
            [
                'role'   => 'IT Specialist - Systems & Development',
                'org'    => 'Computronics SARL',
                'place'  => 'Zahlé, Lebanon',
                'from'   => 'Dec 2024',
                'to'     => 'Aug 2026',
                'points' => [
                    'AlphaSoft POS/ERP integrations across 100+ active client terminals, including '
                        . 'direct hardware API connections for JHScale (TM-xA) scales and '
                        . 'customer-facing display modules',
                    'Led a dependency migration of a legacy C# WinForms ERP to .NET Framework 4.8.1, '
                        . 'and identified a spoofed NuGet package in the tree - removing a '
                        . 'supply-chain compromise before it reached production',
                    'Architected a FoxPro-to-SQL Server bridge driving automated WhatsApp patient '
                        . 'messaging for a hospital client, on infrastructure that predates modern APIs',
                    'Rebuilt a PowerShell deployment process as a standalone installer, cutting remote '
                        . 'support time by around half',
                    'Administered the company Ubuntu Server estate - SSH access and firewall policy at '
                        . '24/7 uptime',
                    'Embedded one-click update and backup automation into the POS, cutting manual '
                        . 'maintenance by 70% and ending recurring data loss',
                    'Designed and ran the internal support ticketing system: average response time '
                        . '3-4 hours down to 30 minutes, around 40 tickets a month',
                ],
            ],
            [
                'role'   => 'IT Support Intern',
                'org'    => 'Computronics SARL',
                'place'  => 'Zahlé, Lebanon',
                'from'   => 'Nov 2024',
                'to'     => 'Dec 2024',
                'points' => [
                    'Supported AlphaSoft accounting rollouts through data migration, setup and training',
                    'Remote technical support via AnyDesk',
                ],
            ],
        ],

        'education' => [
            [
                'award' => 'BSc Computer Science',
                'org'   => 'Lebanese International University',
                'from'  => 'Oct 2021',
                'to'    => 'Aug 2024',
            ],
        ],

        'certifications' => [
            [
                'award' => 'AI Training Hackathon',
                'org'   => 'Kanz AI · LAU Academy of Continuing Education',
                'date'  => 'July 2026',
                'id'    => 'KANZ-ATT-9E9B85F4E2',
                'file'  => '/documents/kanz-ai-certificate.pdf',
            ],
        ],

        'languages' => [
            ['name' => 'Arabic',  'level' => 'Native'],
            ['name' => 'English', 'level' => 'Professional working'],
        ],
    ],

    'contact' => [
        'heading' => ['Have a system that only exists', 'in someone\'s WhatsApp?'],
        'body'    => 'Tell me what the workaround is and who depends on it. I\'ll tell you what it takes '
                   . 'to replace it — scope, stack and timeline, before any invoice.',
        'details' => [
            ['label' => 'Based in',   'value' => 'Zahlé, Lebanon'],
            ['label' => 'Working',    'value' => 'Remote / on-site'],
            ['label' => 'Reply time', 'value' => 'Within a day'],
        ],
    ],
];
