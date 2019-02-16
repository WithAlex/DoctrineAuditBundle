<?php

namespace WithAlex\DoctrineAuditBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class AuditController extends AbstractController
{
    /**
     * @Route("/audit", name="with_alex_doctrine_audit_list_audits", methods={"GET"})
     */
    public function listAuditsAction()
    {
        $reader = $this->container->get('with_alex_doctrine_audit.reader');
        $reader->getEntities();

        return $this->render('@WithAlexDoctrineAudit/Audit/audited_entities.html.twig', [
            'audited' => $reader->getEntities(),
        ]);
    }

    /**
     * @Route("/audit/{entity}/{id}", name="with_alex_doctrine_audit_show_entity_history", methods={"GET"})
     */
    public function showEntityHistoryAction(string $entity, int $id = null, int $page = 1, int $pageSize = 50)
    {
        $reader = $this->container->get('with_alex_doctrine_audit.reader');
        $entries = $reader->getAudits($entity, $id, $page, $pageSize);

        return $this->render('@WithAlexDoctrineAudit/Audit/entity_history.html.twig', [
            'entity' => $entity,
            'entries' => $entries,
        ]);
    }

    /**
     * @Route("/audit/details/{entity}/{id}", name="with_alex_doctrine_audit_show_audit_entry", methods={"GET"})
     */
    public function showAuditEntryAction(string $entity, int $id)
    {
        $reader = $this->container->get('with_alex_doctrine_audit.reader');
        $data = $reader->getAudit($entity, $id);

        return $this->render('@WithAlexDoctrineAudit/Audit/entity_audit_details.html.twig', [
            'entity' => $entity,
            'entry' => $data[0],
        ]);
    }
}
