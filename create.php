<?php

try

{

$database = new PDO('mysql:host=localhost;dbname=test;charset=utf8', 'root', '', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));

}

catch (Exception $e)

{

        die('Erreur : ' . $e->getMessage());

}
$result=$database->query("


CREATE TABLE `codes` (
  `ID` int(11) NOT NULL,
  `stock` varchar(30) NOT NULL,
  `code` varchar(10) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Contenu de la table `codes`
--

INSERT INTO `codes` (`ID`, `stock`, `code`) VALUES
(1, 'AB SCIENCE', 'AB'),
(2, 'ABC ARBITRAGE', 'ABCA'),
(3, 'ABEO', 'ABEO'),
(4, 'ABIVAX', 'ABVX'),
(5, 'ACCOR HOTELS', 'AC'),
(6, 'ACTEOS', 'EOS'),
(7, 'ACTIA GROUP', 'ATI'),
(8, 'ADL PARTNER', 'ALP'),
(9, 'ADOCIA', 'ADOC'),
(10, 'ADP', 'ADP'),
(11, 'ADUX', 'ADUX'),
(12, 'ADVENIS', 'ADV'),
(13, 'AFFINE', 'IML'),
(14, 'AIR FRANCE KLM', 'AF'),
(15, 'AIR LIQUIDE', 'AI'),
(16, 'AIRBUS', 'AIR'),
(17, 'ALBIOMA', 'ABIO'),
(18, 'COMPAGNIE DES ALPES', 'CDA'),
(19, 'ALSTOM', 'ALO'),
(20, 'ALTAMIR', 'LTA'),
(21, 'ALTEN', 'ATE'),
(22, 'ALTRAN', 'ALT'),
(23, 'ALTUR INVESTISSEMENT', 'ALTUR'),
(24, 'AMOEBA BIOCIDE', 'AMEBA'),
(25, 'AMPLITUDE SURGICAL', 'AMPLI'),
(26, 'AMUNDI', 'AMUN'),
(27, 'ANF IMMOBILIER', 'ANF'),
(28, 'APERAM', 'APAM'),
(29, 'ARCELOR MITTAL', 'MT'),
(30, 'ARCHOS', 'JXR'),
(31, 'ARKEMA', 'AKE'),
(32, 'ARTPRICE COM', 'PRC'),
(33, 'ASK', 'ASK'),
(34, 'ASSYSTEM', 'ASY'),
(35, 'AST GROUPE', 'ASP'),
(36, 'ATARI', 'ATA'),
(37, 'ATEME', 'ATEME'),
(38, 'ATOS', 'ATO'),
(39, 'AUBAY', 'AUB'),
(40, 'AUFEMININ', 'FEM'),
(41, 'AUREA', 'AURE'),
(42, 'AURES TECHNOLOGIES', 'AURS'),
(43, 'AVENIR TELECOM', 'AVT'),
(44, 'AVIATION LATECOERE', 'LAT'),
(45, 'AWOX', 'AWOX'),
(46, 'AXA', 'CS'),
(47, 'AXWAY SOFTWARE', 'AXW'),
(48, 'BASTIDE LE CONFORT', 'BLC'),
(49, 'BELIER', 'BELI'),
(50, 'BENETEAU', 'BEN'),
(51, 'BIC', 'BB'),
(52, 'BIGBEN INTERACTIVE', 'BIG'),
(53, 'BIOMERIEUX', 'BIM'),
(54, 'BLUE SOLUTIONS', 'BLUE'),
(55, 'BNP PARIBAS', 'BNP'),
(56, 'BOIRON', 'BOI'),
(57, 'BOLLORE', 'BOL'),
(58, 'BONDUELLE', 'BON'),
(59, 'BOURBON CORPORATION', 'GBB'),
(60, 'BOUYGUES', 'EN'),
(61, 'BUREAU VERITAS', 'BVI'),
(62, 'BUSINESS ET DECIS.', 'BND'),
(63, 'CAP GEMINI', 'CAP'),
(64, 'CAPELLI', 'CAPLI'),
(65, 'CARREFOUR', 'CA'),
(66, 'CASINO GUICHARD', 'CO'),
(67, 'CAST', 'CAS'),
(68, 'CATANA GROUP', 'CATG'),
(69, 'CATERING INTL SCES', 'CTRG'),
(70, 'CBO TERRITORIA', 'CBOT'),
(71, 'CELLNOVO GROUP', 'CLNV'),
(72, 'CERENIS THERAPEUTICS', 'CEREN'),
(73, 'CGG', 'CGG'),
(74, 'CHARGEURS', 'CRI'),
(75, 'CIBOX INTER A CTIV', 'CIB'),
(76, 'CLARANOVA', 'CLA'),
(77, 'CNIM CONSTR.FRF 10', 'COM'),
(78, 'CNP ASSURANCES', 'CNP'),
(79, 'COFACE', 'COFA'),
(80, 'COHERIS', 'COH'),
(81, 'CREDIT AGRICOLE', 'ACA'),
(82, 'CS (COM. ET SYSTEMES)', 'SX'),
(83, 'DALENYS', 'NYS'),
(84, 'DALET', 'DLT'),
(85, 'DANONE', 'BN'),
(86, 'DASSAULT AVIATION', 'AM'),
(87, 'DASSAULT SYSTEMES', 'DSY'),
(88, 'DBV TECHNOLOGIES', 'DBV'),
(89, 'DELTA PLUS GROUP', 'DLTA'),
(90, 'DERICHEBOURG', 'DBG'),
(91, 'DEVOTEAM', 'DVT'),
(92, 'DIAGNOSTIC MEDICAL', 'DGM'),
(93, 'DIRECT ENERGIE', 'DIREN'),
(94, 'DNXCORP', 'DNX'),
(95, 'DOM SECURITY', 'DOMS'),
(96, 'ECA', 'ECASA'),
(97, 'EDENRED', 'EDEN'),
(98, 'EDF', 'EDF'),
(99, 'EGIDE', 'GID'),
(100, 'EIFFAGE', 'FGR'),
(101, 'EKINOPS', 'EKI'),
(102, 'ELECTRO POWER SYSTEMS', 'EPS'),
(103, 'ELIOR GROUP', 'ELIOR'),
(104, 'ELIS', 'ELIS'),
(105, 'ENCRES DUBUIT', 'DBT'),
(106, 'ENGIE', 'ENGI'),
(107, 'EOS IMAGING', 'EOSI'),
(108, 'ERAMET', 'ERA'),
(109, 'ERYTECH PHARMA', 'ERYP'),
(110, 'ESI GROUP', 'ESI'),
(111, 'ESSILOR INTL', 'EI'),
(112, 'ESSO', 'ES'),
(113, 'EULER HERMES GROUP', 'ELE'),
(114, 'EURAZEO', 'RF'),
(115, 'EURO DISNEY', 'EDL'),
(116, 'EUROFINS SCIENT.', 'ERF'),
(117, 'EURONEXT', 'ENX'),
(118, 'EUROPACORP', 'ECP'),
(119, 'EUROPCAR GROUPE', 'EUCAR'),
(120, 'EUTELSAT COM.', 'ETL'),
(121, 'EXEL INDUSTRIES A', 'EXE'),
(122, 'FAURECIA', 'EO'),
(123, 'FERMENTALG', 'FALG'),
(124, 'FIGEAC AERO', 'FGA'),
(125, 'FLEURY MICHON', 'FLE'),
(126, 'FONCIERE DES REGIONS', 'FDR'),
(127, 'FONCIERE PARIS NORD', 'FPN'),
(128, 'GECI INTL', 'GECP'),
(129, 'GECINA NOM.', 'GFC'),
(130, 'GEMALTO', 'GTO'),
(131, 'GENERIX', 'GENX'),
(132, 'GENEURO', 'GNRO'),
(133, 'GENFIT', 'GNFT'),
(134, 'GENKYOTEX', 'GKTX'),
(135, 'GENOMIC VISION', 'GV'),
(136, 'GFI INFORMATIQUE', 'GFI'),
(137, 'GL EVENTS', 'GLO'),
(138, 'GROUPE CRIT', 'CEN'),
(139, 'GROUPE EUROTUNNEL', 'GET'),
(140, 'GROUPE FLO', 'FLO'),
(141, 'GROUPE FNAC', 'FNAC'),
(142, 'GROUPE GORGE', 'GOE'),
(143, 'GROUPE LDLC', 'LDL'),
(144, 'GROUPE OPEN', 'OPN'),
(145, 'GROUPE PARTOUCHE', 'PARP'),
(146, 'GTT', 'GTT'),
(147, 'GUERBET', 'GBT'),
(148, 'GUILLEMOT', 'GUI'),
(149, 'HAULOTTE GROUP', 'PIG'),
(150, 'HAVAS', 'HAV'),
(151, 'HERMES', 'RMS'),
(152, 'HF', 'HF'),
(153, 'HIGH CO', 'HCO'),
(154, 'HIPAY GROUP', 'HIPAY'),
(155, 'HOPSCOTCH GROUPE', 'HOP'),
(156, 'ICADE', 'ICAD'),
(157, 'ID LOGISTICS', 'IDL'),
(158, 'IGE + XAO', 'IGE'),
(159, 'ILIAD', 'ILD'),
(160, 'IMERYS', 'NK'),
(161, 'IMPLANET', 'ALIMP'),
(162, 'INFOTEL', 'INF'),
(163, 'INGENICO GROUP', 'ING'),
(164, 'INNATE PHARMA', 'IPH'),
(165, 'INNELEC MULTIMEDIA', 'INN'),
(166, 'INSIDE SECURE', 'INSD'),
(167, 'INTERPARFUMS', 'ITP'),
(168, 'INVENTIVA', 'IVA'),
(169, 'IPSEN', 'IPN'),
(170, 'IPSOS', 'IPS'),
(171, 'IT LINK', 'ITL'),
(172, 'ITESOFT', 'ITE'),
(173, 'ITS GROUP', 'ITS'),
(174, 'JACQUET METALS', 'JCQ'),
(175, 'JC DECAUX SA.', 'DEC'),
(176, 'KAUFMAN ET BROAD', 'KOF'),
(177, 'KERING', 'KER'),
(178, 'KEYRUS', 'KEY'),
(179, 'KLEPIERRE', 'LI'),
(180, 'KORIAN', 'KORI'),
(181, 'LAFARGEHOLCIM', 'LHN'),
(182, 'LAGARDERE', 'MMB'),
(183, 'LE NOBLE AGE', 'LNA'),
(184, 'LECTRA', 'LSS'),
(185, 'LEGRAND SA', 'LR'),
(186, 'LINEDATA SERVICES', 'LIN'),
(187, 'L\'OREAL', 'OR'),
(188, 'LVMH', 'MC'),
(189, 'MAISONS DU MONDE', 'MDM'),
(190, 'MAISONS FRANCE', 'MFC'),
(191, 'MANITOU BF', 'MTU'),
(192, 'MANUTAN INTL', 'MAN'),
(193, 'MARIE BRIZARD WINE AND SPIRITS', 'MBWS'),
(194, 'MAUNA KEA', 'MKEA'),
(195, 'MCPHY ENERGY', 'MCPHY'),
(196, 'MECELEC', 'ALMEC'),
(197, 'MEDASYS', 'MED'),
(198, 'MEDIAWAN', 'MDW'),
(199, 'MEMSCAP', 'MEMS'),
(200, 'MERCIALYS', 'MERY'),
(201, 'MERSEN', 'MRN'),
(202, 'METABOLIC EXPLORER', 'METEX'),
(203, 'METROPOLE TV', 'MMT'),
(204, 'MGI COUTIER', 'MGIC'),
(205, 'MICHELIN', 'ML'),
(206, 'MICROPOLE', 'MUN'),
(207, 'MND', 'MND'),
(208, 'NANOBIOTIX', 'NANO'),
(209, 'NATIXIS', 'KN'),
(210, 'NATUREX', 'NRX'),
(211, 'NEOPOST', 'NEO'),
(212, 'NETGEM', 'NTG'),
(213, 'NEXANS', 'NEX'),
(214, 'NEXITY', 'NXI'),
(215, 'NICOX', 'COX'),
(216, 'NOKIA', 'NOKIA'),
(217, 'NRJ GROUP', 'NRG'),
(218, 'OENEO', 'SBT'),
(219, 'OLYMPIQUE LYONNAIS (GROUPE)', 'OLG'),
(220, 'ONXEO', 'ONXEO'),
(221, 'ORANGE', 'ORA'),
(222, 'ORAPI', 'ORAP'),
(223, 'ORCHESTRA-PREMAMAN', 'KAZI'),
(224, 'ORPEA', 'ORP'),
(225, 'OSE IMMUNOTHERAPEUTICS', 'OSE'),
(226, 'PAREF', 'PAR'),
(227, 'PARROT', 'PARRO'),
(228, 'PCAS', 'PCA'),
(229, 'PERNOD RICARD', 'RI'),
(230, 'PEUGEOT', 'UG'),
(231, 'PHARMAGEST INTER.', 'PHA'),
(232, 'PIERRE VACANCES', 'VAC'),
(233, 'PIXIUM VISION', 'PIX'),
(234, 'PLAST. VAL DE LOIRE', 'PVL'),
(235, 'PLASTIC OMNIUM', 'POM'),
(236, 'POXEL', 'POXEL'),
(237, 'PRECIA', 'PREC'),
(238, 'PROLOGUE', 'PROL'),
(239, 'PSB INDUSTRIES', 'PSB'),
(240, 'PUBLICIS GROUPE', 'PUB'),
(241, 'QUANTEL', 'QUA'),
(242, 'RECYLEX', 'RX'),
(243, 'REMY COINTREAU', 'RCO'),
(244, 'RENAULT', 'RNO'),
(245, 'REXEL', 'RXL'),
(246, 'RIBER', 'RIB'),
(247, 'RUBIS', 'RUI'),
(248, 'SAFE ORTHOPAEDICS', 'SAFOR'),
(249, 'SAFRAN', 'SAF'),
(250, 'SAINT GOBAIN', 'SGO'),
(251, 'SANOFI', 'SAN'),
(252, 'SARTORIUS STEDIM BIOTECH', 'DIM'),
(253, 'SCBSM', 'CBSM'),
(254, 'SCHNEIDER ELECTRIC', 'SU'),
(255, 'SCOR', 'SCR'),
(256, 'SEB', 'SK'),
(257, 'SECHE ENVIRONNEMENT', 'SCHP'),
(258, 'SEQUANA', 'SEQ'),
(259, 'SERGEFERRARI GROUP', 'SEFER'),
(260, 'SES IMAGOTAG', 'SESL'),
(261, 'SES SA', 'SESG'),
(262, 'SFR GROUP', 'SFR'),
(263, 'SHOWROOMPRIVE', 'SRP'),
(264, 'SIPH', 'SIPH'),
(265, 'SMTPC', 'SMTPC'),
(266, 'SOCIETE GENERALE', 'GLE'),
(267, 'SODEXO', 'SW'),
(268, 'SOFT COMPUTING', 'SFT'),
(269, 'SOGECLAIR', 'SOG'),
(270, 'SOITEC SILICON', 'SOI'),
(271, 'SOLOCAL GROUP', 'LOCAL'),
(272, 'SOPRA STERIA GROUP', 'SOP'),
(273, 'SPIE', 'SPIE'),
(274, 'SQLI REGR.', 'SQI'),
(275, 'ST DUPONT', 'DPT'),
(276, 'STALLERGENES GREER', 'STAGR'),
(277, 'STEF', 'STF'),
(278, 'STENTYS', 'STNT'),
(279, 'STMICROELECTRONICS', 'STM'),
(280, 'SUEZ ENVIRONNEMENT', 'SEV'),
(281, 'SUPERSONIC IMAGINE', 'SSI'),
(282, 'SWORD GROUP', 'SWP'),
(283, 'SYNERGIE', 'SDG'),
(284, 'TARKETT', 'TKTT'),
(285, 'TECHNICOLOR', 'TCH'),
(286, 'TECHNIPFMC', 'FTI'),
(287, 'TELEPERFORMANCE', 'RCF'),
(288, 'TF1', 'TFI'),
(289, 'THALES', 'HO'),
(290, 'TIVOLY', 'TVLY'),
(291, 'TOTAL', 'FP'),
(292, 'TOUAX', 'TOUP'),
(293, 'TRANSGENE', 'TNG'),
(294, 'TRIGANO', 'TRI'),
(295, 'TXCELL', 'TXCL'),
(296, 'U10', 'UDIS'),
(297, 'UBI SOFT ENTERTAIN', 'UBI'),
(298, 'UNIBAIL-RODAMCO', 'UL'),
(299, 'UNION TECH.INFOR.', 'FPG'),
(300, 'VALEO', 'FR'),
(301, 'VALLOUREC', 'VK'),
(302, 'VALNEVA', 'VLA'),
(303, 'VEOLIA ENVIRON.', 'VIE'),
(304, 'VICAT', 'VCT'),
(305, 'VILMORIN CIE', 'RIN'),
(306, 'VINCI', 'DG'),
(307, 'VIRBAC', 'VIRP'),
(308, 'VIVENDI', 'VIV'),
(309, 'WAVESTONE', 'WAVE'),
(310, 'WENDEL INVEST.', 'MF'),
(311, 'WORLDLINE', 'WLN'),
(312, 'X-FAB', 'XFAB'),
(313, 'XILAM ANIMATION', 'XIL'),
(314, 'ZODIAC AEROSPACE', 'ZC');

-- --------------------------------------------------------

--
-- Structure de la table `news`
--

CREATE TABLE `news` (
  `ID` int(16) NOT NULL,
  `date` int(8) NOT NULL,
  `stock` varchar(30) NOT NULL,
  `price` float NOT NULL,
  `open` float NOT NULL,
  `closepreviousday` float NOT NULL,
  `daychange` float NOT NULL,
  `changecac40` float NOT NULL,
  `diffcac40` float NOT NULL,
  `price0905` float NOT NULL,
  `price0910` float NOT NULL,
  `momentum0905` float NOT NULL,
  `momentum0910` float NOT NULL,
  `gain0905` float NOT NULL,
  `gain0910` float NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Contenu de la table `news`
--

INSERT INTO `news` (`ID`, `date`, `stock`, `price`, `open`, `closepreviousday`, `daychange`, `changecac40`, `diffcac40`, `price0905`, `price0910`, `momentum0905`, `momentum0910`, `gain0905`, `gain0910`) VALUES
(31, 1503618664, 'ENGI', 14.5, 14.345, 14.315, 1.29, -0.03, 1.33, 14.365, 14.38, 0.14, 0.1, 0.94, 0.83),
(30, 1503618663, 'CBOT', 3.69, 3.71, 3.66, 0.82, -0.03, 0.85, 3.71, 3.7, 0, -0.27, -0.54, -0.27),
(28, 1503529119, 'HAV', 9.237, 9.244, 9.244, -0.08, -0.33, 0.25, 9.244, 0, 0, 0, -0.08, 0),
(26, 1503075600, 'HO', 93.35, 94.93, 94.99, -1.73, 0.45, -2.15, 94.5, 94.5, -0.45, 0, -1.22, -1.22),
(29, 1503618662, 'ALO', 30.34, 30.295, 30.205, 0.45, -0.03, 0.48, 30.295, 30.3, 0, 0.02, 0.15, 0.13),
(23, 1502467792, 'ADP', 142, 143.55, 143.75, -1.22, -1.03, -0.19, 142.45, 142.15, -0.77, -0.21, -0.32, -0.11);

--
-- Index pour les tables exportées
--

--
-- Index pour la table `codes`
--
ALTER TABLE `codes`
  ADD PRIMARY KEY (`ID`);

--
-- Index pour la table `news`
--
ALTER TABLE `news`
  ADD PRIMARY KEY (`ID`);

--
-- AUTO_INCREMENT pour les tables exportées
--

--
-- AUTO_INCREMENT pour la table `codes`
--
ALTER TABLE `codes`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=315;
--
-- AUTO_INCREMENT pour la table `news`
--
ALTER TABLE `news`
  MODIFY `ID` int(16) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

");

