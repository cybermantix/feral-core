<?php


namespace NoLoCo\Core\Builder\Process;


use NoLoCo\Core\Builder\Exception\BuilderException;
use NoLoCo\Core\Builder\Exception\InvalidBuildValueException;
use App\Entity\Accounts\V01\Store;
use App\Entity\Core\Process\V01\ProcessLog;
use App\Entity\Core\Process\V01\ProcessLogStatus;
use App\Utility\DateTime\DateTimeFormats;
use DateTime;
use DateTimeImmutable;
use Doctrine\ORM\EntityManagerInterface;

class ProcessLogBuilder
{
    protected ProcessLog $subject;

    public function __construct(
      protected EntityManagerInterface $entityManager
    ) {
    }

    /**
     * @param ProcessLog|null $subject
     * @return $this
     * @throws BuilderException
     */
    public function init(ProcessLog $subject = null): self
    {
        if ($subject) {
            $this->subject = $subject;
        } else {
            $this->subject = new ProcessLog();
            $this->withStatusId(ProcessLogStatus::WAITING);
        }
        if (!$this->subject->hasNotes()) {
            $this->subject->setNotes('');
        }
        return $this;
    }

    /**
     * @return $this
     * @throws BuilderException
     */
    public function dispatched(): self
    {
        $this->subject->setDateEvent(new DateTimeImmutable());
        $this->withStatusId(ProcessLogStatus::DISPATCHED);
        return $this;
    }

    /**
     * @return $this
     * @throws BuilderException
     */
    public function start(): self
    {
        $this->subject->setDateEvent(new DateTimeImmutable());
        $this->withStatusId(ProcessLogStatus::STARTED);
        return $this;
    }

    /**
     * @param string $notes
     * @return $this
     * @throws BuilderException
     */
    public function update(string $notes): self
    {
        $this->subject->setDateEvent(new DateTimeImmutable());
        $this
            ->appendNotes($notes)
            ->withStatusId(ProcessLogStatus::PROCESSING);
        return $this;
    }

    /**
     * @param string $notes
     * @return $this
     * @throws BuilderException
     */
    public function complete(string $notes): self
    {
        $this->subject->setDateEvent(new DateTimeImmutable());
        $this
            ->appendNotes($notes)
            ->withStatusId(ProcessLogStatus::COMPLETED);
        return $this;
    }

    /**
     * @param string $notes
     * @return $this
     * @throws BuilderException
     */
    public function error(string $notes): self
    {
        $this->subject->setDateEvent(new DateTimeImmutable());
        $this
            ->appendNotes('ERROR: ' . $notes)
            ->withStatusId(ProcessLogStatus::ERROR);
        return $this;
    }

    /**
     * @param string $instanceId
     * @return $this
     */
    public function withProcessInstanceId(string $instanceId): self
    {
        $this->subject->setInstanceId($instanceId);
        return $this;
    }

    /**
     * @param string $name
     * @return $this
     */
    public function withAlias(string $name): self
    {
        $this->subject->setAlias($name);
        return $this;
    }

    /**
     * @param Store $store
     * @return $this
     */
    public function withStore(Store $store): self
    {
        $this->subject->setStore($store);
        return $this;
    }

    /**
     * @param string $notes
     * @return $this
     */
    public function appendNotes(string $notes): self
    {
        $now = new DateTime();
        $existingNotes = $this->subject->getNotes();
        $updateNotes = sprintf(
            "%s%s) %s",
            !empty($existingNotes) ? $existingNotes . "\n" : '',
            $now->format(DateTimeFormats::LOG),
            $notes
        );
        $this->subject->setNotes($updateNotes);
        return $this;
    }

    /**
     * @param ProcessLogStatus $processLogStatus
     * @return $this
     */
    public function withStatus(ProcessLogStatus $processLogStatus) : self
    {
        $this->subject->setStatus($processLogStatus);
        return $this;
    }

    /**
     * @param int $id
     * @return ProcessLogStatus
     * @throws BuilderException
     */
    public function withStatusId(int $id): self
    {
        $status = $this->entityManager->find(ProcessLogStatus::class, $id);
        if (!$status) {
            throw new BuilderException(sprintf('Unknown status id "%uS"', $id));
        }
        return $this->withStatus($status);
    }

    /**
     * @return ProcessLog
     */
    public function build(): ProcessLog
    {
        return $this->subject;
    }
}
