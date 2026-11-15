<?php

return [
    'Adlaon' => '001', 'Agsungot' => '002', 'Apas' => '003', 'Babag' => '004',
    'Bacayan' => '005', 'Banawa' => '006', 'Banilad' => '007', 'Basak Pardo' => '008',
    'Basak San Nicolas' => '009', 'Binaliw' => '010', 'Bo.Luz' => '011', 'Bonbon' => '012',
    'Bout-Taup' => '013', 'Budlaan' => '014', 'Buhisan' => '015', 'Bulacao' => '016',
    'Busay' => '017', 'Calamba' => '018', 'Cambinocot' => '019', 'Capitol' => '020',
    'Carreta' => '021', 'Cogon Pardo' => '022', 'Cogon Ramos' => '023', 'Day-as' => '024',
    'Duljo' => '025', 'Ermita' => '026', 'Guadalupe' => '027', 'Guba' => '028',
    'Hipodromo' => '029', 'Inayawan' => '030', 'Kalubihan' => '031', 'Kalunasan' => '032',
    'Kamagayan' => '033', 'Kamputhaw' => '034', 'Kasambagan' => '035', 'Kinasang-an' => '036',
    'Labangon' => '037', 'Lahug' => '038', 'Lorega' => '039', 'Lusaran' => '040',
    'Mabini' => '041', 'Mabolo' => '042', 'Malubog' => '043', 'Mambaling' => '044',
    'Pahina Central' => '045', 'Pamutan' => '046', 'Pardo' => '047', 'Pari-an' => '048',
    'Paril' => '049', 'Pasil' => '050', 'Pit-os' => '051', 'Pulangbato' => '052',
    'Pung-ol' => '053', 'Punta Princesa' => '054', 'Quiot' => '055', 'Sambag I' => '056',
    'Sambag II' => '057', 'San Antonio' => '058', 'San Jose' => '059', 'San Nicolas Pahina' => '060',
    'San Nicolas Proper' => '061', 'San Roque' => '062', 'Sapangdaku' => '063', 'Sawang Calero' => '064',
    'Sinsin' => '065', 'Sirao' => '066', 'Sta. Cruz' => '067', 'Sto. Niño' => '068',
    'Suba' => '069', 'Sudlon I' => '070', 'Sudlon II' => '071', 'T.Padilla' => '072',
    'Tabunan' => '073', 'Tagbao' => '074', 'Talamban' => '075', 'TapTap' => '076',
    'Tejero' => '077', 'Tinago' => '078', 'Tisa' => '079', 'Toong' => '080', 'Zapatera' => '081'
];
return [
    // Health area => color ug lista sa barangay (kinahanglan parehas ang spelling sa config/barangays.php)
    'areas' => [
        'CENTRAL HEALTH AREA' => [
            'color' => '#b4c7e7',
            'barangays' => ['Babag','Bo.Luz','Busay','Capitol','Carreta','Hipodromo','Kalunasan',
                            'Kamputhaw','Lahug','Malubog','Pung-ol','Sapangdaku'],
        ],
        'EAST HEALTH AREA' => [
            'color' => '#f4b6b6',
            'barangays' => ['Cogon Ramos','Day-as','Ermita','Kalubihan','Kamagayan','Lorega','Pahina Central',
                            'Pari-an','Pasil','Sambag I','Sambag II','San Antonio','San Roque','Sta. Cruz',
                            'Sto. Niño','Suba','T.Padilla','Tejero','Tinago','Zapatera'],
        ],
        'NORTH HEALTH AREA' => [
            'color' => '#c6e0b4',
            'barangays' => ['Adlaon','Agsungot','Apas','Bacayan','Banilad','Binaliw','Budlaan','Cambinocot',
                            'Guba','Kasambagan','Lusaran','Mabini','Mabolo','Paril','Pit-os','Pulangbato',
                            'San Jose','Sirao','Tabunan','Tagbao','Talamban','TapTap'],
        ],
        'SOUTH HEALTH AREA' => [
            'color' => '#ffe699',
            'barangays' => ['Basak Pardo','Basak San Nicolas','Bonbon','Buhisan','Bulacao','Bout-Taup',
                            'Cogon Pardo','Inayawan','Kinasang-an','Mambaling','Pamutan','Pardo','Quiot',
                            'Sinsin','Sudlon I','Sudlon II','Toong'],
        ],
        'WEST HEALTH AREA' => [
            'color' => '#d9c3e6',
            'barangays' => ['Calamba','Duljo','Guadalupe','Banawa','Labangon','Punta Princesa',
                            'San Nicolas Proper','San Nicolas Pahina','Sawang Calero','Tisa'],
        ],
    ],

    // Population kada barangay para sa Biting Incidence Rate. Pananglitan: 'Babag' => 6260
    'population' => [
        // 'Babag' => 0,
    ],
];