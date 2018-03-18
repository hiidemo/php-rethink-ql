<?php
declare(strict_types=1);

namespace TBolier\RethinkQL\Query;

use TBolier\RethinkQL\Message\Message;
use TBolier\RethinkQL\Message\MessageInterface;
use TBolier\RethinkQL\Query\Manipulation\ManipulationInterface;
use TBolier\RethinkQL\RethinkInterface;

class Builder implements BuilderInterface
{
    /**
     * @var DatabaseInterface
     */
    private $database;

    /**
     * @var MessageInterface
     */
    private $message;

    /**
     * @var OrdeningInterface
     */
    private $ordering;

    /**
     * @var RethinkInterface
     */
    private $rethink;

    /**
     * @var ManipulationInterface
     */
    private $row;

    /**
     * @var Table
     */
    private $table;

    /**
     * @param RethinkInterface $rethink
     */
    public function __construct(RethinkInterface $rethink)
    {
        $this->rethink = $rethink;
    }

    /**
     * @param string $name
     * @return TableInterface
     */
    public function table(string $name): TableInterface
    {
        if ($this->table) {
            unset($this->table);
        }

        $this->table = new Table($name, $this->rethink, new Message());

        return $this->table;
    }

    /**
     * @return DatabaseInterface
     */
    public function database(): DatabaseInterface
    {
        if ($this->database) {
            unset($this->database);
        }

        $this->database = new Database($this->rethink, new Message());

        return $this->database;
    }

    /**
     * @param string $key
     * @return OrdeningInterface
     */
    public function ordening(string $key): OrdeningInterface
    {
        if ($this->ordering) {
            unset($this->ordering);
        }

        $this->ordering = new Ordening($key, $this->rethink, new Message());

        return $this->ordering;
    }

    /**
     * @param string $value
     * @return ManipulationInterface
     */
    public function row(string $value): ManipulationInterface
    {
        $this->row = new Row($this->rethink, new Message(), $value);

        return $this->row;
    }
}
