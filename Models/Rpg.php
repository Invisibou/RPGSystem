<?php

class Rpg
{
    private ?int $id;
    private string $tableName;
    private string $description;
    private array $combatLog;
    private string $accessCode;
    private ?string $backgroundMapUrl;

    public function __construct(string $tableName, string $description)
    {
        $this->id = null; // The ID is null because the database hasn't generated it yet
        $this->tableName = $tableName;
        $this->description = $description;
        $this->combatLog = []; // The log starts empty
        $this->backgroundMapUrl = null;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTableName(): string
    {
        return $this->tableName;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function getCombatLog(): array
    {
        return $this->combatLog;
    }

    public function getAccessCode(): ?string
    {
        return $this->accessCode;
    }

    public function getBackgroundMapUrl(): ?string
    {
        return $this->backgroundMapUrl;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function setTableName(string $name): void
    {
        $this->tableName = $name;
    }

    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

    public function setCombatLog(array $log): void
    {
        $this->combatLog = $log;
    }


    public function setAccessCode(string $code): void
    {
        $this->accessCode = $code;
    }

    public function setBackgroundMapUrl(string $url): void
    {
        $this->backgroundMapUrl = $url;
    }
}
