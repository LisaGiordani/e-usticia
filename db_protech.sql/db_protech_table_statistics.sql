
-- --------------------------------------------------------

--
-- Structure de la table `statistics`
--

CREATE TABLE `statistics` (
  `id` int(11) NOT NULL,
  `recipientId` text CHARACTER SET utf8 COLLATE utf8_general_ci,
  `date` date NOT NULL,
  `count_tweets` int(11) NOT NULL,
  `count_bullying` int(11) NOT NULL,
  `pourcentage` int(11) NOT NULL,
  `vp` int(11) NOT NULL,
  `fp` int(11) NOT NULL,
  `vn` int(11) NOT NULL,
  `fn` int(11) NOT NULL,
  `fpRate` float NOT NULL,
  `fnRate` float NOT NULL,
  `recall` float NOT NULL,
  `vpp` float NOT NULL,
  `fScore` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
