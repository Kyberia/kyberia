<?php
namespace AppBundle\Service;

use AppBundle\Entity\Mail;
use AppBundle\Entity\Repository\MailRepository;
use AppBundle\Entity\User;
use AppBundle\Security\AuthenticatedUserAwareInterface;
use AppBundle\Security\AuthenticatedUserAwareTrait;
use Doctrine\ORM\EntityManagerInterface;

use Symfony\Component\OptionsResolver\OptionsResolver;

class MailService implements AuthenticatedUserAwareInterface
{
    use AuthenticatedUserAwareTrait;

    /** @var EntityManagerInterface */
    private $entityManager;

    /** @var MailRepository */
    private $mailRepository;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->mailRepository = $entityManager->getRepository(Mail::class);
    }

    /**
     * @return Mail[]
     */
    public function getConversationList(array $options = array())
    {
        $resolver = new OptionsResolver();
        $resolver->setDefaults(array(
            'onlyNew' => false
        ));
        $opts = $resolver->resolve($options);

        $userId = $this->authenticatedUser->getId();
        $lastMailIds = array_column($this->mailRepository->getAllLastMailIdAndRecipientUserId($userId), 'lastMailId');

        $criteria = [
            'userId' => $userId,
            'id' => $lastMailIds
        ];

        if ($opts['onlyNew'] === true)
            $criteria['isRead'] = 'no';

        $mails = $this->mailRepository->findBy($criteria, ['id' => 'DESC']);

        return $mails;
    }

    /**
     * @param int $recipientUserId
     *
     * @return Mail[]
     */
    public function getMessagesByRecipientUserId($recipientUserId)
    {
        $mails = $this->mailRepository->findAllMessagesBetweenUsers(
            $this->authenticatedUser->getId(),
            $recipientUserId
        );

        return $mails;
    }

    /**
     * @param int $conversationUserId
     */
    public function markConversationAsRead($conversationUserId)
    {
        $this->markConversationMessagesAsRead($conversationUserId);
        $this->updateUnreadMailCount();
    }

    /**
     * @param int $conversationUserId
     */
    public function markConversationMessagesAsRead($conversationUserId)
    {
        $this->mailRepository->markMailsAsRead($conversationUserId, $this->authenticatedUser->getId());
    }

    /**
     * @param int $userIdTo
     * @param string $text
     *
     * @return bool
     */
    public function sendMessage($userIdTo, $text)
    {
        $userIdFrom = $this->authenticatedUser->getId();

        $status = $this->entityManager->transactional(function ($em) use ($userIdFrom, $userIdTo, $text) {
            /** @var EntityManagerInterface $em */
            $now = new \DateTime();

            $mail = new Mail();
            $mail->setUserFrom($em->getReference(User::class, $userIdFrom));
            $mail->setUserTo($em->getReference(User::class, $userIdTo));
            $mail->setText($text);
            $mail->setCreatedAt($now);

            $duplicateMail = clone $mail;

            // original message for sender
            $mail->setUser($em->getReference(User::class, $userIdFrom));
            $em->persist($mail);

            // duplicate for recipient
            $duplicateMail->setDuplicateId($mail->getId());
            $duplicateMail->setUser($em->getReference(User::class, $userIdTo));
            $em->persist($duplicateMail);

            // increment unread mail count of recipient
            $em->createQueryBuilder()
                ->update(User::class, 'u')
                ->set('u.mailCount', '+1')
                ->set('u.userMailId', $userIdFrom)
                ->where('u.id = :userIdTo')
                ->setParameter('userIdTo', $userIdTo)
                ->getQuery()
                ->execute();
        });

        return $status;
    }

    /**
     * @return int
     */
    public function countUnreadMail() {
        $userId = $this->authenticatedUser->getId();

        return $this->mailRepository->countUnreadMail($userId);
    }

    /**
     * @return int
     */
    public function updateUnreadMailCount()
    {
        $count = $this->mailRepository->countUnreadMail($this->authenticatedUser->getId());

        $this->authenticatedUser->setMailCount($count);
        $this->entityManager->persist($this->authenticatedUser);
        $this->entityManager->flush();

        return $count;
    }
}
