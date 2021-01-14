
-- --------------------------------------------------------

--
-- Structure de la table `web_requests`
--

CREATE TABLE `web_requests` (
  `id` int(11) NOT NULL,
  `date` text NOT NULL,
  `recipientId` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `web_requests`
--

INSERT INTO `web_requests` (`id`, `date`, `recipientId`) VALUES
(7, '2020-12-22', 'ZemmourEric'),
(8, '2020-12-22', 'Cyrilhanouna'),
(10, '2020-12-22', 'MLP_officiel'),
(11, '2020-12-28', 'ZemmourEric'),
(13, '2020-12-28', 'SuperCazarre'),
(14, '2020-12-28', 'lenasituations'),
(15, '2020-12-28', 'iambilalangel'),
(16, '2020-12-28', 'EmmanuelMacron'),
(21, '2020-12-29', 'EmmanuelMacron'),
(23, '2020-12-29', 'ZemmourEric'),
(24, '2020-12-29', 'MLP_officiel'),
(26, '2021-01-03', 'MLP_officiel'),
(27, '2021-01-05', 'EmmanuelMacron'),
(28, '2021-01-08', 'MLP_officiel'),
(29, '2021-01-08', 'ZemmourEric'),
(30, '2021-01-08', 'EricZemmour'),
(31, '2021-01-08', 'EricZemmour'),
(32, '2021-01-08', 'ZemmourEric');
