@php
    $siteUrl = rtrim(url('/'), '/');
    $organizationId = $siteUrl . '/#organization';
    $websiteId = $siteUrl . '/#website';
    $globalStructuredData = [
        '@context' => 'https://schema.org',
        '@graph' => [
            [
                '@type' => 'ComputerStore',
                '@id' => $organizationId,
                'name' => 'Comp.MD',
                'legalName' => 'IT Service Grup SRL',
                'url' => $siteUrl,
                'logo' => [
                    '@type' => 'ImageObject',
                    'url' => asset('logo.png'),
                ],
                'image' => asset('img/remont-noutbukov.jpg'),
                'telephone' => '+37360229129',
                'openingHoursSpecification' => [
                    '@type' => 'OpeningHoursSpecification',
                    'dayOfWeek' => ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday'],
                    'opens' => '09:00',
                    'closes' => '18:00',
                ],
                'address' => [
                    '@type' => 'PostalAddress',
                    'streetAddress' => 'str. Sarmizegetusa 51, et. 1, of. 130',
                    'addressLocality' => 'Chișinău',
                    'addressCountry' => 'MD',
                ],
                'geo' => [
                    '@type' => 'GeoCoordinates',
                    'latitude' => 46.97940753107701,
                    'longitude' => 28.88139437678703,
                ],
                'hasMap' => 'https://www.google.com/maps/search/?api=1&query=46.97940753107701,28.88139437678703',
                'areaServed' => [
                    '@type' => 'City',
                    'name' => 'Chișinău',
                ],
                'contactPoint' => [
                    [
                        '@type' => 'ContactPoint',
                        'telephone' => '+37360229129',
                        'contactType' => 'customer service',
                        'availableLanguage' => ['Romanian', 'Russian'],
                    ],
                    [
                        '@type' => 'ContactPoint',
                        'telephone' => '+37378373736',
                        'contactType' => 'customer service',
                        'availableLanguage' => ['Romanian', 'Russian'],
                    ],
                ],
                'sameAs' => ['https://www.facebook.com/compmd1'],
            ],
            [
                '@type' => 'WebSite',
                '@id' => $websiteId,
                'url' => $siteUrl,
                'name' => 'Comp.MD',
                'inLanguage' => ['ro', 'ru'],
                'publisher' => ['@id' => $organizationId],
            ],
        ],
    ];
@endphp
<script type="application/ld+json">{!! json_encode($globalStructuredData, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) !!}</script>
