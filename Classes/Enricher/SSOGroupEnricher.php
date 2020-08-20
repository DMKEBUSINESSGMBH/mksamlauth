<?php

declare(strict_types=1);

namespace DMK\MKSamlAuth\Enricher;

use DMK\MKSamlAuth\Model\FrontendUser;
use Doctrine\DBAL\Connection;
use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Core\Utility\GeneralUtility;

class SSOGroupEnricher implements EnricherInterface
{
    public const ATTRIBUTE_KEY = 'memberof';

    public function process(FrontendUser $user, array $context)
    {
        $names = $context['attributes'][self::ATTRIBUTE_KEY] ?? [];
        $names = \is_array($names) ? $names : [$names];

        if (0 === \count($names)) {
            return;
        }

        $qb = GeneralUtility::makeInstance(ConnectionPool::class)
            ->getQueryBuilderForTable('tx_mksamlauth_domain_model_group_mapping');

        $qb->select('e.group_ids');
        $qb->from('tx_mksamlauth_domain_model_group_mapping', 'e');
        $qb->where($qb->expr()->andX(
            $qb->expr()->eq('e.idp_id', ':id'),
            $qb->expr()->in('e.idp_name', ':names')
        ));
        $qb->setParameter('id', $context['idp']['rootPageUid']);
        $qb->setParameter('names', $names, Connection::PARAM_STR_ARRAY);

        $groups = $qb->execute()->fetchAll();

        // If there are no groups, we don't want to override them.
        if (0 === \count($groups)) {
            return;
        }

        $groups = array_map('current', $groups);
        $groups = implode(',', $groups);

        $user->setProperty('usergroup', $groups);
    }
}
